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
        
        $num = $request->input('choiceNum');
        $res = "Counter of choice n°" . $num . " incremented !";
        
        return $res;
    }
}
