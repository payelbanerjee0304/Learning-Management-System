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
        <h3>Course Charges</h3>
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
    </div>
</div>
<div id="tableData" class="tabBLE">
    @include('admin.courseValue_pagination')

</div>
@endsection
@section('customJs')
<script>
    function showEditForm(id) {
        // Hide all open forms and show edit icons for other rows
        document.querySelectorAll('[id^="editForm_"]').forEach((form) => {
            form.style.display = 'none';
        });
        document.querySelectorAll('[id^="editIcon_"]').forEach((icon) => {
            icon.style.display = 'inline-block';
        });

        // Show the selected form and hide the edit icon
        const form = document.getElementById(`editForm_${id}`);
        const icon = document.getElementById(`editIcon_${id}`);
        if (form) {
            form.style.display = 'block';
        }
        if (icon) {
            icon.style.display = 'none';
        }
    }
    function toggleCustomInput(selectElement, id) {
        const customInput = document.getElementById(`customCourseValue_${id}`);
        if (selectElement.value === 'custom') {
            customInput.style.display = 'inline-block';
        } else {
            customInput.style.display = 'none';
            customInput.value = ''; // Clear custom input value
        }
    }

    function fetch_data(page) {
        $.ajax({
            url: "{{route('courseValue.pagination')}}",
            data:{page:page},
            success: function(data) {
                $('#tableData').html(data);
            }
        });
    }

    function search_data(keyword, page = 1) {
        $.ajax({
            url: "{{ route('courseValue.search') }}",
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