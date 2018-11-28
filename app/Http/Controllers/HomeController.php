<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Question;
use App\Choice;
use App\User;

class HomeController extends Controller
{
  /**
   * Called when the user come on the home page for the first time.
   * Get a new question in the db and update the question id in session
   */
  public function index(Request $request)
  {
    $data = $this->getNewQuestion();

    $data['homeController'] = $this;

    $request->session()->put('questionID', $data['question']->id);

    return view("pages.index")->with('data', $data);
  }

  /**
   * Get a new question in the db and update the question id in session
   */
  public function newQuestion(Request $request)
  {
    $data = $this->getNewQuestion();

    $request->session()->put('questionID', $data['question']->id);

    return $data;
  }

  /**
   * Get a new question in the db
   */
  private function getNewQuestion()
  {
    $question = Question::select('id', 'choice_1_id', 'choice_2_id')
                ->inRandomOrder()
                ->first();

    $data = [
      'question' => $question
    ];

    return $data;
  }

  /**
   * Ajax call of the method questionHeader
   */
  public function questionHeaderAjax(Request $request)
  {
    return $this->questionHeader($request->input('questionID'));
  }

  /**
   * Get the question header with the corresponding question id
   * Return a view
   */
  public function questionHeader($questionID)
  {
    $data = $this->getQuestionHeader($questionID);

    return view("inc.question_header")->with('data', $data);
  }

  /**
   * Get the question header with the corresponding question id
   */
  public function getQuestionHeader($questionID)
  {
    $question = Question::select('id', 'description', 'choice_1_id', 'choice_2_id')
                ->whereId($questionID)
                ->firstOrFail();

    $choice1 = Choice::findOrFail($question->choice_1_id);
    $choice2 = Choice::findOrfail($question->choice_2_id);

    $users = User::select('username')->get()->toArray();

    $data = [
      'question' => $question,
      'choice1Text' => $choice1->text,
      'choice2Text' => $choice2->text,
      'usernames' => $users
    ];

    return $data;
  }

  /**
   * Ajax call of the method questionDescription
   */
  public function questionDescriptionAjax(Request $request)
  {
    return $this->questionDescription($request->input('questionID'));
  }

  /**
   * Get the question description with the corresponding question id
   * Return a view
   */
  public function questionDescription($questionID)
  {
    $questionDescription = $this->getQuestionDescription($questionID);

    return view("inc.question_description")->with('data', $questionDescription);
  }

  /**
   * Get the question description with the corresponding question id
   */
  private function getQuestionDescription($questionID)
  {
    $question = Question::select('description')
                ->whereId($questionID)
                ->first();

    $data = [
      'question_description' => $question->description
    ];

    return $data;
  }

  /**
   * Ajax call of the method questionUsername
   */
  public function questionUsernameAjax(Request $request)
  {
    return $this->questionUsername($request->input('questionID'));
  }

  /**
   * Get the question username with the corresponding question id.
   * Return a view
   */
  public function questionUsername($questionID)
  {
    $questionUsername = $this->getQuestionUsername($questionID);

    return view("inc.question_username")->with('data', $questionUsername);
  }

  /**
   * Get the question username with the corresponding question id.
   */
  private function getQuestionUsername($questionID)
  {
    $question_user = DB::table('users')
                ->join('questions', 'questions.user_id', '=', 'users.id')
                ->select('users.username')
                ->where('questions.id', $questionID)
                ->first();

    $data = [
      'question_username' => $question_user->username
    ];

    return $data;
  }

  /**
   * Ajax call of the method questionChoice
   */
  public function questionChoiceAjax(Request $request)
  {
    return $this->questionChoice($request->input('choiceID'));
  }

  /**
   * Get the question choice with the corresponding choice id.
   * Return a view
   */
  public function questionChoice($choiceID)
  {
    $choice = $this->getQuestionChoice($choiceID);

    return view("inc.question_choice")->with('data', $choice);
  }

  /**
   * Get the choice with the corresponding choice id.
   */
  private function getQuestionChoice($choiceID)
  {
    $choice = DB::table('choices')
              ->select('text', 'counter')
              ->where('id', $choiceID)
              ->first();
    
    return $choice;
  }

  /**
   * Ajax call of the method questionCommentsCounter
   */
  public function questionCommentsCounterAjax(Request $request)
  {
    return $this->questionCommentsCounter($request->input('questionID'));
  }

  /**
   * Get the question comments counter with the corresponding question id.
   * Return a view
   */
  public function questionCommentsCounter($questionID)
  {
    $data = $this->getQuestionCommentsCounter($questionID);

    return view("inc.question_comments_counter")->with('data', $data);
  }

  /**
   * Get the question comments counter with the corresponding question id.
   */
  private function getQuestionCommentsCounter($questionID)
  {
    $commentsNumber = DB::table('comments')
                ->join('users', 'users.id', '=', 'comments.user_id')
                ->where('question_id', $questionID)
                ->count();

    $data = array(
      "commentsNumber" => $commentsNumber
    );

    return $data;
  }

  /**
   * Ajax call of the method questionComments
   */
  public function questionCommentsAjax(Request $request)
  {
    return $this->questionComments($request->input('questionID'));
  }

  /**
   * Get the question comments with the corresponding question id.
   * Return a view
   */
  public function questionComments($questionID)
  {
    $data = $this->getQuestionComments($questionID);

    return view("inc.question_comments")->with('data', $data);
  }

  /**
   * Get the question comments with the corresponding question id.
   */
  private function getQuestionComments($questionID)
  {
    $comments = DB::table('comments')
                ->join('users', 'users.id', '=', 'comments.user_id')
                ->select('comments.text', 'comments.created_at', 'users.username')
                ->where('question_id', $questionID)
                ->orderBy('comments.created_at', 'desc')
                ->get();

    $data = array(
      "comments" => $comments
    );

    return $data;
  }

  public function store(Request $request)
  {
    $userID = Auth::id();
    $questionID = $request->session()->get('questionID');
    $commentText = $request->input('commentText');

    DB::table('comments')->insert([
      'user_id' => $userID, 
      'question_id' => $questionID, 
      'text' => $commentText,
      'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
      'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),]);

    $response = "Return something";
    return $response;
  }

}
