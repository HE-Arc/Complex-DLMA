<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnswerController extends Controller
{
    public function insertAnswer(Request $request)
    {
        $userID = Auth::id();
        // choice number is 0 or 1 (first or second choice)
        $choiceNumber = 0;
        // choice ID is the ID in the DB
        $choiceID = 0;
        $questionID = 0;
       
        // if user does not exist (IE anonymous), do not insert into DB
        if($userID != '')
        {
            $choiceNumber = $request->input('choiceID');
            $questionID = $request->session()->get('questionID');

            // insert the user answers in the associative table user question
            if(DB::table('answers')->where('user_id', $userID)->count() == 0)
            {
                DB::table('answers')->insert([
                    'user_id' => $userID, 'question_id' => $questionID, 'choice' => $choiceNumber
                ]);
    
            }
        }

        // get the question to increment the choices of
        $question = DB::table('questions')->whereId($questionID)->select('choice_1_id', 'choice_2_id')->first();
        
        // get the database ID of the choice to increment
        $choicesID = [$question->choice_1_id, $question->choice_2_id];
        $choiceID = $choicesID[$choiceNumber];
        
        // increment in the DB
        DB::table('choices')->whereId($choiceID)->increment('counter', 1);

        $res = "User " . $userID . " incremented counter of the choice " . $choiceID . " in the question " . $questionID . " !";
        return $res;
    }
}
