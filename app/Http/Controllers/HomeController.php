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

  public function index(Request $request)
  {
    $question = DB::table('questions')
                ->select('id', 'title', 'choice_1_id', 'choice_2_id')
                ->inRandomOrder()
                ->first();
    $choices = DB::table('choices')->get();
    $comments = DB::table('comments')
                ->join('users', 'users.id', '=', 'comments.user_id')
                ->select('comments.text', 'comments.created_at', 'users.username')
                ->where('question_id', $question->id)->orderBy('comments.created_at')->get();
  
    $validIds = [$question->choice_1_id, $question->choice_2_id];
    
    // Return the values of the filtered choices 
    // $choices->all() returns the Illuminate collection as array
    // filter returns the IDs that belongs to the question
    $choices = array_values($this->filterChoices($choices->all(), $validIds));


    $data = array(
      "question" => $question,
      "choices" => $choices,
      "comments" => $comments
    );
    $request->session()->put('questionID', $question->id);
    return view("pages.index")->with('data', $data);
  }

  public function store(Request $request)
  {
    $userID = Auth::id();
    $questionID = $request->session()->get('questionID');
  }

}
