<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function filterChoices($choices, $validIds)
    {
      // filters the choices to get only the one in the validIds array
      return array_filter($choices, function($choice) use ($validIds)
      {
        return in_array($choice->id, $validIds); 
      });
    }

    public function index()
    {
      $question = DB::table('questions')
                  ->select('id', 'title', 'choice_1_id', 'choice_2_id')
                  ->inRandomOrder()
                  ->first();
      $choices = DB::table('choices')->get();

      $arrayChoices = [];


      foreach($choices as $choice)
      {
        array_push($arrayChoices, $choice);
      }

      $validIds = [$question->choice_1_id, $question->choice_2_id];
      
      $choices = $this->filterChoices($arrayChoices, $validIds);

      $data = array(
        "question" => $question,
        "choices" => $choices
      );
      return view("pages.index")->with('data', $data);
    }
}
