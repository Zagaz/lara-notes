<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
       echo "I'm inside the app!";
        // return view('index');
    }
    public function newNote()
    {
        echo "I'm creating a new note!";

    }

}
