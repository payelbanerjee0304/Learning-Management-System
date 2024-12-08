@extends('layouts.app')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    .course-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: start;
        gap: 2px;
    }
    .course-card {
        border: 1px solid #ddd;
        border-radius: 10px;
        overflow: hidden;
        width: calc(33.333% - 10px); /* Each card takes up one-third of the row, adjust for margin */
        margin-bottom: 20px; /* Space between rows */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease;
        background-color: #fff;
    }

    .course-card:hover {
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    /* Image Container for Positioning Play Icon */
    .image-container {
        position: relative;
        cursor: pointer;
        /* Changes cursor to hand on hover */
    }

    .course-image {
        width: 100%;
        height: 180px;
        object-fit: cover;
        filter: brightness(0.7);
        /* Reduces the brightness */
        transition: filter 0.3s ease;
    }

    /* Hover effect to restore brightness when hovering */
    .image-container:hover .course-image {
        filter: brightness(1);
        /* Restores the original brightness on hover */
    }

    /* Play Icon Overlay in the center of the image */
    .play-icon-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        cursor: pointer;
        /* Changes cursor to hand when hovering over the play icon */
    }

    .play-icon {
        font-size: 4rem;
        color: #ffffff;
        background-color: rgba(0, 0, 0, 0.6);
        /* Slight background for visibility */
        border-radius: 50%;
        padding: 10px;
    }

    /* Hover effect for play icon */
    .play-icon-overlay:hover .play-icon {
        background-color: rgba(0, 0, 0, 0.8);
    }

    .course-details {
        padding: 15px;
    }

    .course-title {
        font-size: 2rem;
        margin: 0 0 10px;
        color: #333;
    }

    .course-description {
        font-size: 1.5rem;
        color: #666;
        margin-bottom: 15px;
    }

    .course-meta {
        font-size: 1.1rem;
        color: #888;
        margin-bottom: 20px;
    }

    /* Progress Tracker */
    .progress-container {
        margin-bottom: 20px;
    }

    .progress-container label {
        font-size: 1.1rem;
        color: #333;
        display: block;
        margin-bottom: 5px;
    }

    .progress-bar {
        width: 100%;
        height: 10px;
        background-color: lightgray !important;
        border-radius: 5px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background-color: #990000;
        border-radius: 5px 0 0 5px;
    }

    .knwledg_section {
        display: flex;
        justify-content: space-between;
        /* Space out the sections */
        align-items: center;
        /* Align items vertically centered */
        margin-bottom: 12px;
    }

    .assignment .d_brd_otr {
        background-color: transparent !important;
    }

    .rating-container {
        text-align: center;
    }

    .rating-label {
        font-size: 12px;
        color: #333;
        margin-bottom: 1px; /* Adjust space between label and stars */
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

@section('content')

<div class="d_brd_otr">
    <div class="knwledg_section a">
        <div class="d_brd_tp abk">
            <!-- <a href="javascript:window.history.back()"><img src="{{ asset('images/left_arrow.png') }}" /></a> -->
            <h3>All Courses</h3>
        </div>
    </div>
    {{-- <div class="evnt-srch">
        <div class="search_bar">
            <input type="text" id="keyword" name="keyword" placeholder="Search Course" class="search_holder"
                style="background-color: #fef9e8;" />
            <input type="button" class="search-btn" />
            <div class="icon" id="searchSubmit">
                <img src="{{ asset('images/search_icn.png') }}" alt="search_icn" />
            </div>
        </div>
    </div> --}}
</div>

<div class="course-container"> 
    @include('course.courseView_pagination')
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Certificate Preview</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <iframe id="certificatePreview" style="width: 100%; height: 500px; border: none;"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="downloadCertificateBtn">Download</button>
      </div>
    </div>
  </div>
</div>


@endsection

@section('customJs')
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {

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

        $('#exampleModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var courseId = button.data('course-id');
            var courseName = button.data('course-name');
            var userName = button.data('user-name');

            $(this).find('#courseId').text(courseId);
            $(this).find('#courseName').text(courseName);
            $(this).find('#userName').text(userName);

            // Update the iframe source with the certificate content
            let certificateContent = `
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Certificate of Achievement</title>
                    <style>
                        * {
                            margin: 0;
                            padding: 0;
                            box-sizing: border-box;
                        }
                        body {
                            font-family: Arial, sans-serif;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            background-color: #f4f4f4;
                            height: 100vh;
                            overflow: hidden;
                        }
                        .certificate {
                            width: 50%; /* Further reduce width to 50% */
                            max-width: 500px; /* Set a maximum width to 500px */
                            height: auto; /* Allow height to adjust automatically */
                            background-color: #fff;
                            border: 15px solid #d4af37; /* Keep border width */
                            position: relative;
                            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
                            overflow: hidden;
                            padding: 20px; /* Padding around the certificate */
                            margin: 20px; /* Margin around the certificate */
                        }
                        .certificate-content {
                            padding: 20px; /* Adjusted padding */
                            display: flex;
                            flex-direction: column;
                            justify-content: center; /* Center align content */
                            align-items: center; /* Center align content */
                        }

                        .footer {
                            display: flex;
                            flex-direction: column;
                            align-items: center;
                            gap: 10px; /* Reduced gap */
                        }

                        .logo {
                            max-width: 60px; /* Further adjust logo size */
                        }

                        .certificate-header {
                            background-color: #800000;
                            color: white;
                            padding: 10px; /* Keep reduced padding */
                            font-size: 16px; /* Further reduced font size */
                            font-weight: bold;
                            text-align: center;
                            position: relative;
                        }
                        .title {
                            font-size: 24px; /* Further reduced font size */
                            text-align: center;
                            margin: 10px 0; /* Adjusted margin */
                            font-family: 'Georgia', serif;
                            font-weight: bold;
                        }
                        .subtitle {
                            text-align: center;
                            font-size: 10px; /* Reduced font size */
                            color: #888;
                            margin: 5px 0; /* Reduced margin */
                        }
                        .content {
                            text-align: center;
                            font-size: 9px; /* Reduced font size */
                            color: #666;
                            margin: 10px 0; /* Adjusted margin */
                            padding: 0 10px; /* Reduced padding */
                        }
                        .recipient-name {
                            text-align: center;
                            font-size: 20px; /* Further reduced font size */
                            font-family: 'Brush Script MT', cursive;
                            margin: 10px 0; /* Adjusted margin */
                            color: #000;
                        }
                        .line {
                            width: 80%;
                            height: 1px;
                            background-color: #000;
                            margin: 10px auto;
                        }
                        .signature {
                            text-align: center;
                            font-size: 10px; /* Reduced font size */
                            color: #888;
                        }
                        .signature-line {
                            width: 150px; /* Kept same size */
                            height: 1px;
                            background-color: #d4af37;
                            margin: 10px auto 0;
                        }
                    </style>

                </head>
                <body>
                    <div class="certificate">
                        <div class="certificate-content">
                            <div class="certificate-header">Certificate of Completion</div>
                            <div class="title">Congratulations</div>
                            <div class="subtitle">ON YOUR ACCOMPLISHMENT!</div>
                            <div class="content">This is to certify that</div>
                            <div class="recipient-name">${userName}</div>
                            <div class="line"></div>
                            <div class="content">successfully completed the Online Course <div class="title">${courseName}</div></div>
                            <div class="footer">
                                <div class="signature">
                                    Signature
                                    <div class="signature-line"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </body>
                </html>
            `;
            
            // Get the iframe and write the certificate content into it
            let iframe = document.getElementById('certificatePreview');
            iframe.contentWindow.document.open();
            iframe.contentWindow.document.write(certificateContent);
            iframe.contentWindow.document.close();

            $('#downloadCertificateBtn').data('course-id', courseId);
        });


        $('#downloadCertificateBtn').on('click', function () {
            let courseId = $(this).data('course-id');

            // Redirect to the download route to initiate download
            window.location.href = `/generate-certificate/${courseId}`;
        });

        
    });

    function goBackWithReload() {
    // Set a flag in session storage to indicate reload is needed
    sessionStorage.setItem("reload", "true");
    // Go back to the previous page
    window.history.back();
    }
    // Check if the page was navigated back and requires reload
    window.addEventListener("pageshow", function () {
    if (
        sessionStorage.getItem("reload") ||
        event.persisted ||
        performance.navigation.type === 2
    ) {
        sessionStorage.removeItem("reload"); // Remove the flag after reload
        window.location.reload(); // Reload the page
    }
    });
</script>

<script>


    function fetch_data(page) {
        $.ajax({
            url: "{{route('coursesView.pagination')}}",
            data:{page:page},
            success: function(data) {
                $('#tableData').html(data);
            }
        });
    }

    function search_data(keyword, page = 1) {
        $.ajax({
            url: "{{ route('coursesView.search') }}",
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
