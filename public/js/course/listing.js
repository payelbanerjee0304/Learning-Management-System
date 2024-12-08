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