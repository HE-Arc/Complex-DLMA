<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Question;
use App\User;
use App\Choice;

class MyDlmasController extends Controller
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

        $user_questions = Question::findOrFail($userID);

        $choices = Choice::all();

        $questions = [];

        foreach($user_questions as $user_question) {
            
            $choice1 = null;
            $choice2 = null;
            $description = null;
            foreach($choices as $choice) {

                if($choice->id == $user_question['choice_1_id']) {
                    $choice1 = $choice;
                }

                if($choice->id == $user_question['choice_2_id']) {
                    $choice2 = $choice;
                }

                $description = $user_question['description'];
            }

            $questions[$user_question['created_at']] = [
                'choice_1_id' => $choice1
            ];
        }

        ksort($questions);

        return view('pages.my_dlmas')->with('questions', $questions);
    }
}
