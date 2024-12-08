@extends('layouts.adminapp')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">

<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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

    .star-rating {
        font-size: 20px; /* Adjust the size to match your layout */
        display: inline-block;
        position: relative;
    }

    .stars-outer {
        display: inline-block;
        position: relative;
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        color: #e4e4e4; /* Color for the empty stars */
    }

    .stars-inner {
        position: absolute;
        top: 0;
        left: 0;
        white-space: nowrap;
        overflow: hidden;
        color: #FFD700; /* Color for the filled stars */
        width: 0%; /* Initially set to 0%, dynamically updated via inline style */
    }

    /* Define 5 empty stars in the stars-outer container */
    .stars-outer::before {
        content: "\f005 \f005 \f005 \f005 \f005"; /* FontAwesome star unicode */
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
    }

    /* Define 5 filled stars in the stars-inner container, which will be clipped */
    .stars-inner::before {
        content: "\f005 \f005 \f005 \f005 \f005"; /* FontAwesome star unicode */
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
    }

    .rating-value {
        position: absolute;
        top: -20px; /* Adjust based on positioning */
        left: 0;
        font-size: 14px;
        font-weight: bold;
        color: #333;
        visibility: hidden; /* Hide by default */
    }

    .star-rating:hover .rating-value {
        visibility: visible; /* Show when hovering */
    }



</style>
<div class="d_brd_otr">
    <div class="d_brd_tp">
        <a href="javascript:window.history.back()"><img src="{{asset('images/left_arrow.png')}}" /></a>
        <h3>Course Listing</h3>
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
        <div>
            <a href="{{route("create_course")}}"><button class="mainsb_btn">New Course</button></a>
        </div>
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
<div id="tableData" class="tabBLE">
    @include('course.courseListing_pagination')
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
            url: "{{route('courseListing.pagination')}}",
            data:{page:page},
            success: function(data) {
                $('#tableData').html(data);
            }
        });
    }

    function search_data(keyword, page = 1) {
        $.ajax({
            url: "{{ route('courseListing.search') }}",
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

    function confirmDelete(courseId) {
        Swal.fire({
            title: 'Are you sure you want to delete this course?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('deletepage.course') }}", // Make sure this route points to your delete action
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: courseId
                    },
                    success: function(response) {
                        Swal.fire(
                            'Deleted!',
                            'The course has been deleted.',
                            'success'
                        ).then(() => {
                            location.reload(); // Reload the page after deleting the course
                        });
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'There was an error deleting the course.',
                            'error'
                        );
                    }
                });
            }
        });
    }


    $("#dateRange").daterangepicker({
        opens: "left",
        showDropdowns: true,
        linkedCalendars: false,
        autoUpdateInput: false,
        locale: {
            format: "YYYY-MM-DD",
            separator: " to ",
            applyLabel: "Apply",
            cancelLabel: "Clear",
            customRangeLabel: "Custom",
        },
    });

    $("#dateRange").on("apply.daterangepicker", function(ev, picker) {
        $("#startDate").val(picker.startDate.format("YYYYMMDD"));
        $("#endDate").val(picker.endDate.format("YYYYMMDD"));

        var startDate = $("#startDate").val();
        var endDate = $("#endDate").val();

        fetchEventsWithDate(1, startDate, endDate);

    });

    $('.star-rating').each(function () {
        const $star = $(this);
        const $ratingValue = $star.find('#ratingValue');

        // Show rating value on hover
        $star.on('mouseenter', function () {
            const rating = parseFloat($ratingValue.text()); // Get rating value
            $ratingValue.text(rating.toFixed(1)); // Set it in the span
        });

        $star.on('mouseleave', function () {
            $ratingValue.text($ratingValue.text()); // Keep the value static
        });
    });

</script>
@endsection