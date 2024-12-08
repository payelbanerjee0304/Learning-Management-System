<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EditCourseqnaChapterTopic extends Component
{
    // public $course;
    public $quiz;
    public $quizIndex;
    public $courseId;
    public $chapterIndex;

    public function __construct($quiz, $quizIndex,$courseId,$chapterIndex)
    {
        // $this->course = $course;
        $this->quiz = $quiz;
        $this->quizIndex = $quizIndex;
        $this->courseId = $courseId;
        $this->chapterIndex = $chapterIndex;
    }

    public function render()
    {
        return view('components.edit-courseqna-chapter-topic');
    }
}
