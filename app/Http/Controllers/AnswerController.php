<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function insertAnswer(Request $request)
    {
        $userID = Auth::id();
       
        // if user does not exist (IE anonymous), do not insert into DB
        if($userID != '')
        {
            $choice = $request->input('choiceID');
            $questionID = $request->session()->get('questionID');

            DB::table('answers')->insert([
                'user_id' => $userId, 'question_id' => $questionId, 'choice' => $choice
    
            ]);
        }
       
    }
}
