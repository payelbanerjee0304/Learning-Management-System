$(document).on("click", ".add-subtask", function () {
  var subtaskContainer = $("#subtask-container");

  var lastSubtask = subtaskContainer.children(".subtask").last();
  var lastSubtaskNumber = Number(lastSubtask.find(".subtask-number").html());

  var newSubtaskNumber = lastSubtaskNumber + 1;

  var newSubtaskTemplate = $($("#subtask-template").html());

  newSubtaskTemplate.find(".subtask-number").html(newSubtaskNumber);

  var removeSubtaskButton = $(
    '<button type="button" class="remove-form remove-subtask ex-rmv-btn">-</button>'
  );

  subtaskContainer.append(newSubtaskTemplate, removeSubtaskButton);
  $(".add-subtask").prop("hidden", true);
  $(".notifyMsg").prop("hidden", false);

  // Hide the "add-subtask" button and show the notify message
  $(".add-subtask").prop("hidden", true);
  $(".notifyMsg").prop("hidden", false);
  newSubtaskTemplate.find("textarea").each(function () {
    var newEditorId = "editor_" - newSubtaskNumber;
    $(this).attr("id", newEditorId);

    // Ensure that CKEditor is initialized for the new textarea
    ClassicEditor.create(document.querySelector("#" + newEditorId))
      .then((editor) => {
        // Store the CKEditor instance in the editorInstances object
        editorInstances[newEditorId] = editor;
        console.log("CKEditor initialized for:", newEditorId);
      })
      .catch((error) => {
        console.error("Error initializing CKEditor:", error);
      });
  });
});

$(document).on("click", ".remove-subtask", function () {
  var removeSubtaskButton = $(this);
  var closestSubtask = removeSubtaskButton.prevAll(".subtask").first();

  closestSubtask.remove();
  removeSubtaskButton.remove();
  $(".add-subtask").prop("hidden", false);
  $(".notifyMsg").prop("hidden", true);
});
editorInstances = {};
$(document).on("click", ".add-subtask-question", function () {
  var subtaskQuestionContainer = $(this).closest(".subtask-question-container");

  var lastSubtaskQuestion = subtaskQuestionContainer
    .children(".subtask-question")
    .last();

  var lastSubtaskQuestionNumber = Number(
    lastSubtaskQuestion.find(".subtask-question-number").html()
  );

  var newSubtaskQuestionNumber = lastSubtaskQuestionNumber + 1;

  // Clone the new subtask question from the template
  var newSubtaskQuestion = $($("#subtask-question-template").html());

  newSubtaskQuestion
    .find(".subtask-question-number")
    .html(newSubtaskQuestionNumber);

  // Update the textarea ID, name, and placeholder for CKEditor
  newSubtaskQuestion.find("textarea").each(function () {
    // Set a unique ID for the textarea
    $(this).attr("id", "editor_" + newSubtaskQuestionNumber);
    // Update the name to ensure uniqueness (if needed)
    $(this).attr(
      "name",
      "questions[" + (newSubtaskQuestionNumber - 1) + "][lecture][text]"
    );
    // Clear the placeholder to avoid showing numbers
    $(this).attr("placeholder", "Enter text"); // Optional: Set a generic placeholder
    // Set the value to empty for a new question
    $(this).val(""); // Ensure the textarea is empty
  });

  var removeButton = $(
    '<button type="button" class="remove-form remove-subtask-question ex-rmv-btn">-</button>'
  );

  newSubtaskQuestion.append(removeButton);

  // Insert the new question after the last one
  lastSubtaskQuestion.after(newSubtaskQuestion);

  // Initialize CKEditor for the newly added textarea
  var textarea = newSubtaskQuestion.find("textarea")[0];
  ClassicEditor.create(textarea)
    .then((editor) => {
      editorInstances[$(textarea).attr("id")] = editor; // Store the editor instance
      // console.log(editorInstances[$(textarea).attr('id')]);
    })
    .catch((error) => {
      console.error("Error initializing CKEditor:", error);
    });
});

$(document).on("click", ".remove-subtask-question", function () {
  var removeSubtaskQuestionButton = $(this);
  var closestSubtaskQuestion =
    removeSubtaskQuestionButton.closest(".subtask-question");

  closestSubtaskQuestion.remove();
  removeSubtaskQuestionButton.remove();
});

$(document).on("click", ".add-qna", function () {
  var subtaskQuestionContainer = $(this).closest(".qna-container");

  var lastSubtaskQuestion = subtaskQuestionContainer
    .children(".subtask-qna")
    .last();

  var lastSubtaskQuestionNumber = Number(
    lastSubtaskQuestion.find(".subtask-qna-number").html()
  );

  var newSubtaskQuestionNumber = lastSubtaskQuestionNumber + 1;

  var newSubtaskQuestion = $($("#subtask-qna-template").html());

  newSubtaskQuestion.find(".subtask-qna-number").html(newSubtaskQuestionNumber);

  var removeButton = $(
    '<button type="button" class="remove-form remove-qna ex-rmv-btn">-</button>'
  );

  newSubtaskQuestion.append(removeButton);

  // subtaskQuestionContainer.append(newSubtaskQuestion);
  lastSubtaskQuestion.after(newSubtaskQuestion);
});

$(document).on("click", ".remove-qna", function () {
  var removeSubtaskQuestionButton = $(this);
  var closestSubtaskQuestion =
    removeSubtaskQuestionButton.closest(".subtask-qna");

  closestSubtaskQuestion.remove();
  removeSubtaskQuestionButton.remove();
});

$(document).on("click", ".add-option", function () {
  var optionsContainer = $(this).closest(".qna-options-container");
  var optionCount = optionsContainer.find(".option").length + 1;
  var newOption = optionsContainer.find(".option:first").clone();

  var subtaskNumber = Number(
    $(this).closest(".subtask").find(".subtask-number").text()
  );

  var lastSubtaskQuestion = $(this).closest(".subtask-question");

  var subtaskQuestionNumber = Number(
    lastSubtaskQuestion.find(".subtask-question-number").html()
  );

  newOption
    .find("input[type=text]")
    .val("")
    .attr("placeholder", "Option " + optionCount);

  // Reset the button value and enable it
  newOption
    .find("button")
    .val(subtaskNumber + "." + subtaskQuestionNumber + "." + optionCount)
    .prop("disabled", false);

  // Reset the checkbox to unchecked state
  newOption.find("input[type=checkbox]").prop("checked", false); // Ensure checkbox is unchecked
  newOption.find(".delete-qna-optn").remove();

  // Append the new option to the options container
  newOption.appendTo(optionsContainer.find(".options"));
  var removeOptButton = $(
    '<button type="button" class="remove-form remove-qna-optn ex-rmv-btn">-</button>'
  );

  newOption.append(removeOptButton);
});

$(document).on("click", ".remove-qna-optn", function () {
  var removeQnaOptionButton = $(this);
  // console.log(removeSubtaskQuestionButton);
  var closestOptionDiv = removeQnaOptionButton.closest(".option");

  // Remove the entire option div
  closestOptionDiv.remove();
});

$(document).on("change", '.form-section select[name*="[type]"]', function () {
  var type = $(this).val();
  var optionsContainer = $(this)
    .closest(".form-section")
    .find(".options-container");

  var fileOption = optionsContainer.find(".fileupload-option");
  var textOption = optionsContainer.find(".text-option");
  var youtubeOption = optionsContainer.find(".youtube-option");
  var pdfOption = optionsContainer.find(".pdf-option");

  if (type === "file") {
    optionsContainer.show();
    fileOption.show();
    textOption.hide();
    youtubeOption.hide();
    pdfOption.hide();
    textOption.find('input[type="text"]').val("");
    youtubeOption.find('input[type="text"]').val("");
    pdfOption.find('input[type="file"]').val("");
    // textError.hide();
  } else if (type === "pdf") {
    optionsContainer.show();
    pdfOption.show();
    textOption.hide();
    youtubeOption.hide();
    fileOption.hide();
    textOption.find('input[type="text"]').val("");
    youtubeOption.find('input[type="text"]').val("");
    fileOption.find('input[type="file"]').val("");
  } else if (type === "text") {
    optionsContainer.show();
    textOption.show();
    fileOption.hide();
    pdfOption.hide();
    youtubeOption.hide();
    fileOption.find('input[type="file"]').val("");
    pdfOption.find('input[type="file"]').val("");
    youtubeOption.find('input[type="text"]').val("");
  } else if (type === "youtube") {
    optionsContainer.show();
    youtubeOption.show();
    fileOption.hide();
    pdfOption.hide();
    textOption.hide();
    fileOption.find('input[type="file"]').val("");
    pdfOption.find('input[type="file"]').val("");
    textOption.find('input[type="text"]').val("");
  } else {
    optionsContainer.hide();
    fileOption.hide();
    textOption.hide();
    pdfOption.hide();
    youtubeOption.hide();
  }
});

// Add the remove button to existing form sections, except the first one

function renderOptions(optionsContainer, type) {
  var options = optionsContainer.find(".option");
  var optionCount = options.length;
  // Ensure there is only one option initially
  if (optionCount > 1) {
    options.slice(1).remove();
  }
  // Update option signs based on type
  updateOptionSigns(optionsContainer, type);
}

