function validateForm() {
  let isValid = true;

  // Resetting previous error messages
  // $("#username_error").text("");
  $("#ratings_error").text("");
  $("#comment_error").text("");

  // Checking Task Name
  // let username = $("#username").val();
  // if (!username) {
  //     $("#username_error").text("Username is required");
  //     isValid = false;
  // }

  let rating = $("input[name='ratings']:checked").val();
  if (!rating) {
    $("#ratings_error").text("Please submit the course rating");
    isValid = false;
  }

  return isValid;
}

$("#username").on("input", function () {
  if ($(this).val() !== "") {
    $("#username_error").text("");
  }
});

$("input[name='ratings']").change(function () {
  $("#ratings_error").text("");
});

let editor;
if (document.querySelector("#comment")) {
  ClassicEditor.create(document.querySelector("#comment"), {})
    .then((newEditor) => {
      editor = newEditor;

      newEditor.model.document.on("change:data", () => {
        const editorContent = newEditor.getData();
        if (editorContent.trim() !== "") {
          $("#comment_error").text("");
        }
      });
    })
    .catch((error) => {
      console.error(error);
    });
}

$("#submitBtn").click(function (e) {
  if (!validateForm()) {
    event.preventDefault();
    return;
  }
  e.preventDefault();

  var selectedRating = $('input[name="ratings"]:checked').val();
  var formData = {
    courseId: $("#courseId").val(),
    courseName: $("#courseName").val(),
    userId: $("#userId").val(),
    username: $("#username").val(),
    ratings: selectedRating,
    comment: editor.getData(),
  };

  var csrfToken = $('meta[name="csrf-token"]').attr("content");

  $.ajax({
    url: "/submit_rating",
    type: "POST",
    data: formData,
    headers: {
      "X-CSRF-TOKEN": csrfToken,
    },
    success: function (response) {
      if (response.success === true) {
        Swal.fire({
          title: "Success!",
          text: response.message,
          icon: "success",
          confirmButtonText: "OK",
        }).then((result) => {
          // window.location.reload();
          window.location.href = "/coursesView";
        });
      } else {
        Swal.fire({
          title: "Try Again!",
          text: "There was a problem",
          icon: "error",
          confirmButtonText: "OK",
        });
      }
    },
    error: function (xhr) {
      // Handle error response
      var errors = xhr.responseJSON.errors;
      if (errors.username) {
        $("#username_error").text(errors.username[0]);
      }
      if (errors.ratings) {
        $("#ratings_error").text(errors.ratings[0]);
      }
      if (errors.comment) {
        $("#comment_error").text(errors.comment[0]);
      }
    },
  });
});
