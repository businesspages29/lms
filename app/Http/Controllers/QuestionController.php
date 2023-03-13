<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\User;

class QuestionController extends Controller
{
    public function index()
    {
        if(request()->ajax()) {
            $questions = Question::select('*')->with('user');
            
            return datatables()->of($questions)
            ->addColumn('action', 'questions.action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('questions.index'); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::pluck('name','id')->all();
        return view('questions.edit',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'timer' => 'required|numeric|min:15|max:600',
            'content' => 'required',
        ]);
        $input = $request->except('_token');
        Question::create($input);
        return redirect()->route('questions.index')
        ->with('success','Question has been created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $question = Question::findOrFail($id);
            if(request()->ajax()) {
                $question = Answer::select('*')->where('question_id',$question->question_id);
                return datatables()->of($question)
                ->addColumn('action', 'questions.answers.action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
            }
            return view('questions.show',compact('question'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $users = User::pluck('name','id')->all();
            $question = Question::findOrFail($id);
            return view('questions.edit',compact('users','question'));
        } catch (\Exception $e) {
            abort(404);
        }
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'user_id' => 'required',
            'timer' => 'required|numeric|min:15|max:600',
            'content' => 'required',
        ]);
        $input = $request->except('_token');
        try {
            $question = Question::findOrFail($id);
            if($question){
                $question->update($input);
            }
        return redirect()->route('questions.index')
            ->with('success','Question Has Been updated successfully');
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)// string $id
    {
        $input = $request->only('id');
        $role = Question::where('id',$input['id']);
        if($role){
            $role->delete();
        }
        return Response()->json($role);
        
    }
}
