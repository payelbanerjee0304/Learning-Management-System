@extends('layouts.adminapp')
<script src="https://cdn.ckeditor.com/ckeditor5/37.0.0/classic/ckeditor.js"></script>
@section('content')
<style>
    #taskObjectString {
        width: 800px;
        height: 200px;
    }

    #filters-container {
        display: none;
    }

    .error {
        color: red;
    }
    .subtask-qna .cf_frm_lft {
        width: 49%;
    }

    #qna-container{
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        row-gap: 2rem;
    }
    .cf_frm_lft.wdth{
        width:100%;
    }
    #points_error.error.neww{
        position: relative;
    }
    .cf_tp_txt_mn.qna{
        margin-block: 10px
    }
    .swal2-styled{
        font-size: 13px !important;

    }
    .swal2-cancel.swal2-styled{
        background-color:#990000 !important;
    }
    .swal2-confirm.swal2-styled{
        background-color: #08a76a !important;
    }
    .iamges{
        float: right;
    }
    .pdf-viewer{
        width: 100% !important;
    }

    /*CKEditor css*/
        /* Ensure the CKEditor takes up the full width of its container */
        .ck-editor {
            width: 100%;
            /* Make the editor responsive */
            min-height: 250px;
            /* Set a minimum height for the editor */
            border: 1px solid #ccc;
            /* Default border */
            border-radius: 10px;
            /* Rounded corners */
            transition: border-color 0.3s ease;
            /* Smooth transition for border color */
        }

        /* Change the appearance of the editor when focused */
        .ck-focused {
            border-color: #007bff;
            /* Change border color when focused */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            /* Add shadow effect */
        }

        /* Customize toolbar appearance */
        .ck-toolbar {
            background-color: #f8f9fa;
            /* Light background for the toolbar */
            border: 1px solid #ced4da;
            /* Border for the toolbar */
            border-radius: 4px;
            /* Rounded corners */
            margin-bottom: 5px;
            /* Space between toolbar and editor */
        }

        /* Style for the toolbar items */
        .ck-toolbar .ck-button {
            color: #495057;
            /* Default color for buttons */
        }

        /* Hover effect for toolbar buttons */
        .ck-toolbar .ck-button:hover {
            background-color: #e2e6ea;
            /* Light gray on hover */
        }

        /* Active button styling */
        .ck-toolbar .ck-button.ck-on {
            background-color: #007bff;
            /* Blue background for active buttons */
            color: #fff;
            /* White text for active buttons */
        }

        /* Customize the appearance of the editable area */
        .ck-editor__editable {
            padding: 10px;
            /* Add padding for better text spacing */
            min-height: 200px;
            /* Set minimum height for editable area */
            font-size: 14px;
            /* Font size for the text */
            line-height: 1.5;
            /* Line height for better readability */
        }

        /* Customize font family and size in the editor */
        .ck-editor__editable {
            font-family: Arial, Helvetica, sans-serif;
            /* Default font */
        }

        /* Customize the appearance of block quotes */
        .ck-blockquote {
            border-left: 4px solid #007bff;
            /* Left border for block quotes */
            padding-left: 10px;
            /* Padding for text */
            color: #6c757d;
            /* Color for quote text */
            background-color: #f8f9fa;
            /* Light background for quotes */
            margin: 10px 0;
            /* Margin for spacing */
        }
        .text_area_eDITor,.text_area_eDITor .ck.ck-editor{
            width: 100% !important;
        }
        .ck.ck-reset.ck-editor.ck-rounded-corners{
            width: 100% !important;

        }
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .ck-editor {
                min-height: 200px;
                /* Adjust min-height for smaller screens */
            }
        }
</style>
<div id="loader" style="display: none;">
    <div class="loader"></div>
</div>
<div class="d_brd_otr">
    <div class="d_brd_tp">
        <a href="javascript:goBackWithReload()"><img src="{{ asset('images/left_arrow.png') }}" /></a>
        <h3>Edit Chapter: {{ $chapter['name'] }}</h3>
    </div>
    <form action="javascript:void(0)" method="POST" id="dynamic-form" enctype="multipart/form-data">
        @csrf
        <div id="subtask-container">
            <div class="cf_tsk_part subtask">
                <div class="section_inside cf_tsk_innr">
                    <h5>Chapter Name</h5>
                    <div class="existingChapter" id="existingChapter">
                        <input type="text" name="chapterIndex" id="chapterIndex" value="{{$chapterIndex ?? ''}}" hidden>
                        <input type="text" name="courseId" id="courseId" value="{{$course->_id ?? ''}}" hidden>
                    <input type="text" name="" id="chaptername" class="cf_tp_txt chaptername" placeholder="Chapter Name" data-name="chaptername" value="{{ $chapter['name'] ?? '' }}" >
                    <small class="chaptername_error error"></small>
                    <div class="cf_tsk_innr">
                        <br><br>
                        <div id="form-container" class="subtask-question-container">
                            @if(isset($chapter['topics']))
                                @foreach($chapter['topics'] as $topicIndex => $topic)
                                    <x-edit-course-chapter-topic :topic="$topic" :courseId="$course->_id" :chapterIndex="$chapterIndex" :topicIndex="$topicIndex"  />
                                @endforeach
                            @else
                            <x-edit-course-chapter-topic />
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
                                    <x-edit-courseqna-chapter-topic :quiz="$quiz" :quizIndex="$quizIndex"  :courseId="$course->_id" :chapterIndex="$chapterIndex" />
                                @endforeach
                            @else
                                <x-edit-courseqna-chapter-topic />
                            @endif
                            <button type="button" id="add-form" class="btn btn-primary mb-3 cf_tsk_plus add-qna">+</button>
                        </div>
                    </div>
                    <h5>Qualifition Mark</h5>
                    <input type="text" name="" id="passmarks" class="cf_tp_txt passmarks" placeholder="Qualifition Mark" data-name="passmarks" value="{{ $chapter['qualificationMarks'] ?? '' }}" >
                    <small class="passmarks_error error"></small>
                    </div>
                </div>
            </div>
        </div>
        <div class="sbmt_btn text-center">
            <input type="submit" name="submit" class="mainsb_btn" id="updateBtn" value="Update">
        </div>
    </form>
</div>


<template id="subtask-question-template">
    <x-edit-course-chapter-topic :topic=null :topicIndex=null :courseId="$course->_id" :chapterIndex="$chapterIndex" />
</template>

<template id="subtask-qna-template">
    <x-edit-courseqna-chapter-topic :quiz=null :quizIndex=null :courseId="$course->_id" :chapterIndex="$chapterIndex" />
</template>

<template id="subtask-qna-template">
    <x-edit-courseqna-chapter-topic-option :options=null :optionsIndex=null :answer=null />
</template>

    {{-- <div class="container">
        <h2>Edit Chapter: {{ $chapter['name'] }}</h2>
        
        <form action="{{ route('update.chapter', ['courseId' => $course->_id, 'chapterIndex' => $chapterIndex]) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="chapterName">Chapter Name</label>
                <input type="text" id="chapterName" name="name" class="form-control" value="{{ $chapter['name'] }}">
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div> --}}
@endsection

@section('customJs')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/course/chapter.js') }}"></script>
<script>
    var editorInstances = {};
    $('.ckeditor').each(function() {
        
        let editorId = $(this).attr('id');
        ClassicEditor
            .create(document.querySelector('#' + editorId))
            .then(editor => {
                editorInstances[editorId] = editor;
                console.log('Initialized CKEditor instance for:', editorId);
            })
            .catch(error => {
                console.error('There was a problem initializing CKEditor:', error);
            });
    });
</script>

@endsection

