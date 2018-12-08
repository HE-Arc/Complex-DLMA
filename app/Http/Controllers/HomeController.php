<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Question;
use App\Choice;
use App\User;
use App\Comment;

class HomeController extends Controller
{
  /**
   * Return the index page.
   * 
   * @param Request
   * @return view : index page view.
   */
  public function index(Request $request)
  {
    return view("pages.index");
  }

  /**
   * Get all partial views based on a specific question.
   * 
   * @param Request
   * @param Integer : the question id
   * @return view : index page view.
   */
  public function indexWithId(Request $request, $questionID)
  {
    $question = Question::findOrFail($questionID);
  
    return view("pages.index")->with(['questionID' => $questionID]);
  }

  /**
   * Get the question corresponding to the given question id.
   * 
   * @param Request
   * @return view[] : all the partial views.
   */
  public function fetchSpecificQuestionGenerateViews(Request $request)
  {
    $question = Question::findOrFail($request->input('questionID'));

    $request->session()->put('questionID', $question->id);

    return $this->getViews($question);
  }

  /**
   * Generate a random question and return all partial views.
   * 
   * @param Request
   * @return views[] : all the partials views based on the random question.
   */
  public function fetchNewQuestionGenerateViews(Request $request)
  {
    $question = Question::inRandomOrder()->first();

    $request->session()->put('questionID', $question->id);

    return $views = $this->getViews($question);
  }

  /**
   * Create and prepare all the partial views.
   * 
   * @param Question : the question
   * @return views[] : all the partials views based on the given question.
   */
  public function getViews($question)
  {
    // Header

    $choice1 = Choice::findOrFail($question->choice_1_id);
    $choice2 = Choice::findOrfail($question->choice_2_id);

    $usernames = User::select('username')->get()->toArray();

    $views = [];
    $views['header'] = view("questions.question_header")->with([
        'id' => $question->id,
        'choice1Text' => $choice1->text,
        'choice2Text' => $choice2->text,
        'description' => $question->description,
        'usernames' => $usernames
    ])->render();

    // Description
    
    $views['description'] = view("questions.question_description")
                              ->with(['description' => $question->description])
                              ->render();

    // Username

    $question_user = Question::find($question->id)->user()->first();

    $views['username'] = view("questions.question_username")
                            ->with(['username' => $question_user->username])
                            ->render();

    // Choices

    $views['choice1'] = view("questions.question_choice")->with([
        'text' => $choice1->text,
        'counter' => $choice1->counter
    ])->render();

    $views['choice2'] = view("questions.question_choice")->with([
        'text' => $choice2->text,
        'counter' => $choice2->counter
    ])->render();

    // Comments

    $comments = Comment::where('question_id', $question->id)
                    ->orderBy('created_at', 'desc')
                    ->get();

    $views['comments_number'] = view("questions.question_comments_counter")
                                  ->with(['comments_number' => $comments->count()])
                                  ->render();

    $views['comments'] = view("questions.question_comments")->with(['comments' => $comments])->render();

    return $views;
  }

  /**
   * Store a new comment.
   */
  public function store(Request $request)
  {
    $userID = Auth::id();
    $questionID = $request->session()->get('questionID');
    $commentText = $request->input('commentText');

    $comment = new Comment;
    $comment->user_id = $userID;
    $comment->question_id = $questionID;
    $comment->text = $commentText;
    $comment->save();

    $question = Question::findOrFail($questionID);

    return $this->getViews($question);
  }

}
