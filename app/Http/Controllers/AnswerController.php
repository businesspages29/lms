<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\User;

class AnswerController extends Controller
{
    public function index($id)
    {
        try {
            $question = Question::findOrFail($id);
            if(request()->ajax()) {
                $answer = Answer::select('*')->where('question_id','=',$question->id);
                return datatables()->of($answer)
                ->addColumn('action', 'questions.answers.action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
            }
            return view('questions.answers.index',compact('question'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        try {
            $question = Question::findOrFail($id);
            return view('questions.answers.edit',compact('question'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question_id' => 'required',
            'content' => 'required',
            'is_correct' => 'required',
        ]);
        $input = $request->except('_token');
        $answer = Answer::query();
        if($input['is_correct'] == "true"){
            $input['is_correct'] = true;    
            $answer->where('question_id',$input['question_id'])->update([
                'is_correct' => false
            ]);
        }else{
            unset($input['is_correct']);
        }
        Answer::create($input);
        return redirect()->route('answers.index',$input['question_id'])
        ->with('success','Answer has been created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($question_id,$id)
    {
        try {
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
        $role = Answer::where('id',$input['id']);
        if($role){
            $role->delete();
        }
        return Response()->json($role);
        
    }
}