// Remove error messages for question and type fields when they are being filled
$(document).on(
  "input change",
  'input[name*="[question]"], select[name*="[type]"]',
  function () {
    //validateForms();
  }
);

// Add new Subtask
// $("#submitBtn").click(function () {
//   var taskpoints = Number($("#taskpoints").val());
//   var topics = [];

//   $(".subtask").each(function () {
//     var alltopic = {};
//     $(this)
//       .find(".chaptername")
//       .each(function () {
//         var keys = $(this).data("name");
//         alltopic[keys] = $(this).val() ?? "";
//       });

//     var topicDetails = [];

//     $(this)
//       .find(".subtask-question")
//       .each(function () {
//         var inputs = {};
//         $(this)
//           .find(
//             'input[type="text"],input[type="file"], input[type="number"], input[type="radio"]:checked, textarea, select'
//           )
//           .each(function () {
//             var key = $(this).data("name");
//             inputs[key] = $(this).val() ?? "";
//           });
//         // var option = $(this).find(".subtask-question-option").first().val();
//         // inputs.options = option;

//         topicDetails.push(inputs);
//       });

//     alltopic.topicDetails = topicDetails;
//     topics.push(alltopic);
//   });

//   var taskObjectString = JSON.stringify(topics);

//   $("#taskObjectString").val(taskObjectString);
//   // console.log(taskObjectString);
// });

function validateForm() {
  let isValid = true;

  // Resetting previous error messages
  $("#courseName_error").text("");
  $("#courseDescription_error").text("");
  $("#createdBy_error").text("");
  $("#learningDesc_error").text("");
  $(".qna-question-text-error").text("");
  $(".qnaoptn_error").text("");
  $(".qna-points-text-error").text("");

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

  let createdBy = $("#createdBy").val();
  if (!createdBy) {
    $("#createdBy_error").text("Creator Name is required");
    isValid = false;
  }

  let learningDesc = eeditor.getData(); // Retrieve CKEditor content
  if (!learningDesc || learningDesc.trim() === "") {
    $("#learningDesc_error").text("This field is required");
    isValid = false;
  }

  var thumbnailInput = $("#thumbnail");
  if (!thumbnailInput.val() && !$("#currentThumbnailLink").length) {
    $("#thumbnail_error").html("Thumbnail is required"); // Updated to match your HTML structure
    isValid = false;
  } else {
    $("#thumbnail_error").html(""); // Remove error if file is selected
  }
  if (thumbnailInput[0].files.length > 0) {
    var file = thumbnailInput[0].files[0];
    var fileType = file.type;

    if (!["image/jpeg", "image/png", "image/webp"].includes(fileType)) {
      $("#thumbnail_error").html(
        "Only JPEG, PNG, and WebP formats are accepted."
      );
      isValid = false;
    }
  }

  let totalQnaPoints = 0;

  // Validate Chapter Names
  $(".chaptername").each(function () {
    if ($(this).val() != "") {
      $(this).next(".chaptername_error").html("");
    } else {
      $(this).next(".chaptername_error").html("Please enter chapter name");
      isValid = false;
    }
  });

  // Validate Passmarks
  $(".passmarks").each(function () {
    if ($(this).val() != "") {
      $(this).next(".passmarks_error").html("");
    } else {
      $(this).next(".passmarks_error").html("Please enter qualification marks");
      isValid = false;
    }
  });

  // Validate Topics
  $(".subtask-question-text").each(function () {
    if ($(this).val() != "") {
      $(this).next(".subtask-question-text-error").html("");
    } else {
      $(this)
        .next(".subtask-question-text-error")
        .html("Please enter topic name");
      isValid = false;
    }
  });

  // Validate Topic Options
  $(".subtask-question-select").each(function () {
    if ($(this).val() != "") {
      $(this).next(".subtask-question-select-error").html("");
    } else {
      $(this).next(".subtask-question-select-error").html("Choose an option");
      isValid = false;
    }
  });

  $(document).on("input", ".text-option input[type='text']", function () {
    if ($(this).val() !== "") {
      $(this).closest(".options-container").find(".text-error").html("");
    }
  });
  $(document).on("input", ".youtube-option input[type='text']", function () {
    if ($(this).val() !== "") {
      $(this).closest(".options-container").find(".youtube-error").html("");
    }
  });

  // $(document).on(
  //   "change",
  //   ".fileupload-option input[type='file']",
  //   function () {
  //     if ($(this).val() !== "") {
  //       $(this)
  //         .closest(".options-container")
  //         .find(".fileupload-error")
  //         .html("");
  //     }
  //   }
  // );

  $(".form-section").each(function () {
    var type = $(this).find('select[name*="[type]"]').val();
    var optionsContainer = $(this).find(".options-container");
    // console.log(type);

    if (type === "file") {
      var fileInput = optionsContainer.find(
        ".fileupload-option input[type='file']"
      );
      var existingVideo = optionsContainer.find(".currentfileLink").length > 0;

      if (!fileInput.val() && !existingVideo) {
        optionsContainer
          .find(".fileupload-error")
          .html("Video file upload is required");
        isValid = false;
      } else {
        optionsContainer.find(".fileupload-error").html(""); // Remove error if file is selected
      }
    } else if (type === "pdf") {
      var pdfInput = optionsContainer.find(".pdf-option input[type='file']");
      var existingPdf = optionsContainer.find(".currentpdfLink").length > 0;

      // Function to validate PDF input in real-time
      function validatePdfInput() {
        var file = pdfInput[0].files[0]; // Get the file object
        var fileType = file ? file.type : ""; // Get the MIME type of the file
        var maxSize = 5 * 1024 * 1024; // Maximum file size (5MB)

        if (!pdfInput.val() && !existingPdf) {
          optionsContainer
            .find(".pdfError")
            .html("PDF file upload is required");
          isValid = false;
        } else if (fileType !== "application/pdf") {
          pdfInput.val(""); // Clear input field if the file is not a PDF
          optionsContainer.find(".pdfError").html("Only PDF files are allowed");
          isValid = false;
        } else if (file.size > maxSize) {
          pdfInput.val(""); // Clear the input if the file size exceeds 5MB
          optionsContainer
            .find(".pdfError")
            .html("File size must be less than 5MB");
          isValid = false;
        } else {
          optionsContainer.find(".pdfError").html(""); // Clear error if PDF is valid
          isValid = true;
        }
      }

      // Real-time validation on file input change
      pdfInput.on("change", function () {
        validatePdfInput(); // Validate when a file is selected
      });

      // Initial validation if form is submitted
      if (!pdfInput.val() && !existingPdf) {
        optionsContainer.find(".pdfError").html("PDF file upload is required");
        isValid = false;
      } else {
        optionsContainer.find(".pdfError").html(""); // Remove error if PDF is selected
      }
    } else if (type === "text") {
      var ckeditorField = optionsContainer.find(".ckeditor"); // Get the CKEditor field within the optionsContainer

      ckeditorField.each(function () {
        var editorId = $(this).attr("id"); // Get the ID of the CKEditor instance
        var editorInstance = editorInstances[editorId]; // Retrieve the CKEditor instance from editorInstances object

        if (editorInstance) {
          var editorContent = editorInstance.getData(); // Get CKEditor content
          if (!editorContent.trim()) {
            optionsContainer.find(".text-error").html("This field is required");
            isValid = false;
          } else {
            optionsContainer.find(".text-error").html(""); // Remove error if CKEditor has content
          }
        } else {
          console.error("CKEditor instance not found for ID:", editorId);
        }
      });
    } else if (type === "youtube") {
      var youtubeInput = optionsContainer.find(
        ".youtube-option input[type='text']"
      );
      var youtubeRegex =
        /^(https?:\/\/)?(www\.)?(youtube\.com\/(watch\?v=|shorts\/)|youtu\.be\/).+$/;

      if (!youtubeInput.val()) {
        optionsContainer.find(".youtube-error").html("This field is required");
        isValid = false;
      } else if (!youtubeRegex.test(youtubeInput.val())) {
        optionsContainer
          .find(".youtube-error")
          .html("Please enter a valid YouTube link");
        isValid = false;
      } else {
        optionsContainer.find(".youtube-error").html(""); // Remove error if valid YouTube link is entered
      }

      // Real-time validation for YouTube input
      youtubeInput.on("input", function () {
        if (!youtubeRegex.test(youtubeInput.val())) {
          optionsContainer
            .find(".youtube-error")
            .html("Please enter a valid YouTube link");
          isValid = false;
        } else {
          optionsContainer.find(".youtube-error").html(""); // Clear error once valid YouTube link is entered
        }
      });
    }
  });

  $(document).on("change", '.form-section select[name*="[type]"]', function () {
    var optionsContainer = $(this)
      .closest(".form-section")
      .find(".options-container");
    optionsContainer.find(".fileupload-error").html(""); // Clear file upload error
    // optionsContainer.find(".pdfError").html(""); // Clear file upload error
    optionsContainer.find(".text-error").html(""); // Clear text error
    optionsContainer.find(".youtube-error").html(""); // Clear text error
  });

  $(".subtask-qna").each(function (qnaIndex) {
    let questionInput = $(this).find(".qna-question-text");
    let pointsInput = $(this).find(".qna-points-text");

    // Check if question is filled
    if (questionInput.val() === "") {
      $(this).find(".qna-question-text-error").text("Question is required");
      isValid = false;
    }

    // Check if points are filled
    if (pointsInput.val() === "") {
      $(this).find(".qna-points-text-error").text("Points are required");
      isValid = false;
    } else {
      // Add points to the total
      totalQnaPoints += parseFloat(pointsInput.val()) || 0;
    }

    // Validate options and correct answers
    let options = $(this).find(".qna-options-container .option");
    let isOptionValid = false;
    let isCorrectAnswerChecked = false;

    options.each(function () {
      let optionValue = $(this).find('input[type="text"]').val();
      let isChecked = $(this)
        .find('input[type="checkbox"].correctAnswer')
        .is(":checked");

      // Check if at least one option is filled
      if (optionValue !== "") {
        isOptionValid = true;
      }

      // Check if at least one correct answer is selected
      if (isChecked) {
        isCorrectAnswerChecked = true;
      }
    });

    if (!isOptionValid) {
      $(this).find(".qnaoptn_error").text("At least one option is required");
      isValid = false;
    }

    if (!isCorrectAnswerChecked) {
      $(this).find(".qnaoptn_error").text("Select at least one correct answer");
      isValid = false;
    }

    $(".qna-options-container").each(function () {
      let optionInputs = $(this).find('input[type="text"]');

      // Ensure each option input is filled before adding another
      let allOptionsFilled = true;
      optionInputs.each(function () {
        if ($(this).val() === "") {
          allOptionsFilled = false;
        }
      });

      if (!allOptionsFilled) {
        $(this)
          .closest(".subtask-qna")
          .find(".qnaoptn_error")
          .text("Please fill the empty option field.");
        isValid = false;
      }
    });
  });

  // Validate Passmarks and compare with totalQnaPoints
  $(".passmarks").each(function () {
    let passmarks = parseFloat($(this).val()) || 0;
    let subtaskContainer = $(this).closest(".subtask");

    // Calculate totalPoints as the sum of .qna-points-text values within this subtask container
    let totalPoints = 0;
    subtaskContainer.find(".qna-points-text").each(function () {
      let pointValue = parseFloat($(this).val()) || 0;
      console.log("QNA Points:", $(this).val(), "Parsed Value:", pointValue);
      totalPoints += pointValue;
    });

    console.log("Total Points for current .passmarks:", totalPoints);

    if (passmarks !== 0) {
      if (passmarks > totalPoints) {
        $(this)
          .next(".passmarks_error")
          .html(
            `Passmarks (${passmarks}) cannot be greater than total points (${totalPoints})`
          );
        isValid = false;
      } else {
        $(this).next(".passmarks_error").html("");
      }
    } else {
      $(this).next(".passmarks_error").html("Please enter qualification marks");
      isValid = false;
    }
  });

  $(".fileupload-error").text(""); // Clear any previous file upload errors

  // Real-time file upload error handling
  $(".fileupload-option input[type='file']").each(function () {
    handleFileUploadErrors($(this));
  });

  // Scroll to the first visible error message
  if (!isValid) {
    const firstVisibleError = $(".error:visible")
      .filter(function () {
        return $(this).text().trim() !== "";
      })
      .first();

    if (firstVisibleError.length) {
      const errorOffset = firstVisibleError.offset().top;
      const windowHeight = $(window).height();
      const scrollTo =
        errorOffset - windowHeight / 2 + firstVisibleError.outerHeight() / 2;

      $("html, body").animate(
        {
          scrollTop: scrollTo,
        },
        30
      );
    }
  }

  return isValid;
}

