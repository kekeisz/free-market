<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function confirm($item_id) {
        return view('page.purchase', compact('item_id'));
    }

    public function address($item_id) {
        return view('page.address', compact('item_id'));
    }
}
