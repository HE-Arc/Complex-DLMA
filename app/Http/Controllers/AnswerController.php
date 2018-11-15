<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnswerController extends Controller
{
    public function dispatchRequest(Request $request)
    {
        $userID = Auth::id();

        // choice number should be 0 or 1 (first choice or 2nd)
        $choiceNumber = $request->input('choiceID');
        // choice ID is the ID in the DB

        // choice number must be either 0 or 1, this prevents from user modification
        if(!($choiceNumber == 0 || $choiceNumber == 1))
            return "Ajax request did not send 0 or 1, aborting.";
        
        $questionID = $request->session()->get('questionID');

        // if user is not logged in
        if($userID == '')
            incrementCounter($choiceNumber, $questionID);
        else
        {
            if(!answerExists($userID, $questionID))
                incrementCounter($choiceNumber, $questionID);
            insertUpdateAnswer($userID, $questionID, $choiceNumber);
        }
    
        $res = "User " . $userID . " incremented counter of the choice " . $choiceID . " in the question " . $questionID . " !";
        return $res;
    }

    private function incrementCounter($choiceNumber, $questionID)
    {
        // get the question to increment the choices of
        $question = DB::table('questions')->whereId($questionID)->select('choice_1_id', 'choice_2_id')->first();
    
        // get the database ID of the choice to increment
        $choicesID = [$question->choice_1_id, $question->choice_2_id];
        $choiceID = $choicesID[$choiceNumber];
        
        // increment in the DB
        DB::table('choices')->whereId($choiceID)->increment('counter', 1);
    }

    private function answerExists($userID, $questionID)
    {
        // refactor this to return DB::table as bool ?
        if(DB::table('answers')->where('user_id', $userID)->where('question_id', $questionID)->count() == 0)
            return false;
        else
            return true;
    }

    private function insertUpdateAnswer($userID, $questionID, $choiceNumber)
    {
        DB::table('answers')::updateOrCreate(['user_id' => $userID, 'question_id' => $questionID], ['choice' => $choiceNumber]);
        /*$userID = Auth::id();
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
        */
     

       
    }
}