// Remove error message on input change
$("#courseName").on("input", function () {
  if ($(this).val() !== "") {
    $("#courseName_error").text("");
  }
});

$("#courseDescription").on("input", function () {
  if ($(this).val() !== "") {
    $("#courseDescription_error").text("");
  }
});

$("#createdBy").on("input", function () {
  if ($(this).val() !== "") {
    $("#createdBy_error").text("");
  }
});

// Real-time error handling for Thumbnail
$("#thumbnail").on("change", function () {
  if ($(this).val() !== "") {
    $("#thumbnail_error").text(""); // Clear error if a file is selected
  }
});

// Real-time validation for dynamic inputs (Chapter Names, Topics, Select)
$("#subtask-container").on("input", ".chaptername", function () {
  if ($(this).val() !== "") {
    $(this).next(".chaptername_error").html("");
  }
});
$("#subtask-container").on("input", ".passmarks", function () {
  if ($(this).val() !== "") {
    $(this).next(".passmarks_error").html("");
  }
});

$("#subtask-container").on("input", ".subtask-question-text", function () {
  if ($(this).val() !== "") {
    $(this).next(".subtask-question-text-error").html("");
  }
});

$("#subtask-container").on("change", ".subtask-question-select", function () {
  if ($(this).val() !== "") {
    $(this).next(".subtask-question-select-error").html("");
  }
});

// Real-time validation for question text
$(document).on("input", ".qna-question-text", function () {
  if ($(this).val().trim() === "") {
    $(this).next(".qna-question-text-error").text("Question is required");
  } else {
    $(this).next(".qna-question-text-error").text("");
  }
});

// Real-time validation for points text
$(document).on("input", ".qna-points-text", function () {
  if ($(this).val().trim() === "") {
    $(this).next(".qna-points-text-error").text("Points is required");
  } else {
    $(this).next(".qna-points-text-error").text("");
  }
  // if ($(this).val() !== "") {
  //   $(this).next(".qna-points-text-error").text("");
  // }
});

// Real-time validation for options
$(document).on("input", ".subtask-question-option", function () {
  const $optionsContainer = $(this).closest(".qna-options-container");

  // Check if the current input is empty
  if ($(this).val().trim() === "") {
    // Find the corresponding checkbox
    const checkboxIndex = $optionsContainer
      .find(".subtask-question-option")
      .index(this);
    const $checkbox = $optionsContainer
      .find(".correctAnswer")
      .eq(checkboxIndex);

    // If the checkbox is checked, show the error
    if ($checkbox.is(":checked")) {
      $optionsContainer.find(".qnaoptn_error").text("Option is required");
    }
  } else {
    // Clear error if this input is filled
    const checkboxIndex = $optionsContainer
      .find(".subtask-question-option")
      .index(this);
    const $checkbox = $optionsContainer
      .find(".correctAnswer")
      .eq(checkboxIndex);
    if ($checkbox.is(":checked")) {
      $optionsContainer.find(".qnaoptn_error").text("");
    }
  }

  // Check if any option is filled and any checkbox is checked
  validateOptions($optionsContainer);
});

// Real-time validation for correct answer checkbox
$(document).on("change", ".correctAnswer", function () {
  const $optionsContainer = $(this).closest(".qna-options-container");

  // Validate based on the state of the checkbox
  validateOptions($optionsContainer);
});

// Function to validate options and checkboxes
function validateOptions($optionsContainer) {
  const isAnyOptionFilled =
    $optionsContainer
      .find(".subtask-question-option")
      .filter((_, input) => $(input).val().trim() !== "").length > 0;
  const isAnyChecked =
    $optionsContainer.find(".correctAnswer:checked").length > 0;

  // Show the error message if no options are filled and no checkboxes are checked
  if (isAnyOptionFilled && !isAnyChecked) {
    $optionsContainer
      .find(".qnaoptn_error")
      .text("Select at least one correct answer");
  } else if (isAnyChecked) {
    // If any checkbox is checked, check if their corresponding inputs are filled
    const anyCheckboxWithEmptyInput = $optionsContainer
      .find(".correctAnswer")
      .filter((index) => {
        const $input = $optionsContainer
          .find(".subtask-question-option")
          .eq(index);
        return (
          $input.val().trim() === "" &&
          $optionsContainer.find(".correctAnswer").eq(index).is(":checked")
        );
      });

    // If any checkbox is checked but its corresponding input is empty, show the error
    if (anyCheckboxWithEmptyInput.length > 0) {
      $optionsContainer.find(".qnaoptn_error").text("Option is required");
    } else {
      $optionsContainer.find(".qnaoptn_error").text(""); // Clear the error if all are satisfied
    }
  } else {
    $optionsContainer.find(".qnaoptn_error").text("");
  }
}

function validateThumbnail() {
  var thumbnailInput = $("#thumbnail");

  if (thumbnailInput[0].files.length > 0) {
    var file = thumbnailInput[0].files[0];
    var fileType = file.type;

    if (!["image/jpeg", "image/png", "image/webp"].includes(fileType)) {
      if (fileType.startsWith("video/")) {
        thumbnailInput.val("");
        $("#thumbnail_error").html(
          "Videos are not accepted. Please select an image."
        );
        isValid = false;
      } else {
        $("#thumbnail_error").html(
          "Only JPEG, PNG, and WebP formats are accepted."
        );
        isValid = false;
      }
    } else {
      $("#thumbnail_error").html("");
    }
  }
}

$("#thumbnail").on("change", function () {
  validateThumbnail();
});

function handleFileUploadErrors(fileInput) {
  const file = fileInput[0].files[0];
  const optionsContainer = fileInput.closest(".options-container");

  if (file) {
    const allowedTypes = ["video/mp4", "video/avi", "video/mov"];
    if (!allowedTypes.includes(file.type)) {
      optionsContainer
        .find(".fileupload-error")
        .html("Invalid file type. Only MP4, AVI, and MOV are allowed.");
    } else {
      optionsContainer.find(".fileupload-error").html("");
    }
  } else {
    optionsContainer.find(".fileupload-error").html("File upload is required.");
  }
}

