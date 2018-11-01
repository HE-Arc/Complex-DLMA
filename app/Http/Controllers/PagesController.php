<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    public function index()
    {
      $question = DB::table('questions')
                  ->select('id', 'choice_1', 'choice_2', 'counter_1', 'counter_2')
                  ->inRandomOrder()
                  ->first();

      $data = array(
        "question" => $question
      );
      return view("pages.index")->with($data);
    }
}
