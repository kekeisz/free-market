<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show() {
        return view('page.mypage');
    }

    public function edit() {
        return view('page.profile');
    }

    public function list(Request $req) {
        return view('page.mypage_list',
        ['tab' => $req->query('page')]);
    }
}