$(document).on("change", ".fileupload-option input[type='file']", function () {
  handleFileUploadErrors($(this));
});

function validatePdfInput(pdfInput, optionsContainer, isValid) {
  var file = pdfInput[0].files[0]; // Get the file object
  var fileType = file ? file.type : ""; // Get the MIME type of the file
  var maxSize = 5 * 1024 * 1024; // Maximum file size (5MB)
  var existingPdf = optionsContainer.find(".currentpdfLink").length > 0;

  if (!pdfInput.val() && !existingPdf) {
    optionsContainer.find(".pdfError").html("PDF file upload is required");
    isValid = false;
  } else if (fileType !== "application/pdf") {
    pdfInput.val(""); // Clear input field if the file is not a PDF
    optionsContainer.find(".pdfError").html("Only PDF files are allowed");
    isValid = false;
  } else if (file.size > maxSize) {
    pdfInput.val(""); // Clear the input if the file size exceeds 5MB
    optionsContainer.find(".pdfError").html("File size must be less than 5MB");
    isValid = false;
  } else {
    optionsContainer.find(".pdfError").html(""); // Clear error if PDF is valid
  }

  return isValid; // Return the validation result
}
$(document).on("change", ".pdf-option input[type='file']", function () {
  var pdfInput = $(this);
  var optionsContainer = pdfInput.closest(".options-container");
  validatePdfInput(pdfInput, optionsContainer, true);
});

let eeditor;
if (document.querySelector("#learningDesc")) {
  ClassicEditor.create(document.querySelector("#learningDesc"), {})
    .then((newEditor) => {
      eeditor = newEditor;

      newEditor.model.document.on("change:data", () => {
        const editorContent = newEditor.getData();
        if (editorContent.trim() !== "") {
          $("#learningDesc_error").text("");
        }
      });
    })
    .catch((error) => {
      console.error(error);
    });
}

if (document.querySelector(".create_editor")) {
  ClassicEditor.create(document.querySelector("#editor_1"))
    .then((editor) => {
      editorInstances["editor_1"] = editor; // Store instance with the correct key
      console.log(
        "Initialized editor instance for editor_1:",
        editorInstances["editor_1"]
      );
    })
    .catch((error) => {
      console.error("There was a problem initializing the editor.", error);
    });
}

//final submission start
$("#submitBtn").click(function (event) {
  if (!validateForm()) {
    event.preventDefault();
    return; // Exit the function to avoid making the AJAX call
  }
  event.preventDefault();

  $("#loader").show();

  var formData = new FormData();

  formData.append("courseName", $("#courseName").val());
  formData.append("courseDescription", $("#courseDescription").val());
  formData.append("createdBy", $("#createdBy").val());
  if (eeditor) {
    // Update the textarea with CKEditor data
    formData.append("learningDesc", eeditor.getData());
  }
  var thumbnailInput = document.getElementById("thumbnail");

  var uploadPromises = [];

  // Check if a file has been selected
  if (thumbnailInput.files.length > 0) {
    // Append the file to FormData
    formData.append("thumbnail", thumbnailInput.files[0]);
  }

  $(".subtask").each(function (subtaskIndex) {
    // Collect chaptername
    var chapterName = $(this).find(".chaptername").val();
    // // console.log(qnaAnswer);
    if (chapterName) {
      formData.append(`subtasks[${subtaskIndex}][name]`, chapterName);
    }

    $(this)
      .find(".subtask-question")
      .each(function (questionIndex) {
        $(this)
          .find(
            'input[type="text"], input[type="number"], input[type="radio"]:checked, textarea, select'
          )
          .each(function () {
            var key = $(this).data("name");
            formData.append(
              `subtasks[${subtaskIndex}][topics][${questionIndex}][${key}]`,
              $(this).val() ?? ""
            );
          });

        // Handle file inputs
        $(this)
          .find('input[type="text"], input[type="file"], select, textarea')
          .each(function () {
            var key = $(this).data("name");
            var contentType = $(this).data("content-type");

            if ($(this).attr("type") === "file") {
              // For file inputs
              var file = $(this)[0].files[0];
              if (file) {
                // formData.append(
                //   `subtasks[${subtaskIndex}][topics][${questionIndex}][${key}]`,
                //   file
                // );
                if (contentType === "file") {
                  const currentSubtaskIndex = subtaskIndex;
                  const currentQuestionIndex = questionIndex;
                  const currentKey = key;
                  console.log(currentQuestionIndex);

                  if (file) {
                    uploadPromises.push(
                      uploadFileInChunks(file, key).then((response) => ({
                        ...response,
                        subtaskIndex: currentSubtaskIndex,
                        questionIndex: currentQuestionIndex,
                        key: currentKey,
                      }))
                    );
                  }
                } else if (contentType === "pdf") {
                  formData.append(
                    `subtasks[${subtaskIndex}][topics][${questionIndex}][${key}]`,
                    file
                  );
                }
              }
            } else {
              // For text inputs
              if (contentType === "text") {
                // console.log($(this));
                let editorId = $(this).attr("id");
                let editorInstance = editorInstances[editorId];

                if (editorInstance) {
                  // Get the content from the CKEditor instance
                  let editorContent = editorInstance.getData(); // Use getData to retrieve the content
                  console.log("Editor content:", editorContent);

                  // Here, you can append the content to FormData or handle it as needed
                  formData.append(
                    `subtasks[${subtaskIndex}][topics][${questionIndex}][${key}]`,
                    editorContent ?? ""
                  );
                } else {
                  console.error("Editor instance not found for ID:", editorId);
                }
              }
              if ($(this).is(":visible")) {
                // console.log($(this));
                if (contentType === "youtube") {
                  console.log("Appending YouTube value:", $(this).val());
                  formData.append(
                    `subtasks[${subtaskIndex}][topics][${questionIndex}][${key}]`,
                    $(this).val() ?? ""
                  );
                }
              }
            }
          });
      });
    $(this)
      .find(".subtask-qna")
      .each(function (questionIndex) {
        $(this)
          .find('input[type="text"]')
          .each(function () {
            var key = $(this).data("name");
            var keys = $(this).val();
            console.log(key);
            formData.append(
              `subtasks[${subtaskIndex}][quiz][${questionIndex}][${key}]`,
              $(this).val() ?? ""
            );
          });
        // Now handle options and append them as an array
        var optionsContainer = $(this).find(".qna-options-container .options");
        var options = optionsContainer.find(".option");

        options.each(function (optionIndex) {
          var optionValue = $(this).find('input[type="text"]').val();

          // Append each option as part of an array
          formData.append(
            `subtasks[${subtaskIndex}][quiz][${questionIndex}][options][${optionIndex}]`,
            optionValue ?? ""
          );

          var isChecked = $(this)
            .find('input[type="checkbox"].correctAnswer')
            .is(":checked");

          if (isChecked) {
            formData.append(
              `subtasks[${subtaskIndex}][quiz][${questionIndex}][answer][]`,
              optionValue
            );
          }
        });
      });

    var passmarks = $(this).find(".passmarks").val();
    if (passmarks) {
      formData.append(
        `subtasks[${subtaskIndex}][qualificationMarks]`,
        passmarks
      );
    }
  });

  var csrfToken = $('meta[name="csrf-token"]').attr("content");

  var courseId = window.location.pathname.split("/").pop();
  // console.log(courseId);
  var submitButton = $("#submitBtn");

  Promise.all(uploadPromises).then((responses) => {
    // Iterate over responses to append content and duration to formData
    responses.forEach((response) => {
      if (response && response.content && response.duration) {
        // Retrieve the correct subtask and question index from the response
        const { subtaskIndex, questionIndex, key, content, duration } =
          response;

        if (subtaskIndex !== undefined && questionIndex !== undefined && key) {
          // Set content and duration correctly for the specific subtask and topic
          formData.append(
            `subtasks[${subtaskIndex}][topics][${questionIndex}][${key}]`,
            content
          );
          formData.append(
            `subtasks[${subtaskIndex}][topics][${questionIndex}][duration]`,
            duration
          );

          console.log(
            `Appended content and duration for subtask ${subtaskIndex} and topic ${questionIndex}`
          );
        } else {
          console.error(
            `Invalid indices or key: subtaskIndex: ${subtaskIndex}, questionIndex: ${questionIndex}, key: ${key}`
          );
        }
      } else {
        console.error(
          `Content or duration not found in the response for subtaskIndex: ${response.subtaskIndex}, questionIndex: ${response.questionIndex}`
        );
      }
    });

    // After all uploads are complete, make the AJAX call to update the chapter
    return $.ajax({
      url: "/submit_course/" + (courseId ? courseId : ""),
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      headers: {
        "X-CSRF-TOKEN": csrfToken,
      },
      success: function (response) {
        // console.log(response);
        if (response.success === true && response.course_id) {
          var courseId = response.course_id;
          submitButton.prop("disabled", true);
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: "success",
            showCancelButton: true,
            confirmButtonText: "Completed",
            cancelButtonText: "Next Chapter",
            reverseButtons: true,
          }).then((result) => {
            var currentUrl = window.location.href;

            if (result.isConfirmed) {
              window.location.href = "/course-listing"; // Redirect to course creation page
            } else if (result.dismiss === Swal.DismissReason.cancel) {
              if (currentUrl.includes("create_course")) {
                window.location.href = "/create_course/" + courseId;
              } else if (currentUrl.includes("edit_course")) {
                window.location.href = "/edit_course/" + courseId;
              }
            }
          });
        } else {
          Swal.fire({
            title: "Try Again!",
            text: "There was a problem creating the course.",
            icon: "error",
            confirmButtonText: "OK",
          });
        }
      },
      complete: function () {
        $("#loader").hide();
      },
      // success: function (response) {
      //   if (response.success === true) {
      //     Swal.fire({
      //       title: "Success!",
      //       text: "Course created successfully.",
      //       icon: "success",
      //       confirmButtonText: "OK",
      //     }).then((result) => {
      //       if (result.isConfirmed) {
      //         window.location.href = "/create_course";
      //       }
      //     });
      //   } else {
      //     Swal.fire({
      //       title: "Try Again!",
      //       text: "There was a problem creating the course.",
      //       icon: "error",
      //       confirmButtonText: "OK",
      //     });
      //   }
      // },
    });
  });
});

