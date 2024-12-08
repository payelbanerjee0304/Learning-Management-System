@extends('layouts.app')
@section('content')
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"> --}}

<script src="https://kit.fontawesome.com/a076d05399.js"></script>
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"> --}}

<!-- Bootstrap JS (with Popper.js) -->
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> --}}
<style>
    .pagination-links {
        font-size: 2rem;
    }

    .select2-results__option,
    .select2-search__field,
    .select2-selection__placeholder {
        font-size: 2rem;

    }
    .thumbnailImg{
        height: 40px;
    }
    .thumbnail-box {
        display: inline-block;
        padding: 10px;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 8px;
    }
</style>
<div class="d_brd_otr new">
    <div class="d_brd_tp">
        <a href="javascript:window.history.back()"><img src="{{asset('images/left_arrow.png')}}" /></a>
        <h3>Chapters of {{$course->courseName}}</h3>
    </div>
    <div class="evnt-srch">
    </div>
</div>
<div id="tableData">
    <div class="event_table">
        <table>
            <thead>
                <tr>
                    <th>Chapter Name</th>
                    <th>Chapter topics</th>
                </tr>
            </thead>
            <tbody id="courseListingTable">
                @php 
                $i=1;
                @endphp
                @foreach($course->chapters as $chapter)
                <tr>
                    <td>{{$chapter['name']}}</td>
                    <td>
                        <ul>
                            @foreach($chapter['topics'] as $topic)
                                <li>Topic: {{$topic['name']}} | 
                                    @if($topic['contentType']!= "text")
                                            <a href="{{$topic['content']}}" target="_blank">Click here</a>
                                        @else
                                        <i class="fa-solid fa-book" style="cursor:pointer;" onclick="openModal('{{$topic['content']}}')"></i>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
                @endforeach
                <!-- Modal Structure -->
                <div class="modal fade" id="contentModal" tabindex="-1" aria-labelledby="contentModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content shadow-lg rounded">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="contentModalLabel">
                                    <i class="fa-solid fa-book-open me-2"></i> Text Content
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4" style="background-color: #f7f7f7;">
                                <div id="modalContent" class="fs-5" style="color: #333;">
                                    <!-- Text content will appear here -->
                                </div>
                            </div>
                            <div class="modal-footer d-flex justify-content-between">
                                <small class="text-muted">Enjoy reading this content</small>
                                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                

            </tbody>
    
        </table>
    </div>
</div>

@endsection

@section('customJs')

<script>
    function openModal(content) {
        // Set the content in the modal
        document.getElementById('modalContent').innerText = content;
        
        // Show the modal
        var myModal = new bootstrap.Modal(document.getElementById('contentModal'));
        myModal.show();
    }
</script>

@endsection