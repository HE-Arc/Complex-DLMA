<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Answer;
use App\User;

class AnsweredDlmasController extends Controller
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

        $answers2 = Answer::where('user_id', $userID)
                    ->get();
                    
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

        $users = User::all();

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
            $description = null;
            foreach($choices as $choice) {

                if($choice->id == $user_question->choice_1_id) {
                    $choice1 = $choice;
                }

                if($choice->id == $user_question->choice_2_id) {
                    $choice2 = $choice;
                }

                $description = $user_question->description;
            }

            $user_choice = null;
            $user_answer_time = null;
            foreach($answers as $answer) {

                if($answer->question_id == $user_question->id) {
                    $user_choice = $answer->choice;
                    $user_answer_time = $answer->updated_at;
                }
            }

            $username = null;
            foreach($users as $user) {

                if($user_question->user_id == $user->id) {
                    $username = $user->username;
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
                'user_choice' => $user_choice,
                'question_description' => $description,
                'question_username' => $username
            );
        }

        krsort($res);
/*
        $data = [
            'answers' => $answers,
            'answers2' => $answers2
        ];*/

        return view('pages.answered_dlmas')->with('data', $res);
    }
}