<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AjaxTestController extends Controller
{
    public function incrementCounter(Request $request)
    {
        // If the data to send is in json, that's an example
        //$msg = "Counter incremented !";
        //return response()->json(array('msg'=> $msg), 200);
        //$request = Request::instance();
        
        $userID = Auth::id();
        if($userID == '')
        {
            $userID = -1;
        }

        $choiceID = $request->input('choiceID');
        $questionID = $request->session()->get('questionID');

        $res = "User " . $userID . " incremented counter of choice " . $choiceID . " of question " . $questionID . " !";
        
        return $res;
    }
}