//final submission end
var currentPath = window.location.pathname;
var coursePagePattern = /^\/create_course\/[a-f0-9]{24}$/;
if (coursePagePattern.test(currentPath)) {
  $(".add-subtask").prop("hidden", false); // Enable the button
  $(".notifyMsg").prop("hidden", true); // Enable the button
}

if (window.location.pathname.includes("/create_course/")) {
  $(".existingChapter").hide();
  if ($(".cf_tsk_part.subtask").length > 0) {
    $(".cf_tsk_part.subtask").each(function () {
      var completionStatus = $(this).find(".completed-status");
      var edit = $(this).find(".edit-icon");
      completionStatus.show(); // Show "completed" status for existing chapters
      edit.show();
    });
  }
  addSubtask();
}

if (window.location.pathname.includes("/edit_course/")) {
  $(".existingChapter").hide();
  if ($(".cf_tsk_part.subtask").length > 0) {
    $(".cf_tsk_part.subtask").each(function () {
      var completionStatus = $(this).find(".completed-status");
      var edit = $(this).find(".edit-icon");
      completionStatus.show(); // Show "completed" status for existing chapters
      edit.show(); // Show "completed" status for existing chapters
    });
  }
  $(".add-subtask").prop("hidden", false); // Enable the button
  $(".notifyMsg").prop("hidden", true);
}

// Define the addSubtask function
function addSubtask() {
  var subtaskContainer = $("#subtask-container");

  var lastSubtask = subtaskContainer.children(".subtask").last();
  var lastSubtaskNumber =
    Number(lastSubtask.find(".subtask-number").html()) || 0;

  var newSubtaskNumber = lastSubtaskNumber + 1;

  var newSubtaskTemplate = $($("#subtask-template").html());
  newSubtaskTemplate.find(".subtask-number").html(newSubtaskNumber);

  newSubtaskTemplate.find(".completed-status").hide();
  newSubtaskTemplate.find(".completed-status").hide();

  var removeSubtaskButton = $(
    '<button type="button" class="remove-form remove-subtask ex-rmv-btn">-</button>'
  );

  // Append the new subtask and the remove button
  subtaskContainer.append(newSubtaskTemplate, removeSubtaskButton);

  // Hide the "add-subtask" button and show the notify message
  $(".add-subtask").prop("hidden", true);
  $(".notifyMsg").prop("hidden", false);
  newSubtaskTemplate.find("textarea").each(function () {
    // Create a unique ID for the new CKEditor instance
    var newEditorId = "editor_" - newSubtaskNumber;
    $(this).attr("id", newEditorId);

    // Ensure that CKEditor is initialized for the new textarea
    ClassicEditor.create(document.querySelector("#" + newEditorId))
      .then((editor) => {
        // Store the CKEditor instance in the editorInstances object
        editorInstances[newEditorId] = editor;
        console.log("CKEditor initialized for:", newEditorId);
      })
      .catch((error) => {
        console.error("Error initializing CKEditor:", error);
      });
  });
}

