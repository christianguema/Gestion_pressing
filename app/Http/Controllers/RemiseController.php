<?php

namespace App\Http\Controllers;

use App\Models\Remise;
use Illuminate\Http\Request;

class RemiseController extends Controller
{
    public function index()
    {
        $remises = Remise::all();
        return view('Remises.index',compact("remises"));
    }

    public function create()
    {

    }

    public function store()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }


}
