<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show(Request $request) {
        /** @var User $user */
        $user = Auth::user();

        // /mypage?page=buy | sell | null
        // null のときは「どちらのタブも選択されていない」状態にしたいので、デフォルトは null にする
        $page = $request->query('page'); // デフォルト値はつけない

        // 出品した商品一覧
        $items = $user->items()
            ->latest()
            ->get();

        // 購入した商品一覧
        $boughtItems = $user->boughtItems()
            ->latest()
            ->get();

        return view('page.mypage', compact('user', 'items', 'boughtItems', 'page'));
    }

    public function edit() {
        $user = Auth::user();

        return view('page.profile', compact('user'));
    }

    public function update(ProfileUpdateRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validated();

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profiles', 'public');
            $validated['profile_image'] = $path;
        }

        $user->update($validated);

        return redirect()
            ->route('mypage.edit')
            ->with('status', 'プロフィールを更新しました。');
    }
}
