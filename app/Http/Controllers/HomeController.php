<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    public function index()
    {
      $users = User::all();
      return view("home.index", ["users" => $users]);
    }
}
