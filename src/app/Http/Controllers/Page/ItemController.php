<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function show($item_id) {
        return view('page.item', compact('item_id'));
    }
}
