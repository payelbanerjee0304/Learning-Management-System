@extends('layouts.adminapp')
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
<div class="d_brd_otr">
    <div class="d_brd_tp">
        <a href="javascript:window.history.back()"><img src="{{asset('images/left_arrow.png')}}" /></a>
        <h3>All Ratings</h3>
    </div>
    <div class="evnt-srch">
        <div class="options">
            
        </div>
        <div class="search_bar">
            <input type="text" id="keyword" name="keyword" placeholder="Search" class="search_holder" />
            <input type="button" class="search-btn" />
            <div class="icon" id="searchSubmit">
                <img src="{{asset('images/search_icn.png')}}" alt="search_icn" />
            </div>
        </div>

        <div class="evnt-drpdwn">
            <h4>Sort By</h4>
            <select id="ratingStatus" name="ratingStatus" required>
                <option value="">All</option>
                <option value="5">5</option>
                <option value="4">4</option>
                <option value="3">3</option>
                <option value="2">2</option>
                <option value="1">1</option>
            </select>
        </div>

    </div>
</div>
<div id="tableData">
    @include('course.ratingGiven_pagination')
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
            url: "{{route('ratingGiven.pagination')}}",
            data:{page:page},
            success: function(data) {
                $('#tableData').html(data);
            }
        });
    }

    function search_data(keyword, page = 1) {
        $.ajax({
            url: "{{ route('ratingGiven.search') }}",
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

    $("#ratingStatus").on('change', function() {
        var ratingStatus = $(this).val();
        // console.log(ratingStatus);

        $.ajax({
            url: "{{route('ratingGiven.filter')}}",
            type: "GET",
            data: {
                ratingStatus,
            },
            success: function(response) {
                $("#tableData").html(response)
            }
        })
    })

</script>
@endsection