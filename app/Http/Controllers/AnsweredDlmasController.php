<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Answer;

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
        $answers = Answer::where('user_id', Auth::id())
                    ->orderBy('updated_at', 'desc')
                    ->get();

        return view('pages.answered_dlmas')->with(['answers' => $answers]);
    }
}
