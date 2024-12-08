 <div class="form-section subtask-question">
     <div class="cf_frm_ottr">
         <div class="cf_frm_flx">
             <div class="cf_frm_lft">
                 <span class="cf_tp_pic">
                     <img src="{{ asset('images/cf_top.png') }}" alt="img">
                 </span>
                 <h3>Topic <span class="subtask-question-number">1</span></h3>

                 <div class="cf_tp_txt_mn">
                     <input type="text" class="cf_tp_txt subtask-question-text" id="ques" name="title" placeholder="Write Topic Name" data-name="name"  value="{{ $topic['name'] ?? ''}}"/>
                     <small id="ques_error" class="subtask-question-text-error error"></small>
                 </div>
                 <div class="mt_chs_grp">
                     <div class="cf_grp_one">
                         <span><img src="{{ asset('images/cf-sd.png') }}" alt="img"></span>
                         <div class="dropdown">
                             <select id="typ" name="questions[0][type]" class="dropdown__filter mc_ipt_bx subtask-question-select" data-name="contentType">
                                 <option value="">Select</option>
                                 <option value="text"{{ (isset($topic['contentType']) && $topic['contentType'] === 'text') ? 'selected' : '' }}>Paraphrase</option>
                                 <option value="youtube"{{ (isset($topic['contentType']) && $topic['contentType'] === 'youtube') ? 'selected' : '' }}>Youtube Embed</option>
                                 <option value="pdf"{{ (isset($topic['contentType']) && $topic['contentType'] === 'pdf') ? 'selected' : '' }}>Pdf Upload</option>
                                 <option value="file"{{ (isset($topic['contentType']) && $topic['contentType'] === 'file') ? 'selected' : '' }}>Video Upload</option>
                             </select>
                             <small id="ques_error" class="subtask-question-select-error error"></small>
                         </div>
                     </div>
                     <div><small id="typ_error" class="error"></small></div>
                     <div class="cf_grp_two">
                        <div class="cf_optn_grp">
                            <div class="cf_optn_prt">
                                <div class="options-container" style="{{ isset($topic['contentType']) ? 'display:block;' : 'display:none;' }}">
                                    <div class="form-group">
                                        <label for="options">Lectures</label>
                                        <div class="options">
                                            {{-- File upload option --}}
                                            <div class="option mb-2 cf_optn_prt fileupload-option" style="{{ (isset($topic['contentType']) && $topic['contentType'] === 'file') ? 'display:block;' : 'display:none;' }}">
                                                @if(isset($topic['content']) && $topic['contentType'] === 'file')
                                                    <p><a href="{{ $topic['content'] }}" target="_blank" id="currentfileLink" class="currentfileLink">Current File</a></p>
                                                @else
                                                <input type="file" name="questions[0][lecture][]" class="optn_lbl subtask-question-option" placeholder="Option 1" data-name="content"  onchange="showPreview(event)" data-content-type="file">
                                                <div class="videoPreview" style="position: relative; display: inline-block;"></div>
                                                @endif
                                                <small id="fileuploadError" class="fileupload-error error"></small>
                                            </div>

                                            <div class="option mb-2 cf_optn_prt pdf-option" style="{{ (isset($topic['contentType']) && $topic['contentType'] === 'pdf') ? 'display:block;' : 'display:none;' }}">
                                                @if(isset($topic['content']) && $topic['contentType'] === 'pdf')
                                                    <p><a href="{{ $topic['content'] }}" target="_blank" id="currentpdfLink" class="currentpdfLink">Current File</a></p>
                                                @else
                                                <input type="file" name="questions[0][lecture][]" class="optn_lbl subtask-question-option" placeholder="Option 1" data-name="content"  data-content-type="pdf" onchange="showPdfPreview(event)" >
                                                <div class="pdfPreview" style="position: relative; display: inline-block;"></div>
                                                @endif
                                                <small id="pdfuploadError" class="pdfError error"></small>
                                            </div>

                                            <div class="option mb-2 cf_optn_prt text-option" style="{{ (isset($topic['contentType']) && $topic['contentType'] === 'text') ? 'display:block;' : 'display:none;' }}">
                                                {{-- <input type="text" name="questions[0][lecture][text]" class="optn_lbl subtask-question-option" placeholder="Enter text" data-name="content" value="{{ (isset($topic['content']) && $topic['contentType'] === 'text') ? $topic['content'] : '' }}" data-content-type="text"> --}}
                                                @if(isset($topic['content']) && $topic['contentType'] === 'text')
                                                <p>done</p>
                                                @else
                                                <textarea id="editor_1" name="questions[0][lecture][text]" class="optn_lbl subtask-question-option text_area_eDITor ckeditor subtask-question-number create_editor" placeholder="Enter text" data-name="content" data-content-type="text">
                                                    {{ (isset($topic['content']) && $topic['contentType'] === 'text') ? $topic['content'] : '' }}
                                                </textarea>
                                                @endif
                                            </div>
                                            <small id="text-error" class="text-error error"></small>

                                            <div class="option mb-2 cf_optn_prt youtube-option" style="{{ (isset($topic['contentType']) && $topic['contentType'] === 'youtube') ? 'display:block;' : 'display:none;' }}">
                                                <input type="text" name="questions[0][lecture][youtube]" class="optn_lbl subtask-question-option" placeholder="Enter youtube link" data-name="content" value="{{ (isset($topic['content']) && $topic['contentType'] === 'youtube') ? $topic['content'] : '' }}" data-content-type="youtube">
                                            </div>
                                            <small id="youtube-error" class="youtube-error error"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