function validateUpdateChapter() {
  let isValid = true;

  // Resetting previous error messages
  $(".chaptername_error").text("");
  $(".passmarks_error").text("");
  $(".qna-question-text-error").text("");
  $(".qnaoptn_error").text("");
  $(".qna-points-text-error").text("");

  let totalQnaPoints = 0;

  // Validate Chapter Name
  let chaptername = $("#chaptername").val();
  if (!chaptername) {
    $(".chaptername_error").text("Chapter name is required");
    isValid = false;
  }

  // Real-time validation for Chapter Name
  $(document).on("input", "#chaptername", function () {
    if ($(this).val() === "") {
      $(".chaptername_error").text("Chapter name is required");
    } else {
      $(".chaptername_error").text("");
    }
  });

  let passmarks = $("#passmarks").val();
  if (!passmarks) {
    $(".passmarks_error").text("Please enter qualification marks");
    isValid = false;
  }

  // Real-time validation for Chapter Name
  $(document).on("input", "#passmarks", function () {
    if ($(this).val() === "") {
      $(".passmarks_error").text("Please enter qualification marks");
    } else {
      $(".passmarks_error").text("");
    }
  });

  // Validate Topic Names
  $(".subtask-question-text").each(function () {
    if ($(this).val() != "") {
      $(this).next(".subtask-question-text-error").html("");
    } else {
      $(this)
        .next(".subtask-question-text-error")
        .html("Please enter topic name");
      isValid = false;
    }
  });

  // Real-time validation for Topic Names
  $(document).on("input", ".subtask-question-text", function () {
    if ($(this).val() === "") {
      $(this)
        .next(".subtask-question-text-error")
        .html("Please enter topic name");
    } else {
      $(this).next(".subtask-question-text-error").html("");
    }
  });

  // Validate Topic Options
  $(".subtask-question-select").each(function () {
    if ($(this).val() != "") {
      $(this).next(".subtask-question-select-error").html("");
    } else {
      $(this).next(".subtask-question-select-error").html("Choose an option");
      isValid = false;
    }
  });

  // Real-time validation for Topic Options
  $(document).on("input", ".subtask-question-select", function () {
    if ($(this).val() === "") {
      $(this).next(".subtask-question-select-error").html("Choose an option");
    } else {
      $(this).next(".subtask-question-select-error").html("");
    }
  });

  $(".form-section").each(function () {
    var type = $(this).find('select[name*="[type]"]').val();
    var optionsContainer = $(this).find(".options-container");

    if (type === "file") {
      var fileInput = optionsContainer.find(
        ".fileupload-option input[type='file']"
      );
      var existingVideo =
        optionsContainer.find(".video-container video").length > 0;

      if (!fileInput.val() && !existingVideo) {
        optionsContainer
          .find(".fileupload-error")
          .html("File upload is required");
        isValid = false;
      } else {
        if (fileInput[0].files.length > 0) {
          var file = fileInput[0].files[0];
          var validFileTypes = ["video/mp4", "video/avi", "video/mov"];

          // Check if the file type is valid
          if (!validFileTypes.includes(file.type)) {
            optionsContainer
              .find(".fileupload-error")
              .html("Invalid file type. Only MP4, AVI, and MOV are allowed.");
            isValid = false;
          } else {
            optionsContainer.find(".fileupload-error").html("");
          }
        }
      }
    } else if (type === "pdf") {
      var pdfInput = optionsContainer.find(".pdf-option input[type='file']");
      var existingPdf = optionsContainer.find(".currentpdfLink").length > 0;

      if (!pdfInput.val() && !existingPdf) {
        // console.log("File upload is required");
        optionsContainer.find(".pdfError").html("PDF file upload is required");
        isValid = false;
      } else {
        optionsContainer.find(".pdfError").html(""); // Remove error if PDF is selected
      }

      pdfInput.on("change", function () {
        var file = pdfInput[0].files[0]; // Get the file object
        var fileType = file ? file.type : ""; // Get the MIME type of the file
        var maxSize = 5 * 1024 * 1024; // Maximum file size (5MB)

        // Check if the selected file is a PDF
        if (fileType !== "application/pdf") {
          pdfInput.val("");
          optionsContainer.find(".pdfError").html("Only PDF files are allowed"); // Show error
          isValid = false;
        } else if (file.size > maxSize) {
          pdfInput.val(""); // Clear the input if the file size exceeds 5MB
          optionsContainer
            .find(".pdfError")
            .html("File size must be less than 5MB"); // Show error
          isValid = false;
        } else {
          optionsContainer.find(".pdfError").html(""); // Clear error if PDF is selected
        }
      });
    } else if (type === "text") {
      var ckeditorField = optionsContainer.find(".ckeditor"); // Get the CKEditor field within the optionsContainer

      ckeditorField.each(function () {
        var editorId = $(this).attr("id"); // Get the ID of the CKEditor instance
        var editorInstance = editorInstances[editorId]; // Retrieve the CKEditor instance from editorInstances object

        if (editorInstance) {
          var editorContent = editorInstance.getData(); // Get CKEditor content
          if (!editorContent.trim()) {
            optionsContainer.find(".text-error").html("This field is required");
            isValid = false;
          } else {
            optionsContainer.find(".text-error").html(""); // Remove error if CKEditor has content
          }
        } else {
          console.error("CKEditor instance not found for ID:", editorId);
        }
      });
    } else if (type === "youtube") {
      var youtubeInput = optionsContainer.find(
        ".youtube-option input[type='text']"
      );
      var youtubeRegex =
        /^(https?:\/\/)?(www\.)?(youtube\.com\/(watch\?v=|shorts\/)|youtu\.be\/).+$/;

      if (!youtubeInput.val()) {
        optionsContainer.find(".youtube-error").html("This field is required");
        isValid = false;
      } else if (!youtubeRegex.test(youtubeInput.val())) {
        optionsContainer
          .find(".youtube-error")
          .html("Please enter a valid YouTube link");
        isValid = false;
      } else {
        optionsContainer.find(".youtube-error").html(""); // Remove error if valid YouTube link is entered
      }

      // Real-time validation for YouTube input
      youtubeInput.on("input", function () {
        if (!youtubeRegex.test(youtubeInput.val())) {
          optionsContainer
            .find(".youtube-error")
            .html("Please enter a valid YouTube link");
          isValid = false;
        } else {
          optionsContainer.find(".youtube-error").html(""); // Clear error once valid YouTube link is entered
        }
      });
    }
  });

  // Real-time validation for file upload and text option
  $(document).on(
    "input",
    ".fileupload-option input[type='file'], .text-option input[type='text']",
    function () {
      var optionsContainer = $(this).closest(".options-container");

      if (
        $(this).val() === "" &&
        !optionsContainer.find(".fileupload-option a").length
      ) {
        optionsContainer
          .find(".fileupload-error")
          .html("File upload is required");
      } else {
        optionsContainer.find(".fileupload-error").html("");
      }

      if ($(this).val() === "") {
        optionsContainer.find(".text-error").html("This field is required");
      } else {
        optionsContainer.find(".text-error").html("");
      }
    }
  );

  // Validate QnA
  $(".subtask-qna").each(function (qnaIndex) {
    let questionInput = $(this).find(".qna-question-text");
    let pointsInput = $(this).find(".qna-points-text:visible");

    // Check if question is filled
    if (questionInput.val() === "") {
      $(this).find(".qna-question-text-error").text("Question is required");
      isValid = false;
    }

    // Check if points are filled
    if (pointsInput.val() === "") {
      $(this).find(".qna-points-text-error").text("Points are required");
      isValid = false;
    }

    if (pointsInput.val() === "") {
      $(this).find(".qna-points-text-error").text("Points are required");
      isValid = false;
    } else {
      // Add points to the total
      totalQnaPoints += parseFloat(pointsInput.val()) || 0;
    }

    // Validate options and correct answers
    let options = $(this).find(".qna-options-container .option");
    let isOptionValid = false;
    let isCorrectAnswerChecked = false;

    options.each(function () {
      let optionValue = $(this).find('input[type="text"]').val();
      let isChecked = $(this)
        .find('input[type="checkbox"].correctAnswer')
        .is(":checked");

      // Check if at least one option is filled
      if (optionValue !== "") {
        isOptionValid = true;
      }

      // Check if at least one correct answer is selected
      if (isChecked) {
        isCorrectAnswerChecked = true;
      }
    });

    if (!isOptionValid) {
      $(this).find(".qnaoptn_error").text("At least one option is required");
      isValid = false;
    }

    if (!isCorrectAnswerChecked) {
      $(this).find(".qnaoptn_error").text("Select at least one correct answer");
      isValid = false;
    }
  });

  // Real-time validation for QnA
  $(document).on("input", ".qna-question-text, .qna-points-text", function () {
    if ($(this).val() === "") {
      $(this)
        .next(".qna-question-text-error, .qna-points-text-error")
        .text("This field is required");
    } else {
      $(this).next(".qna-question-text-error, .qna-points-text-error").text("");
    }
  });

  $(".qna-options-container").each(function () {
    let optionInputs = $(this).find('input[type="text"]');

    // Ensure each option input is filled before adding another
    let allOptionsFilled = true;
    optionInputs.each(function () {
      if ($(this).val() === "") {
        allOptionsFilled = false;
      }
    });

    if (!allOptionsFilled) {
      $(this)
        .closest(".subtask-qna")
        .find(".qnaoptn_error")
        .text("Please fill the empty option field.");
      isValid = false;
    }
  });

  // Validate Passmarks and compare with totalQnaPoints
  $(".passmarks").each(function () {
    let passmarks = parseFloat($(this).val()) || 0;
    if (passmarks !== 0) {
      if (passmarks > totalQnaPoints) {
        $(this)
          .next(".passmarks_error")
          .html(
            `Passmarks (${passmarks}) cannot be greater than total points (${totalQnaPoints})`
          );
        isValid = false;
      } else {
        $(this).next(".passmarks_error").html("");
      }
    } else {
      $(this).next(".passmarks_error").html("Please enter qualification marks");
      isValid = false;
    }
  });

  // Scroll to the first visible error message
  if (!isValid) {
    const firstError = $(".error:visible")
      .filter(function () {
        return $(this).text().trim() !== "";
      })
      .first();

    if (firstError.length) {
      const errorOffset = firstError.offset().top;
      const windowHeight = $(window).height();
      const scrollTo =
        errorOffset - windowHeight / 2 + firstError.outerHeight() / 2;

      $("html, body").animate(
        {
          scrollTop: scrollTo,
        },
        30
      );
    }
  }

  return isValid;
}
//hi
function uploadFileInChunks(file, key) {
  return new Promise((resolve, reject) => {
    const chunkSize = 10 * 1024 * 1024; // 10MB
    const totalChunks = Math.ceil(file.size / chunkSize);

    function uploadChunk(start) {
      const end = Math.min(start + chunkSize, file.size);
      const chunk = file.slice(start, end);
      const chunkNumber = Math.ceil(end / chunkSize);

      const formData = new FormData();
      formData.append("chunk", chunk);
      formData.append("chunkNumber", chunkNumber);
      formData.append("totalChunks", totalChunks);
      formData.append("fileName", file.name);
      formData.append(key, file.name); // Append the key for reference

      $.ajax({
        url: "/upload-chunk", // Your route for chunk upload
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
          if (response.success) {
            if (end < file.size) {
              uploadChunk(end); // Upload the next chunk
            } else {
              console.log("Final response from server:", response); // Debugging line
              resolve(response); // Resolve with the full response
            }
          } else {
            reject("There was a problem uploading the file.");
          }
        },
        error: function () {
          reject("An unexpected error occurred.");
        },
      });
    }

    // Start uploading with the first chunk
    uploadChunk(0);
  });
}

