<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EditCourseChapterTopic extends Component
{
    // public $course;
    public $topic;
    public $topicIndex;
    public $courseId;
    public $chapterIndex;

    public function __construct($topic, $topicIndex,$courseId,$chapterIndex)
    {
        // $this->course = $course;
        $this->topic = $topic;
        $this->topicIndex = $topicIndex;
        $this->courseId = $courseId;
        $this->chapterIndex = $chapterIndex;
    }

    public function render()
    {
        return view('components.edit-course-chapter-topic');
    }
}
