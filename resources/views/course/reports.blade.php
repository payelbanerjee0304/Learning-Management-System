@extends('layouts.app')


@section('content')

<style>
    .assignment .d_brd_otr {
        background-color: transparent !important;
    }

    .course-details-container {
        max-width: 90%;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    h1 {
        text-align: center;
        margin-bottom: 10px;
    }

    p {
        text-align: center;
        color: #666;
        margin-bottom: 20px;
        font-size: 1.5rem;
    }

    .chapters {
        margin-top: 20px;
    }

    h2 {
        margin-bottom: 15px;
        font-size: 1.2em;
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    .chapter-item {
        padding: 15px;
        background-color: #f9f9f9;
        border: 1px solid #ccc;
        margin-bottom: 15px;
        border-radius: 5px;
    }

    .topic-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        border-bottom: 1px solid #ccc;
    }

    .topic-item:last-child {
        border-bottom: none;
    }

    .topic-item span {
        flex-grow: 1;
        max-width: calc(100% - 120px);
        /* Adjust to make space for duration and button */
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 1.5rem;
    }

    .duration {
        width: 60px;
        /* Fixed width for consistent alignment */
        text-align: right;
        /* Align text to the right */
        font-size: 0.9em;
        color: #666;
        padding-right: 10px;
    }

    button {
        padding: 5px 10px;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    button:hover {
        background-color: #218838;
    }

    .chaptersHeader {
        font-size: 1.8rem;
    }

    .videoIcon {
        height: 15px;
        width: 15px;
        margin-right: 5px;
    }

    .playButton {
        background-color: #06134d !important;
        font-size: 1.2rem;
    }

    /* Progress Tracker */
    .progress-container {
        /* margin-bottom: 20px; */
    }

    .progress-container label {
        font-size: 1.1rem;
        color: #333;
        display: block;
        margin-bottom: 5px;
    }

    .progress-bar {
        width: 90%;
        height: 10px;
        background-color: lightgray !important;
        border-radius: 5px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background-color: #06134d;
        border-radius: 5px 0 0 5px;
    }

    .topic-item.quizQues{
        text-align: center;
    }

    .quiz-container {
        display: flex;
        justify-content: center; /* Center horizontally */
        align-items: center;    /* Center vertically */
        flex-direction: column; /* Stack items vertically */
        min-height: 100vh;      /* Full viewport height to ensure vertical centering */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        margin-top: 12px;
    }

    .topic-item.quizQues {
        list-style-type: none; /* Remove default list styles */
        text-align: center;    /* Center text inside items */
        margin: 10px 0;        /* Add spacing between items */
        border-bottom: 0px;
    }

    .chapter-item .quizChapter {
        padding: 30px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
        max-width: 600px; /* Limit width for better visuals */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 600px;
    }

    .question-header {
        display: flex;
        justify-content: space-between; /* Align question and point on opposite sides */
        align-items: center;
        margin-bottom: 15px;
    }

    .quiz-question {
        font-size: 18px;
        font-weight: bold;
        text-align: left; /* Align question to the left */
        flex-grow: 1; /* Allow question to take up remaining space */
    }

    .quiz-point {
        font-size: 14px;
        color: #666;
        margin-left: 15px;
    }

    .quiz-options {
        margin-top: 15px;
        display: flex;
        flex-direction: column;
        gap: 10px; /* Add space between options */
        margin-bottom: 15px;
    }

    .quiz-option {
        display: flex;
        align-items: center;
        gap: 10px; /* Space between radio button and label */
        font-size: 16px;
    }

    .quiz-option input[type="radio"] {
        width: 20px;
        height: 20px; /* Make radio buttons slightly larger */
    }

    .quizBtn {
        /* margin-top: 20px; */
        padding: 5px 10px; /* Increase button size */
        font-size: 16px; /* Larger font size for button */
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
        background-color: #06134d !important;
    }

</style>

<div class="mn new_detail ">

<div class="d_brd_otr">
    <div class="knwledg_section">
        <div class="d_brd_tp abk">
            <a href="javascript:window.history.back()"><img src="{{ asset('images/left_arrow.png') }}" /></a>
            <h3>Report Card for: {{ $courseName }}</h3>
            @if (!collect($reportData)->contains('status', 'Not Attempted'))
                <a href="{{ route('downloadReportCard', $courseId) }}"><button class="quizBtn">Download</button></a>
            @endif
        </div>
    </div>
    
</div>


<div class="course-details-container NEWW">
    <h1>Total Points Earned: {{ $totalPointsEarned }}</h1>

    <div class="chapters">
        <ul style="font-size: 14px;"><strong>
            <li class="topic-item">
                <span>Chapter & Quiz Question</span>
                <span>Your Answer</span>
                <span>Correct Answer</span>
                <span>Points Earned</span>
                <span>Status</span>
            </li></strong>
        </ul>
        @foreach ($reportData as $chapter)
        <div class="chapter-item">
            <h3> {{ $chapter['chapter_name'] }}
                <span style="float: right; color: 
                    {{ $chapter['status'] === 'Pass' ? 'green' : ($chapter['status'] === 'Fail' ? 'red' : 'gray') }};
                    font-size: 16px; font-weight: bold;">
                    {{ $chapter['status'] }}
                </span>
            </h3>
            <ul>
                @foreach ($chapter['quizzes'] as $quiz)
                <li class="topic-item">
                    <span>{{ $quiz['question'] }}</span>
                    <span>
                        {{ $quiz['user_answer'] !== 'Not Attempted' ? $quiz['user_answer'] : ' ' }}
                    </span>
                    <span>
                        {{ $quiz['user_answer'] !== 'Not Attempted' ? $quiz['correct_answer'] : ' ' }}
                    </span>
                    <span>
                        {{ $quiz['user_answer'] !== 'Not Attempted' ? $quiz['points_earned'] : ' ' }}
                    </span>
                    <span style="color: 
                        {{ $quiz['status'] === 'Correct' ? 'green' : ($quiz['status'] === 'Incorrect' ? 'red' : 'gray') }};">
                        {{ $quiz['status'] }}
                    </span>
                </li>
                @endforeach
            </ul>
        </div>
        @endforeach


    </div>
</div>
</div>
@endsection

@section('customJs')
@endsection
