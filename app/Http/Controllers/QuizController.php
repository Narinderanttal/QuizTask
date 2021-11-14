<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\quiz_question;
use DB;
use Validator;
use Session;
use Redirect;
class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $question = quiz_question::all();
        return view('/home',['questions'=>$question]);  
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (empty($request->all())) 
        {
            return view('/addQuestion');
        }
        else
        {
            $validator = Validator::make($request->all(), [     
                'question_name' => 'required',
                'option_one' => 'required',
                'option_two' => 'required',
                'option_three' => 'required',
                'option_four' => 'required',
                'right_answer' => 'required',
            ]); 
            if($validator->fails())
            {
                 return redirect('add-qestion')
                  ->withErrors($validator)
                  ->withInput();
            }
            else
            {
                $question_name = $request->question_name;
                $option_one = $request->option_one;
                $option_two = $request->option_two;
                $option_three = $request->option_three;
                $option_four = $request->option_four;
                $right_answer = $request->right_answer;

                $addquestion = new quiz_question;
                $addquestion->question_name = $question_name;
                $addquestion->option_one = $option_one;
                $addquestion->option_two = $option_two;
                $addquestion->option_three = $option_three;
                $addquestion->option_four = $option_four;
                $addquestion->right_answer = $right_answer;
                $addquestion->save();

                if(!empty($addquestion))
                {
                    Session::flash('message', "Question Added Successfully");
                    return Redirect('/home');
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = quiz_question::where('id',$id)->first();

        return view('/editQuestion',['questions'=>$question]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [     
            'question_name' => 'required',
            'option_one' => 'required',
            'option_two' => 'required',
            'option_three' => 'required',
            'option_four' => 'required',
            'right_answer' => 'required',
        ]); 
        if($validator->fails())
        {
             return redirect('add-qestion')
              ->withErrors($validator)
              ->withInput();
        }
        else
        {
            $question_name = $request->question_name;
            $option_one = $request->option_one;
            $option_two = $request->option_two;
            $option_three = $request->option_three;
            $option_four = $request->option_four;
            $right_answer = $request->right_answer;

            $editquestion = quiz_question::find($id);
            $editquestion->question_name = $question_name;
            $editquestion->option_one = $option_one;
            $editquestion->option_two = $option_two;
            $editquestion->option_three = $option_three;
            $editquestion->option_four = $option_four;
            $editquestion->right_answer = $right_answer;
            $editquestion->save();

            if(!empty($editquestion))
            {
                Session::flash('message', "Question Updated Successfully");
                return Redirect('/home');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteQuestion = quiz_question::find($id);
        $deleteQuestion->delete();
        Session::flash('messages', "Question Deleted Successfully");
        return Redirect('/home');
    }
}
