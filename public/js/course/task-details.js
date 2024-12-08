$(document).on("click", ".dropdown_option", function () {
  const optionId = $(this).attr("id");
});

$(document).on("click", ".check_radio_option", function () {
  console.log("Hello");
  
  const inputType = $(this).attr("type");
  const optionId = $(this).attr("id");
  var [subtask, subtaskQuestion, subtaskQuestionOption] = optionId.split(".");

  if (inputType == "radio") {
    $(
      `div[data-subtask="${subtask}"][data-subtask-question="${subtaskQuestion}"]`
    ).hide();

    $(`div[data-conditional-question="${optionId}"]`).show();
  }

  if (inputType == "checkbox") {
    const isChecked = $(this).is(":checked");
    if (isChecked) {
      $(`div[data-conditional-question="${optionId}"]`).show();
    } else {
      $(`div[data-conditional-question="${optionId}"]`).hide();
    }
  }
});

$("#selectDropdown").change(function () {
  var selectedOptionId = $(this).find("option:selected").attr("id");
  var [subtask, subtaskQuestion, subtaskQuestionOption] =
    selectedOptionId.split(".");
  $(
    `div[data-subtask="${subtask}"][data-subtask-question="${subtaskQuestion}"]`
  ).hide();
  $(`div[data-conditional-question="${selectedOptionId}"]`).show();
});
