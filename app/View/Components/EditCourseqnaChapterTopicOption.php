<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EditCourseqnaChapterTopicOption extends Component
{
    public $options;
    public $optionsIndex;
    public $answer;

    public function __construct($options, $optionsIndex, $answer)
    {
        $this->options = $options;
        $this->optionsIndex = $optionsIndex;
        $this->answer = $answer;
    }

    public function render()
    {
        return view('components.edit-courseqna-chapter-topic-option');
    }
}
