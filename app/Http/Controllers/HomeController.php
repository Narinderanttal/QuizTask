<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\quiz_question;
use App\Models\User;
use App\Models\UserAnswer;
class HomeController extends Controller
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $question = quiz_question::all();
        return view('quiz',['questions'=>$question]);  
    }

    public function submit_question(Request $request)
    {
        $users = Auth::User();
        $user_id = $users->id;
        $newarr = $request->newArr;

        
        foreach ($newarr as $key => $value) 
        {
            $question_id = $value['numb'];
            $userAns = $value['userAns'];                
            $checkQuestion = UserAnswer::where('user_id',$user_id)->where('question_id',$question_id)->first();
            if (!empty($checkQuestion)) 
            {   
                $submitanswer = UserAnswer::find($checkQuestion->id);
                $submitanswer->user_id = $user_id;
                $submitanswer->question_id = $question_id;
                $submitanswer->selected_answer = $userAns;
                $submitanswer->save();
            }
            else
            {
                $submitanswer = new UserAnswer;
                $submitanswer->user_id = $user_id;
                $submitanswer->question_id = $question_id;
                $submitanswer->selected_answer = $userAns;
                $submitanswer->save();  
            }
        }

        if (!empty($submitanswer)) 
        {
            echo "success";
        }
        else
        {
            echo "error";
        }
      
    }
}
