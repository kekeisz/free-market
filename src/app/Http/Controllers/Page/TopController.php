<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->query('page');
        $keyword = $request->query('keyword');

        $isMylistPage = $page === 'mylist';

        if ($isMylistPage && !Auth::check()) {
            return view('page.top', [
                'items' => collect(),
                'page' => $page,
                'keyword' => $keyword,
            ]);
        }

        $query = Item::query()
            ->withCount(['likes', 'comments']);

        if (Auth::check()) {
            $query->where('user_id', '!=', Auth::id());
        }

        if (!empty($keyword)) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        if ($isMylistPage) {
            $query->whereHas('likes', function ($query) {
                $query->where('user_id', Auth::id());
            });
        }

        $items = $query->get();

        return view('page.top', [
            'items' => $items,
            'page' => $page,
            'keyword' => $keyword,
        ]);
    }
}
