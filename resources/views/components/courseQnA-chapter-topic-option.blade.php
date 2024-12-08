<div class="option mb-2 cf_optn_prt rew_div">
    {{-- <span class="option-sign"></span> --}}
    <input type="text" name="questions[0][options][]" class="optn_lbl subtask-question-option" placeholder="Option 1"
        data-name="options" value="{{$options?? ''}}">
        <label class="switch labl">
            <input type="checkbox" name="" class="form-check-input toggleTwo tgl_inp correctAnswer "  id="toggleTwo-0" data-name="answer" {{ in_array($options ?? '', $answer ?? []) ? 'checked' : '' }}
            value="{{ $options ?? '' }}">
            <span class="slider round"></span>
        </label>
</div>
