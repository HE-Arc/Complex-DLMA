<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreateDlma extends Controller
{
    public function index()
    {
      $data = "string";
      return view("pages.create_dlma")->with("data", $data);
    }
}
