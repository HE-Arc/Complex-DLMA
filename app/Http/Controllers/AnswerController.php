<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Answer;
use App\Question;
use App\Choice;

class AnswerController extends Controller
{
    /**
     * Increment the question choice.
     * Create an answer for connected user.
     */
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
        {
            $this->incrementCounter($choiceNumber, $questionID);
        }
        else
        {
            $answer = $this->answerExists($userID, $questionID);

            // if the user did not answer already, we need to increment the choice counter 
            // and insert its answer into the DB
            if(!$answer)
            {
                $this->incrementCounter($choiceNumber, $questionID);

                $this->store($userID, $questionID, $choiceNumber);
            }
            // if he did already we do NOT increment the counter again but still gupdate its answer
            else
            {
                $this->update($userID, $questionID, $choiceNumber);
            }
        }
    
        return "";
    }

    /**
     * Increment the counter of a question choice.
     */
    private function incrementCounter($choiceNumber, $questionID)
    {
        $question = Question::findOrFail($questionID);

        $choice = $question->choice($choiceNumber);
        $choice->counter++;
        $choice->save();
    }

    /**
     * Check if a given answer exists in the DB
     */
    private function answerExists($userID, $questionID)
    {
        return Answer::where('user_id', $userID)
            ->where('question_id', $questionID)
            ->first();
    }

    /**
     * Create a new answer.
     */
    private function store($userID, $questionID, $choiceNumber)
    {
        $answer = new Answer;
        $answer->user_id = $userID;
        $answer->question_id = $questionID;
        $answer->choice = $choiceNumber;
        $answer->save();
    }

    /**
     * Update an answer and the choice counter.
     */
    private function update($userID, $questionID, $choiceNumber)
    {
        $answer = Answer::where('user_id', $userID)
                    ->where('question_id', $questionID)->first();

        $question = Question::find($questionID);

        $choice1 = $question->choice1()->first();
        $choice2 = $question->choice2()->first();
        if($answer->choice == 0)
        {
            $choice1->counter = $choice1->counter - 1;
        }
        else
        {
            $choice2->counter = $choice2->counter - 1;
        }
        if($choiceNumber == 0)
        {
            $choice1->counter = $choice1->counter + 1;
        }
        else
        {
            $choice2->counter = $choice2->counter + 1;
        }
        $choice1->save();
        $choice2->save();

        $answer->choice = $choiceNumber;
        $answer->save();
    }
}
