<div class="form-section subtask-question"   data-topic-index="{{ $topicIndex }}">
    <div class="cf_frm_ottr">
        <div class="cf_frm_flx">
            <div class="cf_frm_lft">
                <span class="cf_tp_pic">
                    {{-- <img src="{{ asset('images/cf_top.png') }}" alt="img"> --}}
                    @if(isset($topic))
                    <a href="javascript:void(0);" onclick="deleteTopic('{{ $courseId }}', {{ $chapterIndex }}, {{ $topicIndex }})"><img src="{{ asset('images/edtpg_dlt_img.png') }}" alt="img" class="iamges"></a>
                    @else
                    <img src="{{ asset('images/cf_top.png') }}" alt="img">
                    @endif
                </span>
                <h3>Topic <span class="subtask-question-number">{{ isset($topicIndex) ? $topicIndex + 1 : 1 }}</span></h3>

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
                                               
                                               {{-- <button class="btn btn-warning"><a href="{{ $topic['content'] }}" target="_blank">Current File</a></button>  --}}
                                                @if(isset($topic['content']) && $topic['contentType'] === 'file')
                                                    <div class="video-container" style="position: relative; display: inline-block;">
                                                        <video class="edit_vide" controls>
                                                        <source src="{{ asset($topic['content']) }}" type="video/mp4">
                                                        </video>
                                                        <div class="three-dots-menu video_tree" >
                                                            <button onclick="toggleMenu(this)" ><i class="fa-solid fa-ellipsis"></i></button>
                                                            <div class="menu-options" style="display: none; position: absolute; right: 0; background: white; border: 1px solid #ccc; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                                                                <button onclick="editVideo('{{ $topic['content'] }}')" style="display: block; width: 100%; padding: 5px; border: none; cursor: pointer;" class="Edit">Edit</button>
                                                                <button 
                                                                    onclick="deleteVideo('{{ $courseId }}', {{ $chapterIndex }}, {{ $topicIndex }}, '{{ $topic['content'] }}')" 
                                                                    style="display: block; width: 100%; padding: 5px; border: none; cursor: pointer;" class="Edit">
                                                                    Delete
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <input type="file" id="editVideoInput" name="questions[0][lecture][]" class="optn_lbl subtask-question-option" placeholder="Option 1" data-name="content" style="display:none;" data-content-type="file">
                                                    </div>
                                                @else
                                                    <input type="file" name="questions[0][lecture][]" class="optn_lbl subtask-question-option" placeholder="Option 1" data-name="content" onchange="showPreview(event)"data-content-type="file">
                                                    <div class="videoPreview" style="position: relative; display: inline-block;">
                                                    </div>
                                                @endif
                                               <small id="fileuploadError" class="fileupload-error error"></small>
                                            </div>

                                            {{-- pdf part --}}
                                            <div class="option mb-2 cf_optn_prt pdf-option" style="{{ (isset($topic['contentType']) && $topic['contentType'] === 'pdf') ? 'display:block;' : 'display:none;' }}">
                                                @if(isset($topic['content']) && $topic['contentType'] === 'pdf')
                                                {{-- <p><a href="{{ $topic['content'] }}" target="_blank" id="currentpdfLink" class="currentpdfLink">Current File</a></p> --}}
                                                <div class="pdf-viewer"  style="position: relative; display: inline-block;">
                                                    <iframe src="{{ asset($topic['content']) }}#toolbar=0" width="100%" height="275px" id="currentpdfLink" class="currentpdfLink"></iframe>
                                                    <div class="three-dots-menu video_tree" >
                                                        <button onclick="toggleMenu(this)" ><i class="fa-solid fa-ellipsis"></i></button>
                                                        <div class="menu-options" style="display: none; position: absolute; right: 0; background: white; border: 1px solid #ccc; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                                                            <button onclick="editpdf('{{ $topic['content'] }}')" style="display: block; width: 100%; padding: 5px; border: none; cursor: pointer;" class="Edit">Edit</button>
                                                            <button 
                                                                onclick="deletepdf('{{ $courseId }}', {{ $chapterIndex }}, {{ $topicIndex }}, '{{ $topic['content'] }}')" 
                                                                style="display: block; width: 100%; padding: 5px; border: none; cursor: pointer;" class="Edit">
                                                                Delete
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <input type="file" name="questions[0][lecture][]" class="optn_lbl subtask-question-option" data-name="content" value="{{ (isset($topic['content']) && $topic['contentType'] === 'pdf') ? $topic['content'] : '' }}" data-content-type="pdf"  style="display:none;">
                                                    
                                                </div>
                                                @else
                                                <input type="file" name="questions[0][lecture][]" class="optn_lbl subtask-question-option" data-name="content" value="{{ (isset($topic['content']) && $topic['contentType'] === 'pdf') ? $topic['content'] : '' }}" data-content-type="pdf" onchange="showPdfPreview(event)" >
                                                <div class="pdfPreview" style="position: relative; display: inline-block;">
                                                </div>
                                                @endif
                                                <small id="pdfuploadError" class="pdfError error"></small>
                                            </div>
                                           
                                           {{-- Text input option --}}
                                           <div class="option mb-2 cf_optn_prt text-option" style="{{ (isset($topic['contentType']) && $topic['contentType'] === 'text') ? 'display:block;' : 'display:none;' }}">
                                               {{-- <input type="text" name="questions[0][lecture][]" class="optn_lbl subtask-question-option" placeholder="Enter text" data-name="content" value="{{ (isset($topic['content']) && $topic['contentType'] === 'text') ? $topic['content'] : '' }}" data-content-type="text"> --}}
                                               <textarea id="editor_{{ $topicIndex }}" name="questions[0][lecture][text]" class="optn_lbl subtask-question-option text_area_eDITor ckeditor subtask-question-number" placeholder="Enter text" data-name="content" data-content-type="text">
                                                {{ (isset($topic['content']) && $topic['contentType'] === 'text') ? $topic['content'] : '' }}
                                            </textarea>
                                           </div>
                                           <small id="text-error" class="text-error error"></small>

                                           {{-- youtube embed --}}
                                           <div class="option mb-2 cf_optn_prt youtube-option" style="{{ (isset($topic['contentType']) && $topic['contentType'] === 'youtube') ? 'display:block;' : 'display:none;' }}">
                                                <input type="text" name="questions[0][lecture][]" class="optn_lbl subtask-question-option" placeholder="Enter Youtube Link" data-name="content" value="{{ (isset($topic['content']) && $topic['contentType'] === 'youtube') ? $topic['content'] : '' }}" data-content-type="youtube">
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
    {{-- <button type="button" class="remove-form remove-subtask ex-rmv-btn">-</button> --}}
    {{-- <img src="{{ asset('images/edtpg_dlt_img.png') }}" alt="img" height="25px" width="25px"> --}}
</div>