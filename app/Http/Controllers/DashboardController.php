<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get all the usefull informations of the answers at which the user has respond.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userID = Auth::id();

        $answers = DB::table('answers')
                    ->where('user_id', $userID)
                    ->get()
                    ->toArray();

        $questions = DB::table('questions')
                    ->get()
                    ->toArray();

        $choices = DB::table('choices')
                    ->get()
                    ->toArray();

        $user_questions = array_filter($questions, function($var) use($answers) {

            foreach($answers as $answer) {
                if($var->id == $answer->question_id) {
                    return true;
                }
            }
            return false;
        });
        
        $res = array();
        foreach($user_questions as $user_question) {

            $choice1 = null;
            $choice2 = null;
            foreach($choices as $choice) {

                if($choice->id == $user_question->choice_1_id) {
                    $choice1 = $choice;
                }

                if($choice->id == $user_question->choice_2_id) {
                    $choice2 = $choice;
                }
            }

            $user_choice = null;
            $user_answer_time = null;
            foreach($answers as $answer) {

                if($answer->question_id == $user_question->id) {
                    $user_choice = $answer->choice;
                    $user_answer_time = $answer->created_at;
                }
            }

            $totCounter = $choice1->counter + $choice2->counter;
            
            $res[$user_answer_time][$user_question->id] = array(
                '0' => array(
                    'text' => $choice1->text,
                    'counter' => $choice1->counter,
                    'perc' => round($choice1->counter / $totCounter * 100, 0)
                ),
                '1' => array(
                    'text' => $choice2->text,
                    'counter' => $choice2->counter,
                    'perc' => round($choice2->counter / $totCounter * 100, 0)
                ),
                'user_choice' => $user_choice
            );
        }

        krsort($res);
    /*
        $data = [
          'answers' => $answers,
          'questions' => $questions,
          'user_questions' => $user_questions,
          'choices' => $choices,
          'answer' => $res
        ];*/

        return view('pages.dashboard')->with('data', $res);
    }
}
