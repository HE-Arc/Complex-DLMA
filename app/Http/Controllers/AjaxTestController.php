<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxTestController extends Controller
{
    public function incrementCounter(Request $request)
    {
        // If the data to send is in json, that's an example
        //$msg = "Counter incremented !";
        //return response()->json(array('msg'=> $msg), 200);
        //$request = Request::instance();
        
        $userID = $request->input('userID');
        $questionID = $request->input('questionID');
        $choiceID = $request->input('choiceID');

        $res = "User " . $userID . " incremented counter of choice " . $choiceID . " of question " . $questionID . " !";
        
        return $res;
    }
}
