@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">

<script src="https://kit.fontawesome.com/a076d05399.js"></script>
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
        <h3>All Courses</h3>
    </div>
    <div class="evnt-srch">
        <div class="options">
            
        </div>
        <div class="search_bar">
            <input type="text" id="keyword" name="keyword" placeholder="Name Search" class="search_holder" />
            <input type="button" class="search-btn" />
            <div class="icon" id="searchSubmit">
                <img src="{{asset('images/search_icn.png')}}" alt="search_icn" />
            </div>
        </div>
        {{-- <div>
            <a href="{{route("create_course")}}"><button class="mainsb_btn">New Course</button></a>
        </div> --}}
        {{-- <div class="evnt_flx">
            <div class="evnt-clndr">
                <div class="input-group">
                    <input type="text" id="dateRange" name="dateRange" placeholder="_/_/_" />
                </div>
            </div>
        </div>
        <div class="">
            <div class="input-group">
                <!-- <button href="" clbuttonss="btn btn-bg btn-primary" id="dwnldButton"> Download </button> -->
                <a href="" id="dwnldLink" class="btn btn-bg btn-primary">Download</a>
            </div>
        </div> --}}
    </div>
</div>
<div id="tableData">
    @include('course.retrieveCourse_pagination')
</div>

@endsection

@section('customJs')
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


<script>


    function fetch_data(page) {
        $.ajax({
            url: "{{route('courseStreaming.pagination')}}",
            data:{page:page},
            success: function(data) {
                $('#tableData').html(data);
            }
        });
    }

    function search_data(keyword, page = 1) {
        $.ajax({
            url: "{{ route('courseStreaming.search') }}",
            data:{keyword: keyword, page: page},
            success: function(data) {
                $('#tableData').html(data);
            }
        });
    }

    $(document).on('click', '.pagination a', function(event) {

        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        var keyword = $('#keyword').val();
        console.log(keyword);
        if(keyword)
        {
            search_data(keyword,page);
        }
        else
        {
            fetch_data(page);
        }
    });

    $('#searchSubmit').on('click', function(event) {

        event.preventDefault();
        var keyword = $('#keyword').val();
        search_data(keyword);
    });

    $('#keyword').on('keydown', function(event) {
        if (event.keyCode === 13) {  
            event.preventDefault();
            var keyword = $(this).val();
            search_data(keyword);
        }
    });

</script>
@endsection