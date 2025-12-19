<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Http\Requests\LoginRequest;
use App\Http\Responses\LoginResponse;
use App\Http\Responses\RegisterResponse;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(LoginResponseContract::class, LoginResponse::class);
        $this->app->singleton(RegisterResponseContract::class, RegisterResponse::class);
    }

    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::loginView(function () {
            $previousUrl = url()->previous();
            $isAuthPage = str_contains($previousUrl, '/login') || str_contains($previousUrl, '/register');

            if (!session()->has('url.intended') && ! $isAuthPage) {
                session(['url.intended' => $previousUrl]);
            }

            return view('auth.login');
        });

        Fortify::registerView(fn () => view('auth.register'));

        Fortify::authenticateUsing(function (Request $request) {
            $loginRequest = app(\App\Http\Requests\LoginRequest::class);

            Validator::make(
                $request->all(),
                $loginRequest->rules(),
                $loginRequest->messages(),
                method_exists($loginRequest, 'attributes')
                    ? $loginRequest->attributes()
                    : []
            )->validate();

            $user = \App\Models\User::where('email', $request->input('email'))->first();

            if (! $user) {
                throw ValidationException::withMessages([
                    'email' => 'ログイン情報が登録されていません。',
                ]);
            }

            if (! Hash::check($request->input('password'), $user->password)) {
                throw ValidationException::withMessages([
                    'password' => 'パスワードが間違っています。',
                ]);
            }

            if (is_null($user->email_verified_at)) {
                throw ValidationException::withMessages([
                    'email' => 'メール認証が完了していません。'
                ]);
            }

            return $user;
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(
                Str::lower($request->input(Fortify::username())) . '|' . $request->ip()
            );

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
