<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    public function index()
    {
      $data = array(
        "test" => "This a var for test from the HomeController@index !"
      );
      return view("home.index")->with($data);
    }
}
