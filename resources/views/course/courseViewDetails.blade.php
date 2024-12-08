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
            <h3>Course Contents</h3>
        </div>
    </div>
    
</div>


<div class="course-details-container NEWW">
    <h1>{{$course['courseName']}}</h1>
    <p>{{$course['courseDescription']}}</p>
    <button class="quizBtn reportBtn" data-course-id="{{ $course['_id'] }}">Get Report</button>

    <div class="chapters">
        <h2 class="chaptersHeader">{{count($course['chapters'])}} Chapters • {{$totalTopics}} topics • {{$totalRuntime}} total length</h2>

        <input type="hidden" id="courseId" value="{{ $course['_id']; }}">
        <!-- Chapter 1 -->
        @foreach($course['chapters'] as $chapter)
        <div class="chapter-item">
            <h3> {{$chapter['name']}}</h3>
            <ul>
                @foreach($chapter['topics'] as $topic)

                @php

                $duration = new DateTime($topic['duration'] ?? "00:00:00");
                $duration = $duration->format('H:i:s');
                list($hours, $minutes, $seconds) = explode(':', $duration);

                $runtime = '';

                if ($hours > 0) {
                $runtime .= $hours . ' ' . ($hours == 1 ? 'hr' : 'hrs');
                }

                if ($minutes > 0) {
                if (!empty($runtime)) {
                $runtime .= ' ';
                }
                $runtime .= $minutes . ' ' . ($minutes == 1 ? 'min' : 'mins');
                }

                if ($seconds > 0) {
                if (!empty($runtime)) {
                $runtime .= ' & ';
                }
                $runtime .= $seconds . ' ' . ($seconds == 1 ? 'sec' : 'secs');
                }

                if (empty($runtime)) {
                $runtime = '-';
                }
                @endphp


                @php
                    // Fetch the progress for the current user, course, and topic
                    $progress = App\Models\CourseVideoProgress::where('user_id', session('user_id'))
                        ->where('course_id', $id)
                        ->where('topic_id', (string) $topic['_id'])
                        ->value('progress');
                    $progress = $progress ?? 0; // Default to 0 if no progress found
                @endphp

                @php
                if (!function_exists('durationToSeconds')) {
                    function durationToSeconds($duration) {
                        if ($duration) {
                            list($hours, $minutes, $seconds) = sscanf($duration, '%d:%d:%f');
                            return ($hours * 3600) + ($minutes * 60) + $seconds;
                        }
                        return 0; // Return 0 if duration is null
                    }
                }
                $durationInSeconds = durationToSeconds($topic['duration']?? 0);

                // Calculate the progress percentage
                $progressPercentage = round(($durationInSeconds > 0) ? ($progress / $durationInSeconds) * 100 : 0);
                @endphp

                <li class="topic-item">

                    {{-- <img src="{{ $topic['contentType'] == 'file' ? asset('images/icons8-video-50.png') : asset('images/icons8-doc-50.png')}}" alt="" class="videoIcon"> --}}
                    <img src="
                        @if($topic['contentType'] == 'file')
                            {{ asset('images/icons8-video-50.png') }}
                        @elseif($topic['contentType'] == 'youtube')
                            {{ asset('images/icons-youtube.png') }}
                        @elseif($topic['contentType'] == 'pdf')
                            {{ asset('images/icons-pdf.png') }}
                        @elseif($topic['contentType'] == 'text')
                            {{ asset('images/icons8-doc-50.png') }}
                        @endif
                    " alt="" class="videoIcon">
                    <span>{{$topic['name']}}</span>
                    {{-- <span>{{$topic['_id']}}</span> --}}
                    {{-- <span>{{$progress}}</span>
                    <span>{{$durationInSeconds}}</span>
                    <span>{{$progressPercentage}}</span> --}}
                    @if($topic['contentType'] == 'file' || $topic['contentType'] == 'youtube')
                    <span>
                        <div class="progress-container">
                            <label for="progress"></label>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: {{ $progressPercentage }}%;"></div>
                            </div>
                            {{ min($progressPercentage, 100) }}% Complete
                        </div>
                    </span>
                    @endif
                    {{-- <span></span> --}}
                    <span class="duration">{{$runtime}}</span>
                    <button class="playButton" data-chapter-id={{ $chapter['_id'] }} data-topic-id={{ $topic['_id'] }}> {{ in_array($topic['contentType'], ['file', 'youtube']) ? "Play" : "View"}} </button>
                </li>

                @endforeach
                
                @if(!empty($progressExists[(string) $chapter['_id']]))
                    @php
                        $allQuizzesAnswered = true; // Flag to track if all quizzes are answered
                        foreach ($chapter['quiz'] as $quiz) {
                            $quizAnswered = App\Models\QuizResult::where('user_id', (string) session('user_id'))
                                ->where('quiz_id', (string) $quiz['_id'])
                                ->exists();
                            if (!$quizAnswered) {
                                $allQuizzesAnswered = false;
                                break; // Exit loop if any quiz is unanswered
                            }
                        }
                    @endphp

                    @if($allQuizzesAnswered)
                        <!-- Show Done button -->
                        <button class="quizBtn doneBtn" style="margin-top: 15px;">Completed</button>
                    @else
                        <button class="quizBtn openQuiz" data-chapter-id="{{ $chapter['_id'] }}" style="margin-top: 15px;">Click here to answer the question</button>
                        <div class="quiz-container" id="quiz-container-{{ $chapter['_id'] }}" hidden>
                            <h1 style="margin-top: 18px;">Answer the following questions</h1>
                            @foreach($chapter['quiz'] as $quiz)
                            @php
                            $userId=(string) session('user_id');
                                $quizAnswered = App\Models\QuizResult::where('user_id', $userId)
                                                    ->where('quiz_id', (string) $quiz['_id'])
                                                    ->exists();
                            @endphp

                            @if(!$quizAnswered)
                                <li class="topic-item quizQues">
                                    <form class="formQuiz" data-quiz-id="{{ $quiz['_id'] }}" data-chapter-id="{{ $chapter['_id'] }}">
                                        <div class="chapter-item quizChapter">
                                            <div class="question-header">
                                                <h1 class="quiz-question">{{ $quiz['question'] }} ?</h1>
                                                <span class="quiz-point">(Point- {{ $quiz['point'] }})</span>
                                                {{-- @foreach ($quiz['answer'] as $answer)
                                                    {{$answer}}
                                                @endforeach --}}
                                            </div>
                                            <div class="quiz-options">
                                                @foreach($quiz['options'] as $quizOption)
                                                    <div class="quiz-option">
                                                        <input type="radio" name="quizanswer" value="{{ $quizOption }}">
                                                        <label>{{ $quizOption }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="quizBtn quizSubmit">Submit</button>
                                            <div class="quiz-success" style="display: none; color: green; font-weight: bold; margin-top: 10px; font-size: 18px;">
                                                ✅ Thank you for your answer!
                                            </div>
                                        </div>
                                    </form>
                                </li>
                            @else
                            <li class="topic-item quizQues">
                                    <div class="chapter-item quizChapter">
                                        <div class="question-header">
                                            <h1 class="quiz-question">{{ $quiz['question'] }} ?</h1>
                                            <span class="quiz-point">(Point- {{ $quiz['point'] }})</span>
                                        </div>
                                        <div class="quiz-success" style="color: green; font-weight: bold; margin-top: 10px; font-size: 18px;">
                                            ✅ Answer already submitted!
                                        </div>
                                    </div>
                            </li>
                            @endif
                            @endforeach
                        </div>
                    @endif
                @endif


            </ul>
        </div>
        @endforeach


    </div>
</div>
</div>
@endsection

@section('customJs')

<script>
    $(".playButton").click(function() {
        const course = $("#courseId").val();
        const chapter = $(this).data("chapter-id");
        const topic = $(this).data("topic-id");
        console.log(chapter, topic);

        var url = "{{ route('coursesViewContent' , [ 'id' => ':id' , 'chapter_id' => ':chapter' , 'topic_id' => ':topic' ] ) }}";

        url = url.replace(':id', course).replace(':chapter', chapter).replace(':topic', topic);

        window.location.href = url;
        // console.log(content);

    })

    function goBackWithReload() {
        // Set a flag in session storage to indicate reload is needed
        sessionStorage.setItem("reload", "true");
        // Go back to the previous page
        window.history.back();
        }
        // Check if the page was navigated back and requires reload
        window.addEventListener("pageshow", function () {
        if (
            sessionStorage.getItem("reload") ||
            event.persisted ||
            performance.navigation.type === 2
        ) {
            sessionStorage.removeItem("reload"); // Remove the flag after reload
            window.location.reload(); // Reload the page
        }
    });

    
    
    
    $(document).ready(function () {
        
        $(".openQuiz").click(function () {
    
            const chapterId = $(this).data("chapter-id");
            $(`#quiz-container-${chapterId}`).removeAttr('hidden');
        });
        // Submit quiz answer
        $('.quizSubmit').click(function () {
            var form = $(this).closest('.formQuiz');
            var quizId = form.data('quiz-id');
            var chapterId = form.data('chapter-id');
            var answer = form.find('input[name="quizanswer"]:checked').val();
            // console.log(answer);
            if (!answer) {
                alert('Please select an answer before submitting.');
                return;
            }

            // AJAX call to submit the answer
            $.ajax({
                url: "{{ route('submit.quiz.answer') }}", // Route to handle quiz submission
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    // user_id: userId,
                    quiz_id: quizId,
                    chapter_id: chapterId,
                    answer: answer
                },
                success: function (response) {
                    if (response.success) {
                        form.find('.quiz-success').show(); // Show success message
                        form.addClass("answered");

                        var message = response.is_correct ? `✅ Correct answer! Points earned: ${response.points_earned}` : `❌ Incorrect answer. Points earned: ${response.points_earned}`;
                    
                        form.find('.quizChapter').html(
                            `<div class="thank-you" style="color: ${response.is_correct ? 'green' : 'red'}; font-weight: bold; margin-top: 10px; font-size: 18px;">
                                ${message}
                            </div>`
                        ); 

                        var allAnswered = true;

                        $(`#quiz-container-${chapterId} .formQuiz`).each(function () {
                            if (!$(this).hasClass("answered")) {
                                allAnswered = false;
                            }
                        });

                        if (allAnswered) {
                            setTimeout(function () {
                                // Replace the Open Quiz button with Done button
                                $(`.openQuiz[data-chapter-id="${chapterId}"]`)
                                    .text("Completed")
                                    .addClass("doneBtn")
                                    .removeClass("openQuiz");
                                $(`#quiz-container-${chapterId}`).hide(); // Hide quiz container
                            }, 5000);
                        }
                        console.log(allAnswered);
                    } else {
                        alert(response.message || 'Something went wrong.');
                    }
                },
                error: function () {
                    alert('An error occurred. Please try again.');
                }
            });
        });
    });
    $(document).ready(function () {
        $('.reportBtn').click(function () {
            var courseId = $(this).data('course-id');

            $.ajax({
                url: `/course/${courseId}/report-card`, // Adjust route
                method: 'GET',
                success: function (response) {
                    console.log(response);
                    window.location.href = `/course/${courseId}/report-card`;
                },
                error: function () {
                    alert('An error occurred. Please try again.');
                }
            });
        });
    });



</script>

@endsection