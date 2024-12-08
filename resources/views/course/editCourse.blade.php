@extends('layouts.adminapp')
@section('content')
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('css/multiselect-dropdown.css') }}">
    <script src="https://cdn.ckeditor.com/ckeditor5/37.0.0/classic/ckeditor.js"></script>
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
        .thumb_edit{
            float: right;
        }
        .thumb_view{
            height: 100px !important;
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
            <a href="javascript:window.history.back()"><img src="{{ asset('images/left_arrow.png') }}" /></a>
            <h3>Edit Course</h3>
        </div>
        <form action="javascript:void(0)" method="POST" id="dynamic-form" enctype="multipart/form-data">
            @csrf
            <div class="tsk_otr">
                <div id="task-details-container">
                <div class="tsk_innr">
                      <div class="tsk_box" id="userZoneHideShow" style="border-bottom: 0px;">
                          <div class="ts_bx_t">
                              <div class="tsk_t">
                                  <div class="tsk_div">
                                      <label>Course Name</label>
                                      <br />
                                      <input type="text" name="courseName" id="courseName" placeholder="Enter Your Course Name" class="inpt" value="{{ old('courseName', $course->courseName ?? '') }}" />
                                      <small id="courseName_error" class="error"></small>
                                  </div>
                              </div>

                            <div class="tsk_t">
                                <div class="tsk_div">
                                    <label>Description</label>
                                    <div class="mt_flx_dscrb">
                                        <textarea class="mt_dscrb_bx" id="courseDescription" name="courseDescription" placeholder="Enter Your Course description" style="width: 100%;">{{ old('courseDescription', $course->courseDescription ?? '') }}</textarea>
                                    </div>
                                    <small id="courseDescription_error" class="error"></small>
                                </div>
                            </div>
                            
                            <div class="tsk_t">
                                <div class="tsk_div">
                                    <label>Created By</label>
                                    <br />
                                    <input type="text" name="createdBy" id="createdBy" placeholder="Enter Creator Name" class="inpt" value="{{ old('createdBy', $course->createdBy ?? '') }}" />
                                    <small id="createdBy_error" class="error"></small>
                                </div>
                            </div>

                            <div class="tsk_t">
                                <div class="tsk_div">
                                    <label>Thumbnail</label>
                                    <br />
                                    
                                    {{-- <button class="btn btn-warning thumb_edit"><a href="{{ $course->thumbnail }}" target="_blank" id="currentThumbnailLink">Current Thumbnail</a></button> --}}
                                    @if(isset($course->thumbnail))
                                        <div class="thumbnail-container" style="position: relative; display: inline-block;">
                                            <img src="{{ asset($course->thumbnail) }}" alt="thumbnail" id="currentThumbnailLink" class="thumb_view">
                                            <div class="three-dots-menu video_tree" >
                                                <button onclick="toggleMenu(this)" ><i class="fa-solid fa-ellipsis"></i></button>
                                                <div class="menu-options" style="display: none; position: absolute; right: 0; background: white; border: 1px solid #ccc; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                                                    <button onclick="editThumbnail()" style="display: block; width: 100%; padding: 5px; border: none; cursor: pointer;" class="Edit">Edit</button>
                                                    <button onclick="deleteThumbnail('{{ $course->id }}')" style="display: block; width: 100%; padding: 5px; border: none; cursor: pointer;" class="Edit"> Delete</button>
                                                </div>
                                            </div>
                                            <input type="file" id="thumbnail" name="thumbnail" class="inpt" placeholder="choose a file" style="display:none;"  onchange="previewThumbnail(event)">
                                        </div>
                                    @else
                                        <input type="file" name="thumbnail" id="thumbnail" placeholder="choose a file" class="inpt"/>
                                        <div id="thumbnailView" style="position: relative;"></div>
                                    @endif
                                    <small id="thumbnail_error" class="error"></small>
                                </div>
                            </div>

                            <div class="tsk_t">
                                <div class="tsk_div">
                                    <label>What You Will Learn</label>
                                    <div class="mt_flx_dscrb">
                                        <textarea class="mt_dscrb_bx" id="learningDesc" name="learningDesc" placeholder="Enter Details" style="width: 100%;">{{ old('learningDesc', $course->learningDesc ?? '') }}</textarea>
                                    </div>
                                    <small id="learningDesc_error" class="error"></small>
                                </div>
                            </div>
                            
                          </div>
                      </div>
                  </div>
                  </div>

                  </div>
                </div>
                {{-- {{$course}} --}}
                <div id="subtask-container">
                    @if(isset($course) && $course->chapters)
                        @foreach($course->chapters as $index => $chapter)
                            <x-course-chapter :chapter="$chapter" :index="$index" :course="$course" />
                        @endforeach
                    @else
                        <x-course-chapter />
                    @endif
                </div>

                <small id="taskpoint_error" class="error"></small>

                <br>

                <button type="button" id="add-subtask" class="add-option add-subtask mainsb_btn" hidden>
                    Add Another Chapter
                </button>
                <small id="" class="error notifyMsg">To add new chapter, please click on submit & continue</small>
            </div>

            <br><br>

            <textarea name="taskObjectString" id="taskObjectString" hidden></textarea>

            <div class="sbmt_btn text-center">
                <input type="submit" name="submit" class="mainsb_btn" id="submitBtn" value="Submit">
            </div>
        </form>


    </div>

    <template id="subtask-template">
        <x-course-chapter />
    </template>

    <template id="subtask-question-template">
        <x-course-chapter-topic />
    </template>

    {{-- <!-- <template id="subtask-question-option-template">
        <x-course-chapter-topic-lectures />
    </template> --> --}}

    <template id="subtask-qna-template">
        <x-courseQnA-chapter-topic />
    </template>

    <template id="subtask-qna-template">
        <x-courseQnA-chapter-topic-option />
    </template>

@endsection

@section('customJs')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{-- <script src="{{ asset('js/course/validation.js') }}"></script> --}}
<script src="{{ asset('js/course/chapter.js') }}"></script>


@endsection
