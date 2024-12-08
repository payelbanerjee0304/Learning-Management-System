@props([
    'options' => null,
    'optionsIndex' => null,
    'answer' => [],
    'courseId' => null,
    'chapterIndex' => null,
    'quizIndex' => null
])
<div class="option mb-2 cf_optn_prt rew_div" data-option-index="{{ $optionsIndex }}">
    {{-- <span class="option-sign"></span> --}}
    {{-- <input type="text" name="" id="" value="{{$quizIndex}}"> --}}
    <input type="text" name="questions[0][options][]" class="optn_lbl subtask-question-option" placeholder="Option 1"
        data-name="options" value="{{$options?? ''}}">
        <label class="switch labl">
            <input type="checkbox" name="" class="form-check-input toggleTwo tgl_inp correctAnswer "  id="toggleTwo-0" data-name="answer" {{ in_array($options ?? '', $answer ?? []) ? 'checked' : '' }}
            value="{{ $options ?? '' }}">
            <span class="slider round"></span>
        </label>
        @if(!empty($options))  <!-- Show the delete button only for existing options -->
        {{-- <button type="button" class="delete-qna-optn" onclick="deleteQnaOptn('{{ $courseId }}', {{ $chapterIndex }}, {{ $quizIndex }}, {{$optionsIndex}})"><i class="fa fa-trash" aria-hidden="true"></i></button> --}}
        <a href="javascript:void(0);" onclick="deleteQnaOptn('{{ $courseId }}', {{ $chapterIndex }}, {{ $quizIndex }}, {{$optionsIndex}})" class="delete-qna-optn"><img src="{{ asset('images/edtpg_dlt_img.png') }}" alt="img" class="iamges" width="15px"></a>
    @endif
</div>