// Bind an event to the submit button
$("#updateBtn").click(function (event) {
  if (!validateUpdateChapter()) {
    event.preventDefault();
    return; // Exit the function to avoid making the AJAX call
  }
  event.preventDefault();
  $("#loader").show();
  var formData = new FormData();

  // Get course ID and chapter index
  var courseId = $("#courseId").val(); // Assuming this value is stored in a hidden input
  var chapterIndex = $("#chapterIndex").val(); // Assuming this value is stored in a hidden input

  formData.append("chaptername", $("#chaptername").val());
  formData.append("courseId", courseId);
  formData.append("chapterIndex", chapterIndex);

  formData.append("passmarks", $("#passmarks").val());

  var uploadPromises = [];

  $(".subtask").each(function (subtaskIndex) {
    $(this)
      .find(".subtask-question")
      .each(function (questionIndex) {
        // Collect input values for each question in the subtask
        $(this)
          .find(
            'input[type="text"], input[type="number"], input[type="radio"]:checked, textarea, select'
          )
          .each(function () {
            var key = $(this).data("name");
            formData.append(
              `subtasks[${subtaskIndex}][topics][${questionIndex}][${key}]`,
              $(this).val() ?? ""
            );
          });

        // Handle file inputs
        $(this)
          .find('input[type="text"],input[type="file"],textarea')
          .each(function () {
            var key = $(this).data("name");
            var contentType = $(this).data("content-type");

            if ($(this).attr("type") === "file") {
              var file = $(this)[0].files[0];
              if (file) {
                if (contentType === "file") {
                  const currentSubtaskIndex = subtaskIndex;
                  const currentQuestionIndex = questionIndex;
                  const currentKey = key;
                  console.log(currentQuestionIndex);

                  if (file) {
                    uploadPromises.push(
                      uploadFileInChunks(file, key).then((response) => ({
                        ...response,
                        subtaskIndex: currentSubtaskIndex,
                        questionIndex: currentQuestionIndex,
                        key: currentKey,
                      }))
                    );
                  }
                } else if (contentType === "pdf") {
                  formData.append(
                    `subtasks[${subtaskIndex}][topics][${questionIndex}][${key}]`,
                    file
                  );
                }
              }
            } else {
              // For text inputs
              if (contentType === "text") {
                // console.log("Appending text value:", $(this).val());
                // formData.append(
                //   `subtasks[${subtaskIndex}][topics][${questionIndex}][${key}]`,
                //   $(this).val() ?? ""
                // );

                let editorId = $(this).attr("id");
                let editorInstance = editorInstances[editorId];

                if (editorInstance) {
                  // Get the content from the CKEditor instance
                  let editorContent = editorInstance.getData(); // Use getData to retrieve the content
                  console.log("Editor content:", editorContent);

                  // Here, you can append the content to FormData or handle it as needed
                  formData.append(
                    `subtasks[${subtaskIndex}][topics][${questionIndex}][${key}]`,
                    editorContent ?? ""
                  );
                } else {
                  console.error("Editor instance not found for ID:", editorId);
                }
              }
              if ($(this).is(":visible")) {
                if (contentType === "youtube") {
                  console.log("Appending YouTube value:", $(this).val());
                  formData.append(
                    `subtasks[${subtaskIndex}][topics][${questionIndex}][${key}]`,
                    $(this).val() ?? ""
                  );
                }
              }
            }
          });
      });
    $(this)
      .find(".subtask-qna")
      .each(function (questionIndex) {
        $(this)
          .find('input[type="text"]')
          .each(function () {
            var key = $(this).data("name");
            formData.append(
              `subtasks[${subtaskIndex}][quiz][${questionIndex}][${key}]`,
              $(this).val() ?? ""
            );
          });

        // Now handle options and append them as an array
        var optionsContainer = $(this).find(".qna-options-container .options");
        var options = optionsContainer.find(".option");

        options.each(function (optionIndex) {
          var optionValue = $(this).find('input[type="text"]').val();

          // Append each option as part of an array
          formData.append(
            `subtasks[${subtaskIndex}][quiz][${questionIndex}][options][${optionIndex}]`,
            optionValue ?? ""
          );

          var isChecked = $(this)
            .find('input[type="checkbox"].correctAnswer')
            .is(":checked");

          if (isChecked) {
            formData.append(
              `subtasks[${subtaskIndex}][quiz][${questionIndex}][answer][]`,
              optionValue
            );
          }
        });
      });
  });

  var csrfToken = $('meta[name="csrf-token"]').attr("content");
  var updateButton = $("#updateBtn");

  Promise.all(uploadPromises)
    .then((responses) => {
      // Iterate over responses to append content and duration to formData
      responses.forEach((response) => {
        if (response && response.content && response.duration) {
          // Retrieve the correct subtask and question index from the response
          const { subtaskIndex, questionIndex, key, content, duration } =
            response;

          if (
            subtaskIndex !== undefined &&
            questionIndex !== undefined &&
            key
          ) {
            // Set content and duration correctly for the specific subtask and topic
            formData.append(
              `subtasks[${subtaskIndex}][topics][${questionIndex}][${key}]`,
              content
            );
            formData.append(
              `subtasks[${subtaskIndex}][topics][${questionIndex}][duration]`,
              duration
            );

            console.log(
              `Appended content and duration for subtask ${subtaskIndex} and topic ${questionIndex}`
            );
          } else {
            console.error(
              `Invalid indices or key: subtaskIndex: ${subtaskIndex}, questionIndex: ${questionIndex}, key: ${key}`
            );
          }
        } else {
          console.error(
            `Content or duration not found in the response for subtaskIndex: ${response.subtaskIndex}, questionIndex: ${response.questionIndex}`
          );
        }
      });

      // After all uploads are complete, make the AJAX call to update the chapter
      return $.ajax({
        url: "/update-chapter/" + courseId + "/" + chapterIndex,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: {
          "X-CSRF-TOKEN": csrfToken,
        },
        success: function (response) {
          if (response.success === true) {
            updateButton.prop("disabled", true);
            Swal.fire({
              title: "Success!",
              text: "Chapter updated successfully.",
              icon: "success",
              confirmButtonText: "OK",
            }).then(() => {
              window.location.reload();
            });
          } else {
            Swal.fire({
              title: "Try Again!",
              text: "There was a problem updating the chapter.",
              icon: "error",
              confirmButtonText: "OK",
            });
          }
        },
        error: function () {
          Swal.fire({
            title: "Error!",
            text: "An unexpected error occurred.",
            icon: "error",
            confirmButtonText: "OK",
          });
        },
        complete: function () {
          $("#loader").hide();
        },
      });
    })
    .catch((error) => {
      Swal.fire({
        title: "Error!",
        text: error,
        icon: "error",
        confirmButtonText: "OK",
      });
      $("#loader").hide();
    });
});

//update chapter end

//Delete Topic start

function deleteTopic(courseId, chapterIndex, topicIndex) {
  if (topicIndex === 0) {
    Swal.fire({
      title: "Error!",
      text: "You cannot delete the first topic,You can edit this topic",
      icon: "error",
      confirmButtonText: "OK",
    });
    return; // Exit the function if trying to delete the first topic
  }
  // Trigger SweetAlert confirmation
  const topics = $(`.chapter-${chapterIndex} .topic`);
  // console.log("Selected Topics:", topics);
  // console.log("Total Topics Count:", topics.length);
  Swal.fire({
    title: "Are you sure?",
    text: "Do you want to delete this topic?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      // Send AJAX request to delete the topic
      $.ajax({
        url: "/delete-topic", // The route to delete the topic
        type: "GET",
        data: {
          courseId: courseId,
          chapterIndex: chapterIndex,
          topicIndex: topicIndex,
          // _token: '{{ csrf_token() }}' // Include CSRF token for security
        },
        success: function (response) {
          if (response.success) {
            Swal.fire(
              "Deleted!",
              "The topic has been deleted.",
              "success"
            ).then(() => {
              // Reload or update the page to reflect changes
              // location.reload();
              $(
                '.form-section.subtask-question[data-topic-index="' +
                  topicIndex +
                  '"]'
              ).remove();
            });
          } else {
            Swal.fire(
              "Error!",
              "There was a problem deleting the topic.",
              "error"
            );
          }
        },
        error: function () {
          Swal.fire(
            "Error!",
            "There was a problem deleting the topic.",
            "error"
          );
        },
      });
    }
  });
}

//delete topic end

//Delete Qna start

function deleteQna(courseId, chapterIndex, quizIndex) {
  if (quizIndex === 0) {
    Swal.fire({
      title: "Error!",
      text: "You cannot delete the first QnA Section,You can edit this Section",
      icon: "error",
      confirmButtonText: "OK",
    });
    return;
  }

  Swal.fire({
    title: "Are you sure?",
    text: "Do you want to delete this QnA?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      // Send AJAX request to delete the topic
      $.ajax({
        url: "/delete-qna", // The route to delete the topic
        type: "GET",
        data: {
          courseId: courseId,
          chapterIndex: chapterIndex,
          quizIndex: quizIndex,
          // _token: '{{ csrf_token() }}' // Include CSRF token for security
        },
        success: function (response) {
          if (response.success) {
            Swal.fire("Deleted!", "The QnA has been deleted.", "success").then(
              () => {
                // Reload or update the page to reflect changes
                // location.reload();
                $(
                  '.form-section.subtask-qna[data-quiz-index="' +
                    quizIndex +
                    '"]'
                ).remove();
              }
            );
          } else {
            Swal.fire(
              "Error!",
              "There was a problem deleting the QnA.",
              "error"
            );
          }
        },
        error: function () {
          Swal.fire("Error!", "There was a problem deleting the QnA.", "error");
        },
      });
    }
  });
}

function deleteQnaOptn(courseId, chapterIndex, quizIndex, optionsIndex) {
  // alert(optionsIndex);
  if (optionsIndex === 0) {
    Swal.fire({
      title: "Error!",
      text: "You cannot delete the first Option,You can edit this Option",
      icon: "error",
      confirmButtonText: "OK",
    });
    return;
  }

  // Optionally confirm the deletion
  Swal.fire({
    title: "Are you sure?",
    text: "Do you want to delete this QnA Option?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      // Send AJAX request to delete the topic
      $.ajax({
        url: "/delete-qna-option", // The route to delete the topic
        type: "GET",
        data: {
          courseId: courseId,
          chapterIndex: chapterIndex,
          quizIndex: quizIndex,
          optionsIndex: optionsIndex,
        },
        success: function (response) {
          if (response.success) {
            Swal.fire(
              "Deleted!",
              "The QnA Option has been deleted.",
              "success"
            ).then(() => {
              // Reload or update the page to reflect changes
              // location.reload();
              $('.subtask-qna[data-quiz-index="' + quizIndex + '"]')
                .find('.option[data-option-index="' + optionsIndex + '"]')
                .remove();
            });
          } else {
            Swal.fire(
              "Error!",
              "There was a problem deleting the QnA Option.",
              "error"
            );
          }
        },
        error: function () {
          Swal.fire(
            "Error!",
            "There was a problem deleting the QnA Option.",
            "error"
          );
        },
      });
    }
  });
}

//delete Qna end

//chapter back button start
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
//chapter back button end

//video editor
function toggleMenu(button) {
  const menu = button.nextElementSibling;
  menu.style.display = menu.style.display === "block" ? "none" : "block";
}

document.addEventListener("click", function (event) {
  // Hide the menu if clicked outside
  const isClickInside = event.target.closest(".three-dots-menu");
  if (!isClickInside) {
    document
      .querySelectorAll(".menu-options")
      .forEach((menu) => (menu.style.display = "none"));
  }
});

