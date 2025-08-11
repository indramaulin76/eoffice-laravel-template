<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index()
    {
        return view('log.index');
    }

    public function show(Log $log)
    {
        return view('log.show', compact('log'));
    }
}
