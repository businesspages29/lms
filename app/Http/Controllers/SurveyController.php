<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function form()
    {
        $auth = auth()->user();
        $questions = $auth->questions;
        return view('survey.form',compact('questions'));
    }
    public function store(Request $request)
    {
        dd($request->all());
    }
}
