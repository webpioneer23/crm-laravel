<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        // $list = History::all();
        $list = History::orderBy('created_at', 'DESC')->paginate(25);
        return view("history.list", compact("list"));
    }
}
