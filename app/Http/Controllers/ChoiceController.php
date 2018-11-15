<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChoiceController extends Controller
{
    public function increment($id = 1)
    {
        DB::table('choices')->whereId($id)->increment('counter', 1);
    }
}
