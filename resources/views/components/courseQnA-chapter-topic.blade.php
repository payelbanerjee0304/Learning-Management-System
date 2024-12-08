<div class="form-section subtask-qna">
     <div class="cf_frm_ottr">
         <div class="cf_frm_flx">
             <div class="cf_frm_lft wdth">
                 <span class="cf_tp_pic">
                     <img src="{{ asset('images/cf_top.png') }}" alt="img">
                 </span>
                 <h3>QnA <span class="subtask-qna-number">{{ isset($quizIndex) ? $quizIndex + 1 : 1 }}</span></h3>

                 <div class="cf_tp_txt_mn">
                     <input type="text" class="cf_tp_txt qna-question-text" id="ques" name="qnaques" placeholder="Write Question" data-name="question" value="{{ $quiz['question'] ?? ''}}" />
                     <small id="ques_error" class="qna-question-text-error error"></small>
                 </div>
                 <div class="cf_tp_txt_mn qna">
                    <input type="text" class="cf_tp_txt qna-points-text" id="ques" name="qnapoints" placeholder="Point for this question" data-name="point"  value="{{ $quiz['point'] ?? ''}}" />
                    <small id="points_error " class="qna-points-text-error error neww"></small>
                 </div>
                 <div class="mt_chs_grp">
                    <div class="cf_grp_two">
                        <div class="cf_optn_grp">
                            <div class="cf_optn_prt qnaNew_optn">
                                <div class="qna-options-container" style="">
                                    <div class="form-group">
                                        <label for="options">Options</label>
                                        <div class="options">
                                        @if(isset($quiz['options']))
                                            @foreach($quiz['options'] as $optionsIndex => $options)
                                                <x-courseQnA-chapter-topic-option :options="$options" :optionsIndex="$optionsIndex" :answer="$quiz['answer'] ?? [] " />
                                            @endforeach
                                        @else
                                            <x-courseQnA-chapter-topic-option />
                                        @endif
                                            <!-- <x-courseQnA-chapter-topic-option /> -->
                                        </div>
                                        <button type="button" id="add-option" class="add-option mainsb_btn">Add Another Option</button>
                                        <small id="qnaoptn_error" class="qnaoptn_error error"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="cf_tp_txt_mn">
                    <input type="text" class="cf_tp_txt qna-points-text" id="ques" name="qnapoints" placeholder="Point for this question" data-name="point" />
                    <small id="points_error" class="qna-points-text-error error"></small>
                </div> --}}
            </div>
        </div>
    </div>
</div>