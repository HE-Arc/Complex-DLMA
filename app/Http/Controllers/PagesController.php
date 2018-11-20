<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
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
    $question->title = htmlentities($question->title);
    $choices = DB::table('choices')->get();
    $arrayChoices = [];
    foreach($choices as $choice)
    {
      array_push($arrayChoices, $choice);
      $choice->text = htmlentities($choice->text);
    }
    $validIds = [$question->choice_1_id, $question->choice_2_id];

    $choices = $this->filterChoices($arrayChoices, $validIds);


    $usernames = DB::table('users')->select('username')->get()->all();
    $usernames = collect($usernames)->map(function($x) { return (array) $x; })->toArray();
    $arrayUsernames = array();
    foreach($usernames as $username) {
      array_push($arrayUsernames, htmlentities($username["username"]));
    }


    $data = array(
      "question" => $question,
      "choices" => $choices,
      "usernames" => json_encode($arrayUsernames)
    );
    return view("pages.index")->with('data', $data);
  }

}
