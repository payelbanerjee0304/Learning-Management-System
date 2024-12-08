 <div class="cf_tsk_part subtask">
    <div class="section_inside cf_tsk_innr">
        <h5>Chapter 
            <span class="subtask-number">{{ isset($index) ? $index + 1 : 1 }}</span>
            <span class="completed-status" style="display: {{ isset($chapter['completed']) && $chapter['completed'] ? 'inline' : 'none' }}"> : {{ $chapter['name'] ?? '' }}</span>
            <a href="{{ route('edit.chapter', ['courseId' => $course->_id ?? ' ', 'chapterIndex' => $index ?? ' ']) }}" class="edit-icon" style="float: right; margin-left: 10px; color: #990000;  display: {{ isset($chapter['id']) ? 'inline' : 'none' }} ">
                <i class="fas fa-edit"></i> <!-- Font Awesome Edit Icon -->
            </a>
        </h5>
        <div class="existingChapter" id="existingChapter">
        <input type="text" name="" id="chaptername" class="cf_tp_txt chaptername" placeholder="Chapter Name" data-name="chaptername" value="{{ $chapter['name'] ?? '' }}" >

        <small class="chaptername_error error"></small>
        <div class="cf_tsk_innr">
            <br><br>

            <div id="form-container" class="subtask-question-container">
                @if(isset($chapter['topics']))
                    @foreach($chapter['topics'] as $topicIndex => $topic)
                        <x-course-chapter-topic :topic="$topic" :topicIndex="$topicIndex" />
                    @endforeach
                @else
                <x-course-chapter-topic />
                @endif
                <div class="form-group">
                    <small id="points_error" class="error text-danger"></small>
                </div>
                <button type="button" id="add-form" class="btn btn-primary mb-3 cf_tsk_plus add-subtask-question">+</button>
            </div>
        </div>
        <div class="cf_tsk_innr">
            <div id="form-container" class="qna-container">
                @if(isset($chapter['quiz']))
                    @foreach($chapter['quiz'] as $quizIndex => $quiz)
                        <x-courseQnA-chapter-topic :quiz="$quiz" :quizIndex="$quizIndex" />
                    @endforeach
                @else
                <x-courseQnA-chapter-topic />
                @endif
                {{-- <div class="form-group">
                    <small id="points_error" class="error text-danger"></small>
                </div> --}}
                <button type="button" id="add-form" class="btn btn-primary mb-3 cf_tsk_plus add-qna">+</button>
            </div>
        </div>
        
        <input type="text" name="" id="passmarks" class="cf_tp_txt passmarks" placeholder="Qualifition Mark" data-name="passmarks" value="{{ $chapter['qualificationMarks'] ?? '' }}" >
        <small class="passmarks_error error"></small>
        </div>
    </div>
 </div>