@extends('layouts.app')
@section('content')
    <!-- start Quiz button -->
    <div class="start_btn"><button>Start Quiz</button></div>
    <!-- Info Box -->
    <div class="info_box activeInfo">
        <div class="info-title"><span>Some Rules of this Quiz</span></div>
        <div class="info-list">
           <div class="info">1. There are {{count($questions)}} questions</div>
            <div class="info">2. Once you select your answer, it can't be undone.</div>
            <div class="info">3. You can't exit from the Quiz while you're playing.</div>
            <div class="info">4. You'll get points on the basis of your correct answers.</div>
        </div>
        <div class="buttons">
            <button class="quit">Exit Quiz</button>
            <button class="restart">Continue</button>
        </div>
    </div>
    <!-- Quiz Box -->
    <div class="quiz_box">
        <header>
            <div class="title">Quiz</div>
        </header>
        <section>
            <div class="que_text">
                <!-- Here I've inserted question from JavaScript -->
            </div>
            <div class="option_list">
                <!-- Here I've inserted options from JavaScript -->
            </div>
        </section>
        <!-- footer of Quiz Box -->
        <footer>
            <div class="total_que">
                <!-- Here I've inserted Question Count Number from JavaScript -->
            </div>
            <button class="next_btn">Next Que</button>
        </footer>
    </div>
    <!-- Result Box -->
    <div class="result_box">
        <div class="icon">
            <i class="fas fa-crown"></i>
        </div>
        <div class="complete_text">You've completed the Quiz!</div>
        <div class="score_text">
            <!-- Here I've inserted Score Result from JavaScript -->
        </div>
        <div class="buttons">
            <button class="restart">Replay Quiz</button>
            <button class="quit">Quit Quiz</button>
        </div>
    </div>
    <!-- Inside this JavaScript file I've coded all Quiz Codes -->
    <script id="rendered-js">
    let questions = [

    @if(count($questions)>0)
        @foreach($questions as $qvalue)
        {
            numb: "{{$qvalue->id}}",
            question: "{{$qvalue->question_name}}",
            answer: "{{$qvalue->right_answer}}",
            options: ["{{$qvalue->option_one}}","{{$qvalue->option_two}}","{{$qvalue->option_three }}","{{$qvalue->option_four}}",]   
        },
        @endforeach
    @endif

];
//selecting all required elements
const start_btn = document.querySelector(".start_btn button");
const info_box = document.querySelector(".info_box");
const exit_btn = info_box.querySelector(".buttons .quit");
const continue_btn = info_box.querySelector(".buttons .restart");
const quiz_box = document.querySelector(".quiz_box");
const result_box = document.querySelector(".result_box");
const option_list = document.querySelector(".option_list");
let index = 0;
// if startQuiz button clicked
start_btn.onclick = () => {
  info_box.classList.add("activeInfo"); //show info box
};

// if exitQuiz button clicked
exit_btn.onclick = () => {
  info_box.classList.remove("activeInfo"); //hide info box
};

// if continueQuiz button clicked
continue_btn.onclick = () => {
  info_box.classList.remove("activeInfo"); //hide info box
  quiz_box.classList.add("activeQuiz"); //show quiz box
  showQuetions(0); //calling showQestions function
  queCounter(1); //passing 1 parameter to queCounter
};

let que_count = 0;
let que_numb = 1;
let userScore = 0;
let widthValue = 0;

const restart_quiz = result_box.querySelector(".buttons .restart");
const quit_quiz = result_box.querySelector(".buttons .quit");

// if restartQuiz button clicked
restart_quiz.onclick = () => {
  quiz_box.classList.add("activeQuiz"); //show quiz box
  result_box.classList.remove("activeResult"); //hide result box
  que_count = 0;
  que_numb = 1;
  userScore = 0;
  widthValue = 0;
  showQuetions(que_count); //calling showQestions function
  queCounter(que_numb); //passing que_numb value to queCounter
  next_btn.classList.remove("show"); //hide the next button
};

// if quitQuiz button clicked
quit_quiz.onclick = () => {
  window.location.href = "{{ url('/quiz')}}"; //reload the current window
};

const next_btn = document.querySelector("footer .next_btn");
const bottom_ques_counter = document.querySelector("footer .total_que");

// if Next Que button clicked
next_btn.onclick = (answer) => {
    let userSelectedAns = '';
    userSelectedAns = (JSON.parse(localStorage.getItem('userAns')));
    questions[index].userAns = userSelectedAns;
    index ++;
  if (que_count < questions.length - 1) {
    //if question count is less than total question length
    que_count++; //increment the que_count value
    que_numb++; //increment the que_numb value
    showQuetions(que_count); //calling showQestions function
    queCounter(que_numb); //passing que_numb value to queCounter
    next_btn.classList.remove("show"); //hide the next button
  } 
  else 
  {
    // alert(JSON.stringify(questions));
    questionSubmit(questions);
     //calling showResult function
  }
};