function editVideo(videoSrc, inputName) {
  // Find the video container that the button belongs to
  const videoContainer = event.target.closest(".video-container");

  // Find the input field by its name attribute within the same container
  const input = videoContainer.querySelector(
    `input[name="questions[0][lecture][]"]`
  );

  input.click(); // Trigger the file input

  // Store the current video source to use later (if needed)
  input.dataset.currentSrc = videoSrc;

  // Add an event listener to handle when a file is selected
  input.onchange = function () {
    const file = input.files[0];
    if (file) {
      const videoElement = videoContainer.querySelector("video");

      // Create a URL for the selected file
      const fileURL = URL.createObjectURL(file);

      // Update the video source and load the new video
      videoElement.src = fileURL;
      videoElement.load();

      // Optionally, you can implement the logic to upload the new video to the server here
    }
  };
}

function deleteVideo(courseId, chapterIndex, topicIndex, videoSrc) {
  // console.log(videoSrc);
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!",
    cancelButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "/deleteVideo",
        type: "GET",
        data: {
          // _token: csrfToken, // Include CSRF token
          courseId: courseId,
          chapterIndex: chapterIndex,
          topicIndex: topicIndex,
          videoSrc: videoSrc,
        },
        success: function (response) {
          if (response.success) {
            Swal.fire(
              "Deleted!",
              "The video has been deleted.",
              "success"
            ).then(() => {
              // Reload the page after the deletion is successful
              window.location.reload();
            });
            // Optionally, remove the video element from the DOM
          } else {
            Swal.fire("Error!", response.message, "error");
          }
        },
        error: function () {
          Swal.fire(
            "Error!",
            "An error occurred while deleting the video.",
            "error"
          );
        },
      });
    }
  });
}

//video editor
function showPreview(event) {
  const file = event.target.files[0];
  const videoPreview = event.target.nextElementSibling;

  if (file && file.type.startsWith("video/")) {
    // Clear any existing video element
    videoPreview.innerHTML = "";

    // Create a new video element
    const videoElement = document.createElement("video");
    videoElement.controls = true;
    videoElement.width = 300; // Set desired width
    videoElement.src = URL.createObjectURL(file);

    const crossButton = document.createElement("span");
    crossButton.textContent = "✖";
    crossButton.style.position = "absolute";
    crossButton.style.top = "5px";
    crossButton.style.right = "5px";
    crossButton.style.cursor = "pointer";
    crossButton.style.color = "red"; // Change color to make it visible
    crossButton.style.fontSize = "20px"; // Adjust size for better visibility
    crossButton.style.zIndex = "10"; // Ensure the button is on top of the video

    // Append the video element and cross button to the preview container
    videoPreview.appendChild(videoElement);
    videoPreview.appendChild(crossButton);
    event.target.style.display = "none";
    // Add event listener to the cross button to remove the file and preview
    crossButton.addEventListener("click", function () {
      // Clear the file input
      event.target.value = "";
      event.target.style.display = "block";
      // Clear the video preview
      videoPreview.innerHTML = "";
    });
  }
}

function editpdf(pdfSrc) {
  // console.log(pdfSrc);
  // Find the video container that the button belongs to
  const pdfContainer = event.target.closest(".pdf-viewer");

  // Find the input field by its name attribute within the same container
  const input = pdfContainer.querySelector(
    `input[name="questions[0][lecture][]"]`
  );

  input.click(); // Trigger the file input

  // Store the current video source to use later (if needed)
  input.dataset.currentSrc = pdfSrc;

  // Add an event listener to handle when a file is selected
  input.onchange = function () {
    const file = input.files[0];
    if (file) {
      const pdfElement = pdfContainer.querySelector("iframe");

      // Create a URL for the selected file
      const fileURL = URL.createObjectURL(file);

      // Update the video source and load the new video
      pdfElement.src = `${fileURL}#toolbar=0`;
      // pdfElement.load();

      // Optionally, you can implement the logic to upload the new video to the server here
    }
  };
}

function deletepdf(courseId, chapterIndex, topicIndex, pdfSrc) {
  // console.log(pdfSrc);
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!",
    cancelButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "/deletePdf",
        type: "GET",
        data: {
          // _token: csrfToken, // Include CSRF token
          courseId: courseId,
          chapterIndex: chapterIndex,
          topicIndex: topicIndex,
          pdfSrc: pdfSrc,
        },
        success: function (response) {
          if (response.success) {
            Swal.fire("Deleted!", "The pdf has been deleted.", "success").then(
              () => {
                // Reload the page after the deletion is successful
                window.location.reload();
              }
            );
            // Optionally, remove the video element from the DOM
          } else {
            Swal.fire("Error!", response.message, "error");
          }
        },
        error: function () {
          Swal.fire(
            "Error!",
            "An error occurred while deleting the pdf.",
            "error"
          );
        },
      });
    }
  });
}

function showPdfPreview(event) {
  const file = event.target.files[0];
  const pdfPreview = event.target.nextElementSibling;

  if (file && file.type === "application/pdf") {
    // Clear any existing PDF preview
    pdfPreview.innerHTML = "";

    // Create a new iframe element for PDF preview
    const pdfElement = document.createElement("iframe");
    pdfElement.width = 300; // Set desired width
    pdfElement.height = 200; // Set desired height
    pdfElement.src = URL.createObjectURL(file) + "#toolbar=0"; // Hide the toolbar

    const crossButton = document.createElement("span");
    crossButton.textContent = "✖";
    crossButton.style.position = "absolute";
    crossButton.style.top = "5px";
    crossButton.style.right = "5px";
    crossButton.style.cursor = "pointer";
    crossButton.style.color = "red"; // Change color to make it visible
    crossButton.style.fontSize = "20px"; // Adjust size for better visibility
    crossButton.style.zIndex = "10"; // Ensure the button is on top of the PDF

    // Append the PDF element and cross button to the preview container
    pdfPreview.appendChild(pdfElement);
    pdfPreview.appendChild(crossButton);
    event.target.style.display = "none";

    // Add event listener to the cross button to remove the file and preview
    crossButton.addEventListener("click", function () {
      // Clear the file input
      event.target.value = "";
      event.target.style.display = "block";
      // Clear the PDF preview
      pdfPreview.innerHTML = "";
    });
  }
}

$(document).on("input", ".qna-points-text, .passmarks", function () {
  // Replace any non-numeric characters with an empty string
  let value = $(this)
    .val()
    .replace(/[^0-9]/g, "");
  $(this).val(value);
});

$("#thumbnail").on("change", function () {
  const thumbnailView = $("#thumbnailView");
  thumbnailView.empty(); // Clear any existing content

  const file = this.files[0];
  if (file) {
    const reader = new FileReader();

    // Read the file and load the preview
    reader.onload = function (e) {
      // Create a container for the image and cross button
      const imgContainer = $("<div>").css({
        position: "relative",
        display: "inline-block",
      });

      // Create the image element
      const img = $("<img>").attr("src", e.target.result).css({
        "max-width": "100px", // Set thumbnail size
        "max-height": "100px",
      });

      // Create a cross button
      const crossButton = $("<span>").text("×").css({
        position: "absolute",
        top: "0",
        right: "0",
        cursor: "pointer",
        background: "#fff",
        "font-size": "20px",
        color: "red",
      });

      // Remove file and preview on click
      crossButton.on("click", function () {
        $("#thumbnail").val(""); // Clear the file input
        thumbnailView.empty(); // Remove the preview
      });

      // Append the image and cross button to the container
      imgContainer.append(img).append(crossButton);
      thumbnailView.append(imgContainer);
    };

    reader.readAsDataURL(file); // Convert the file to a base64 URL
  }
});

function deleteThumbnail(courseId) {
  // console.log(courseId);
  // Use SweetAlert to show confirmation
  Swal.fire({
    title: "Are you sure you want to delete?",
    text: "This action cannot be undone.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      // Make an AJAX call to delete the thumbnail
      $.ajax({
        url: "/deleteThumbnail", // Replace with your actual delete route
        method: "GET",
        data: {
          courseId: courseId, // Include the course ID
        },
        success: function (response) {
          if (response.success) {
            // Remove the thumbnail view if the delete is successful
            $("#currentThumbnailLink").remove();
            $(".video_tree").remove();
            Swal.fire(
              "Deleted!",
              "The thumbnail has been deleted.",
              "success"
            ).then(() => {
              // Reload the page after the deletion is successful
              window.location.reload();
            });
          } else {
            Swal.fire(
              "Error!",
              "There was an error deleting the thumbnail.",
              "error"
            );
          }
        },
        error: function () {
          Swal.fire(
            "Error!",
            "There was an error deleting the thumbnail.",
            "error"
          );
        },
      });
    }
  });
}

// Trigger the hidden file input when Edit is clicked
function editThumbnail() {
  document.getElementById("thumbnail").click();
}

// Preview the selected file inside the img tag
function previewThumbnail(event) {
  const file = event.target.files[0];
  const allowedTypes = ["image/jpeg", "image/png", "image/webp"];
  if (file) {
    if (allowedTypes.includes(file.type)) {
      const reader = new FileReader();
      reader.onload = function (e) {
        document.getElementById("currentThumbnailLink").src = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  }
}

// Toggle the three-dots menu visibility
function toggleMenu(button) {
  const menu = button.nextElementSibling;
  menu.style.display = menu.style.display === "none" ? "block" : "none";
}
