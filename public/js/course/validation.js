// Function to validate the form
function validateForm() {
  let isValid = true;

  // Resetting previous error messages
  $("#courseName_error").text("");
  $("#courseDescription").text("");

  // Checking Task Name
  let courseName = $("#courseName").val();
  if (!courseName) {
    $("#courseName_error").text("Course Name is required");
    isValid = false;
  }

  let courseDescription = $("#courseDescription").val();
  if (!courseDescription) {
    $("#courseDescription_error").text("Course Description is required");
    isValid = false;
  }

  return isValid;
}

// Remove error message on input change
$("#courseName").on("input", function () {
  $("#courseName_error").text("");
});

$("#courseDescription").on("input", function () {
  $("#courseDescription_error").text("");
});

// Validate task points on form submission
$("#dynamic-form").on("submit", function (event) {
  if (!validateForm()) {
    event.preventDefault();
  }

  var isValid = true;
  $(".chaptername").each(function () {
    if ($(this).val() != "") {
      $(this).next(".chaptername_error").html("");
    } else {
      $(this).next(".chaptername_error").html("Please enter chapter name");
    }
  });

  $(".subtask-question-text").each(function () {
    if ($(this).val() != "") {
      $(this).next(".subtask-question-text-error").html("");
    } else {
      $(this).next(".subtask-question-text-error").html("Please enter topic name");
      isValid = false;
    }
  });

  $(".subtask-question-select").each(function () {
    if ($(this).val() != "") {
      $(this).next(".subtask-question-select-error").html("");
    } else {
      $(this).next(".subtask-question-select-error").html("Choose an option");
      isValid = false;
    }
  });

  if (!isValid) {
    event.preventDefault();
  }

  if (!validateForms()) {
    event.preventDefault(); // Prevent form submission if validation fails
  }
});

// Function to validate all form sections
function validateForms() {
  var isValid = true; 

  // Loop through each form section
  $(".form-section").each(function (index) {
    var question = $(this).find('input[name*="[question]"]');
    var type = $(this).find('select[name*="[type]"]');
  });

  return isValid;
}

$("#subtask-container").on("input", ".chaptername", function () {
  if ($(this).val() != "") {
    $(this).next(".chaptername_error").html("");
  } else {
    $(this).next(".chaptername_error").html("Please enter chapter name");
  }
});

$("#subtask-container").on("input", ".subtask-question-text", function () {
  if ($(this).val() != "") {
    $(this).next(".subtask-question-text-error").html("");
  } else {
    $(this).next(".subtask-question-text-error").html("Please enter topic name");
  }
});

$("#subtask-container").on("change", ".subtask-question-select", function () {
  if ($(this).val() != "") {
    $(this).next(".subtask-question-select-error").html("");
  } else {
    $(this).next(".subtask-question-select-error").html("Choose an option");
  }
});
