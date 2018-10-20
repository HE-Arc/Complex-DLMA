<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class PagesController extends Controller
{
    public function index()
    {
      $data = array(
        "test" => "This a var for test from the PagesController@index !"
      );
      return view("pages.index")->with($data);
    }
}
