<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $time = Carbon::now();
        $formatted_time = $time->format('Y-m-d H:i:s.u');

        return response()->json(['status' => true, 'time'=> $time, 'formatted_time'=>$formatted_time]);
    }
}
