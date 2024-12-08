$(document).on("click", "#submitBtn", function () {
  const taskName = $("#taskname").val();
  const taskdescription = $("#taskdescription").val();

  const subtasks = JSON.parse($("#taskObjectString").val());

  var csrfToken = $('meta[name="csrf-token"]').attr("content");

  $.ajax({
    url: "/submit_course",
    type: "POST",
    data: {
      taskName,
      taskdescription,
      subtasks,
    },
    headers: {
      "X-CSRF-TOKEN": csrfToken,
    },
    success: function (response) {
      if (response.success == true) {
        Swal.fire({
          title: "Success!",
          text: "Task created successfully.",
          icon: "success",
          confirmButtonText: "OK",
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = "/admin/taskview";
          }
        });
      } else {
        Swal.fire({
          title: "Try Again!",
          text: "There was a problem creating the task.",
          icon: "error",
          confirmButtonText: "OK",
        });
      }
    },
  });
});
