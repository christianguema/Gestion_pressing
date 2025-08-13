<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RapportController extends Controller
{
    public function performanceRepport()
    {
        return view("rapports.performanceRepport");
    }


    public function repport()
    {
        return view("rapports.repport");
    }
}
