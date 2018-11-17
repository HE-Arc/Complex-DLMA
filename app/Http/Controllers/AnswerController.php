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

        // choice number must be either 0 or 1, this prevents from user modification in the JS
        if(!($choiceNumber == 0 || $choiceNumber == 1))
            return "Ajax request did not send 0 or 1, aborting.";
        
        $questionID = $request->session()->get('questionID');

        // if user is not logged in
        if($userID == '')
            $this->incrementCounter($choiceNumber, $questionID);
        else
        {
            // if the user did not answer already, we need to increment the choice counter 
            // and insert its answer into the DB
            if(!$this->answerExists($userID, $questionID))
            {
                $this->incrementCounter($choiceNumber, $questionID);
                $this->insertAnswer($userID, $questionID, $choiceNumber);
            }
            // if he did already we do NOT increment the counter again but still update its answer
            else
                $this->updateAnswer($userID, $questionID, $choiceNumber);
        }
    
        $res = "User " . $userID . " incremented counter of the choice " . $choiceNumber . " in the question " . $questionID . " !";
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

    private function insertAnswer($userID, $questionID, $choiceNumber)
    {
        DB::table('answers')->insert(['user_id' => $userID, 'question_id' => $questionID,   'choice' => $choiceNumber]);       
    }

    private function updateAnswer($userID, $questionID, $choiceNumber)
    {
        DB::table('answers')->where('user_id', $userID)->where('question_id', $questionID)->update(['choice' => $choiceNumber]);
    }
}
