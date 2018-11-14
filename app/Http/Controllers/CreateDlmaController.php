<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\DlmaFormRequest;
use App\Question;
use App\Choice;

class CreateDlmaController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view("pages.create_dlma");
    }

    /**
     * Handle a DLMA creation request.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(DlmaFormRequest $request)
    {
      try
      {
        $validated = $request->validated(); // validate request

        // create choice 1 and push to db
        $choice_1 = new Choice;
        $choice_1->text = $request->get("choice_1");
        $choice_1->counter = 0;
        $choice_1->save();

        // create choice 2 and push to db
        $choice_2 = new Choice;
        $choice_2->text = $request->get("choice_2");
        $choice_2->counter = 0;
        $choice_2->save();

        // create question and push to db
        $question = new Question;
        $question->title = $request->get("title");
        $question->choice_1_id = $choice_1->id;
        $question->choice_2_id = $choice_2->id;
        $question->user_id = Auth::user()->id;;
        $question->report_counter = 0;
        $question->save();

        flash("Your DLMA has been submitted !")->success();
        return redirect()->route("createDlma.create");
      }
      catch (Exception $e) {}

      flash("Sorry, an error occured while creating your DLMA. Please retry later.")->error();
      return redirect()->route("createDlma.create");
    }
}
