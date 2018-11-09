<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreateDlmaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $data = "string";
      return view("pages.create_dlma")->with("data", $data);
    }

    public function store()
    {

    }
}