function questionSubmit(questions)
{
    let newArr = [];
    for (var i = questions.length - 1; i >= 0; i--) {
        newArr.push(questions[i]);
    }
    $.ajax({
       type: "POST",
       url: "{{ url('/submit-question')}}",
       data: {_token:"{{csrf_token()}}",newArr:newArr},
       success: function(msg){
         // alert(msg);
         if (msg == 'success') {
            showResult();
         }
         else
         {
            alert('Something went worng!!')
         }
         // console.log(msg);
        }
    });
    
}


// getting questions and options from array
function showQuetions(index) {
  const que_text = document.querySelector(".que_text");

  //creating a new span and div tag for question and option and passing the value using array index
  let que_tag =
  "<span>" +
  questions[index].numb +
  ". " +
  questions[index].question +
  "</span>";
  let option_tag =
  '<div class="option"><span>' +
  questions[index].options[0] +
  "</span></div>" +
  '<div class="option"><span>' +
  questions[index].options[1] +
  "</span></div>" +
  '<div class="option"><span>' +
  questions[index].options[2] +
  "</span></div>" +
  '<div class="option"><span>' +
  questions[index].options[3] +
  "</span></div>";
  que_text.innerHTML = que_tag; //adding new span tag inside que_tag
  option_list.innerHTML = option_tag; //adding new div tag inside option_tag

  const option = option_list.querySelectorAll(".option");

  // set onclick attribute to all available options
  for (i = 0; i < option.length; i++) {
    option[i].setAttribute("onclick", "optionSelected(this)");
  }
}
// creating the new div tags which for icons
let tickIconTag = '<div class="icon tick"><i class="fas fa-check"></i></div>';
let crossIconTag = '<div class="icon cross"><i class="fas fa-times"></i></div>';

//if user clicked on option
function optionSelected(answer) {
  let userAns = answer.textContent; //getting user selected option
  let correcAns = questions[que_count].answer; //getting correct answer from array
  const allOptions = option_list.children.length; //getting all option items
  localStorage.setItem('userAns',JSON.stringify(userAns));
  // alert(userAns);

  if (userAns == correcAns) {
    //if user selected option is equal to array's correct answer
    userScore += 1; //upgrading score value with 1
    answer.classList.add("correct"); //adding green color to correct selected option
    answer.insertAdjacentHTML("beforeend", tickIconTag); //adding tick icon to correct selected option
    console.log("Correct Answer");
    console.log("Your correct answers = " + userScore);
  } else {
    answer.classList.add("incorrect"); //adding red color to correct selected option
    answer.insertAdjacentHTML("beforeend", crossIconTag); //adding cross icon to correct selected option
    console.log("Wrong Answer");

    for (i = 0; i < allOptions; i++) {
      if (option_list.children[i].textContent == correcAns) {
        //if there is an option which is matched to an array answer
        option_list.children[i].setAttribute("class", "option correct"); //adding green color to matched option
        option_list.children[i].insertAdjacentHTML("beforeend", tickIconTag); //adding tick icon to matched option
        console.log("Auto selected correct answer.");
      }
    }
  }
  for (i = 0; i < allOptions; i++) {
    option_list.children[i].classList.add("disabled"); //once user select an option then disabled all options
  }
  next_btn.classList.add("show"); //show the next button if user selected any option
}

function showResult() {
  info_box.classList.remove("activeInfo"); //hide info box
  quiz_box.classList.remove("activeQuiz"); //hide quiz box
  result_box.classList.add("activeResult"); //show result box
  const scoreText = result_box.querySelector(".score_text");
  if (userScore > 3) {
    // if user scored more than 3
    //creating a new span tag and passing the user score number and total question number
    let scoreTag =
    "<span class='text-success'>congrats! , You got <p>" +
    userScore +
    "</p> out of <p>" +
    questions.length +
    "</p></span>";
    scoreText.innerHTML = scoreTag; //adding new span tag inside score_Text
  } else if (userScore > 1) {
    // if user scored more than 1
    let scoreTag =
    "<span class='text-warning'>nice , You got <p>" +
    userScore +
    "</p> out of <p>" +
    questions.length +
    "</p></span>";
    scoreText.innerHTML = scoreTag;
  } else {
    let scoreTag =
    "<span class='text-danger'>sorry , You got only <p>" +
    userScore +
    "</p> out of <p>" +
    questions.length +
    "</p></span>";
    scoreText.innerHTML = scoreTag;
  }
}

function queCounter(index) {
  let totalQueCounTag =
  "<span><p>" +
  index +
  "</p> of <p>" +
  questions.length +
  "</p> Questions</span>";
  bottom_ques_counter.innerHTML = totalQueCounTag; //adding new span tag inside bottom_ques_counter
}
//# sourceURL=pen.js
    </script>

@endsection