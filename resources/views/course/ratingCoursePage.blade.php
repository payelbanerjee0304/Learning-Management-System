@extends('layouts.app')
@section('content')
    {{-- <link href="https://cdn.jsdelivr.net/npm/medium-editor@latest/dist/css/medium-editor.min.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/medium-editor@latest/dist/css/themes/default.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/medium-editor/5.23.0/css/medium-editor.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/medium-editor/5.23.0/css/themes/default.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/medium-editor/5.23.0/js/medium-editor.min.js"></script>

    <style>
        .medium-editor-toolbar {
            background: #f8f8f8;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 5px;
        }

        #content {
            border: 1px solid #ccc;
            padding: 10px;
            min-height: 120px;
        }

        #content u {
            text-decoration: underline;
            /* Ensure underline is applied */
            color: inherit;
            /* Use the same color as the surrounding text */
        }

        #heading u {
            text-decoration: underline;
            /* Ensure underline is applied */
            color: inherit;
            /* Use the same color as the surrounding text */
        }

        /* Optional: Apply styles to prevent text decoration issues */
        #content {
            text-decoration: none;
            /* Disable any default text decoration */
        }

        #content * {
            text-decoration: none;
            /* Disable decoration on all child elements */
        }

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

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .ck-editor {
                min-height: 200px;
                /* Adjust min-height for smaller screens */
            }
        }

        .star-rating {
            direction: rtl;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .star-rating input {
            display: none; /* Hide the radio buttons */
        }

        .star-rating label {
            font-size: 5rem; /* Adjust size as needed */
            color: #d3d3d3; /* Light gray color for unselected stars */
            cursor: pointer;
        }

        .star-rating input:checked ~ label,
        .star-rating input:hover ~ label,
        .star-rating label:hover {
            color: #ffcc00; /* Yellow color for selected stars */
        }

    </style>

    <div class="d_brd_otr new">
        <div class="d_brd_tp">
            <a href="javascript:window.history.back();"><img src="{{ asset('images/left_arrow.png') }}" /></a>
            <h3>Place your ratings for {{$course->courseName}} </h3>
        </div>
        <form action="javascript:void(0)" method="POST" id="dynamic-form">
            @csrf
            <div class="tsk_otr">
                <div id="event-details-container">
                    <div class="tsk_innr">
                        <div class="tsk_box" id="userZoneHideShow" style="border-bottom: 0px;">
                            <div class="ts_bx_t">
                                <div class="tsk_t" hidden>
                                    <div class="tsk_div">
                                        <label>User Name</label>
                                        <br />
                                        <input type="text" name="courseId" id="courseId" value="{{$course->id}}" >
                                        <input type="text" name="courseName" id="courseName" value="{{$course->courseName}}" >
                                        <input type="text" name="userId" id="userId" value="{{$userId}}" >
                                        <input type="text" name="username" id="username" placeholder="" class="inpt" value="{{$user ?? ''}}" />
                                        <small id="username_error" class="error"></small>
                                    </div>
                                </div>

                                <div class="tsk_t">
                                    <div class="tsk_div">
                                        <label> Ratings </label>
                                        <br />
                                        <div class="star-rating">
                                            <input type="radio" name="ratings" id="star5" value="5" />
                                            <label for="star5" title="5 stars">&#9733;</label>
                                            <input type="radio" name="ratings" id="star4" value="4" />
                                            <label for="star4" title="4 stars">&#9733;</label>
                                            <input type="radio" name="ratings" id="star3" value="3" />
                                            <label for="star3" title="3 stars">&#9733;</label>
                                            <input type="radio" name="ratings" id="star2" value="2" />
                                            <label for="star2" title="2 stars">&#9733;</label>
                                            <input type="radio" name="ratings" id="star1" value="1" />
                                            <label for="star1" title="1 star">&#9733;</label>
                                        </div>
                                        <small id="ratings_error" class="error"></small>
                                    </div>
                                </div>

                                <div class="tsk_t">
                                    <div class="tsk_div task_D_inP">
                                        <label> Comment </label>
                                        <br />
                                        <textarea name="comment" id="comment" class="new_p" cols="50" rows="3" style="resize: none; overflow: hidden; height: auto;"></textarea>
                                        <small id="comment_error" class="error"></small>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="headingContent" id="headingContent">
                {{-- <input type="hidden" name="editorContent" id="editorContent"> --}}
            </div>


            <div class="sbmt_btn text-center">
                <input type="submit" name="submit" class="mainsb_btn" id="submitBtn" value="Submit">
            </div>

        </form>

    </div>
@endsection



@section('customJs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/medium-editor@latest/dist/js/medium-editor.min.js"></script>

    <script src="https://cdn.ckeditor.com/ckeditor5/37.0.0/classic/ckeditor.js"></script>

    <script src="{{ asset('js/course/rating.js') }}"></script>

@endsection
