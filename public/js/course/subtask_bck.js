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
});

$(document).on("click", ".remove-subtask", function () {
  var removeSubtaskButton = $(this);
  var closestSubtask = removeSubtaskButton.prevAll(".subtask").first();

  closestSubtask.remove();
  removeSubtaskButton.remove();
});

$(document).on("click", ".add-subtask-question", function () {
  var subtaskQuestionContainer = $(this).closest(".subtask-question-container");

  var lastSubtaskQuestion = subtaskQuestionContainer
    .children(".subtask-question")
    .last();

  var lastSubtaskQuestionNumber = Number(
    lastSubtaskQuestion.find(".subtask-question-number").html()
  );

  var newSubtaskQuestionNumber = lastSubtaskQuestionNumber + 1;

  var newSubtaskQuestion = $($("#subtask-question-template").html());

  newSubtaskQuestion
    .find(".subtask-question-number")
    .html(newSubtaskQuestionNumber);

  var removeButton = $(
    '<button type="button" class="remove-form remove-subtask-question ex-rmv-btn">-</button>'
  );

  newSubtaskQuestion.append(removeButton);

  // subtaskQuestionContainer.append(newSubtaskQuestion);
  lastSubtaskQuestion.after(newSubtaskQuestion);
});

$(document).on("click", ".add-conditional-task", function () {
  var addConditionalTaskButton = $(this);
  addConditionalTaskButton.prop('disabled', true);
  // console.log(addConditionalTaskButton.val())

  var subtaskNumber = Number(
    addConditionalTaskButton.closest(".subtask").find(".subtask-number").text()
  );

  var lastSubtaskQuestion =
    addConditionalTaskButton.closest(".subtask-question");

  var subtaskQuestionNumber = Number(
    lastSubtaskQuestion.find(".subtask-question-number").html()
  );

  var optionNumber = Number(
    addConditionalTaskButton
      .prevAll(".optn_lbl")
      .first()
      .attr("placeholder")
      .split("Option ")[1]
  );
  // console.log(optionNumber)
  var newConditionalQuestion = $($("#conditional-task-template").html());
  var newConditionalQuestionNumber = `${subtaskNumber}.${subtaskQuestionNumber}.${optionNumber}`;

  newConditionalQuestion
    .find(".conditional-question-number")
    .html(newConditionalQuestionNumber);

  var removeButton = $(
    '<button type="button" class="remove-form remove-conditional-task ex-rmv-btn" value="'+subtaskNumber+'.'+ subtaskQuestionNumber +'.'+optionNumber+'">-</button>'
  );

  newConditionalQuestion.append(removeButton);

  lastSubtaskQuestion.after(newConditionalQuestion);
  // if(addConditionalTaskButton.val() == optionNumber) {
  //   addConditionalTaskButton.prop('disabled', true);
  // } else {
  //   ('.add-conditional-task').prop('disabled', false);
  // }
  
});

$(document).on("click", ".remove-conditional-task", function () {
  var removeConditionalTaskButton = $(this);
  var closestConditionalTask = removeConditionalTaskButton.closest(
    ".conditional-question"
  );

  var removeButtonValue = removeConditionalTaskButton.val();

  $(`.add-conditional-task[value="${removeButtonValue}"]`).prop('disabled', false);

  closestConditionalTask.remove();
  removeConditionalTaskButton.remove();
});

$(document).on("click", ".remove-subtask-question", function () {
  var removeSubtaskQuestionButton = $(this);
  var closestSubtaskQuestion =
    removeSubtaskQuestionButton.closest(".subtask-question");

  closestSubtaskQuestion.remove();
  removeSubtaskQuestionButton.remove();
});

$(document).on("change", '.form-section select[name*="[type]"]', function () {
  var type = $(this).val();
  var optionsContainer = $(this)
    .closest(".form-section")
    .find(".options-container");
  if (type === "fileupload" || type === "checkbox" || type === "dropdown") {
    optionsContainer.show();
    renderOptions(optionsContainer, type);
  } else {
    optionsContainer.hide();
    var options = optionsContainer.find(".option");
    var optionCount = options.length;
    if (optionCount > 1) {
      options.slice(1).remove();
    }
  }
});

$(document).on("click", ".add-option", function () {
  var optionsContainer = $(this).closest(".options-container");
  var optionCount = optionsContainer.find(".option").length + 1;
  var newOption = optionsContainer.find(".option:first").clone();


  var subtaskNumber = Number(
    $(this).closest(".subtask").find(".subtask-number").text()
  );


  var lastSubtaskQuestion =
    $(this).closest(".subtask-question");

  var subtaskQuestionNumber = Number(
    lastSubtaskQuestion.find(".subtask-question-number").html()
  );
  // console.log(subtaskQuestionNumber)

  newOption
    .find("input[type=text]")
    .val("")
    .attr("placeholder", "Option " + optionCount);

  newOption
    .find("button")
    .val(subtaskNumber+'.'+subtaskQuestionNumber+'.'+optionCount)
    .prop('disabled', false);

  newOption.appendTo(optionsContainer.find(".options"));
  updateOptionSigns(
    optionsContainer,
    optionsContainer
      .closest(".form-section")
      .find('select[name*="[type]"]')
      .val()
  );
});

// Validate task points as the user types
$("#taskpoints").on("input", function () {
  var taskpoints = $(this).val();
  // Clear the "required" error as soon as user starts typing
  if (taskpoints) {
    $("#taskpoints_error").text("");
  }
});

// Add a new form section when the "+" button is clicked
// $("#add-form").click(function () {
//   var formCount = $(".form-section").length;
//   var newFormSection = $(".form-section:first").clone();
//   newFormSection.find("input, select").each(function () {
//     var name = $(this)
//       .attr("name")
//       .replace(/\[\d+\]/, "[" + formCount + "]");
//     $(this).attr("name", name);
//     if ($(this).is(":checkbox")) {
//       $(this).prop("checked", false); // Reset checkbox state
//     } else {
//       $(this).val(""); // Reset other input values
//     }
//   });
//   newFormSection.find(".options-container").hide(); // Hide options container in new form
//   newFormSection.appendTo("#form-container");
//   addRemoveButton(newFormSection); // Add the remove button to the new form section
// });

// Add the remove button to existing form sections, except the first one
$(".form-section").each(function (index) {
  if (index > 0) {
    addRemoveButton($(this));
  }
});

// Event handler for removing a form section
// $(document).on("click", ".remove-form", function () {
//   $(this).closest(".form-section").remove();
// });

// Show/hide options container based on the selected type for each form section

// Add options dynamically when the "Add Another Option" button is clicked for each form section

// Function to render options based on the selected type for a specific form section
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
// Function to update option signs based on the type
function updateOptionSigns(optionsContainer, type) {
  optionsContainer.find(".option-sign").each(function () {
    var sign = "";
    if (type === "radio") {
      sign = '<input type="radio" name="options_radio[]">';
    } else if (type === "checkbox") {
      sign = '<input type="checkbox" name="options_checkbox[]">';
    }
    $(this).html(sign); // Set the option sign for this element
  });
}

// Prevent input if subtask point exceeds task points
$(document).on("input", 'input[name*="[subtaskpoint]"]', function () {
  var taskpoints = parseInt($("#taskpoints").val()) || 0;
  var currentSubtaskPoint = parseInt($(this).val()) || 0;
  var totalSubtaskpoints = 0;

  $(".form-section").each(function (index) {
    var subtaskpoint =
      parseInt($(this).find('input[name*="[subtaskpoint]"]').val()) || 0;
    totalSubtaskpoints += subtaskpoint;
  });

  if (totalSubtaskpoints > taskpoints) {
    $(this).val(taskpoints - (totalSubtaskpoints - currentSubtaskPoint));
  }

  //validateForms();
});

// Disable other subtask point inputs if total matches task points
$(document).on("input", 'input[name*="[subtaskpoint]"]', function () {
  var taskpoints = parseInt($("#taskpoints").val()) || 0;
  var totalSubtaskpoints = 0;

  $(".form-section").each(function (index) {
    var subtaskpoint =
      parseInt($(this).find('input[name*="[subtaskpoint]"]').val()) || 0;
    totalSubtaskpoints += subtaskpoint;
  });

  if (totalSubtaskpoints >= taskpoints) {
    $('input[name*="[subtaskpoint]"]').each(function () {
      if (!$(this).val()) {
        $(this).prop("disabled", true);
      }
    });
  } else {
    $('input[name*="[subtaskpoint]"]').prop("disabled", false);
  }

  //validateForms();
});

// Remove error messages for question and type fields when they are being filled
$(document).on(
  "input change",
  'input[name*="[question]"], select[name*="[type]"]',
  function () {
    //validateForms();
  }
);

// Add new Subtask

$("#submitBtn").click(function () {
  var taskpoints = Number($("#taskpoints").val());
  var topics = [];
  var topicName = [];
  $(".subtask").each(function () {
    var subtaskNumber = Number($(this).find(".subtask-number").text());
    
    var chaptername = Number($(this).find(".chaptername").val());
    topicName.push(chaptername);

    var subtaskQuestions = [];
    $(this)
      .find(".subtask-question")
      .each(function () {
        var inputs = {};
        $(this)
          .find(
            'input[type="text"], input[type="number"], input[type="radio"]:checked, textarea, select'
          )
          .each(function () {
            // inputs.push($(this).val());
            var key = $(this).data("name");
            inputs[key] = $(this).val() ?? "";
          });

        $(this)
          .find('input[type="checkbox"]')
          .each(function () {
            inputs[$(this).data("name")] = $(this).prop("checked");
          });

        var options = [];
        $(this)
          .find(".subtask-question-option")
          .each(function () {
            option = {
              text: $(this).val(),
              // parttask: {
              //   selecttype: "",
              //   values: [],
              //   uploadFile: false,
              // },
            };

            options.push(option);
          });

        inputs.options = options;

        subtaskQuestions.push(inputs);
      });
      
      topics.push(subtaskQuestions);

    // Conditional task insertion

    $(this)
      .find(".conditional-question")
      .each(function () {
        var conditionalTaskNumber = $(this)
          .find(".conditional-question-number")
          .text();

        var conditionalTaskNumberArray = conditionalTaskNumber.split(".");

        var subtaskNumber = Number(conditionalTaskNumberArray[0]);
        var subtaskQuestionNumber = Number(conditionalTaskNumberArray[1]);
        var subtaskQuestionOptionNumber = Number(conditionalTaskNumberArray[2]);

        var conditionalTaskTitle = $(this)
          .find(".conditional-task-question")
          .val();

        var conditionalTaskSelecttype = $(this)
          .find(".conditional-task-selecttype")
          .val();

        var conditionalTaskUploadFile = $(this)
          .find(".conditional-task-upload-file")
          .prop("checked");

        var conditionalTaskOptions = [];

        $(this)
          .find(".conditional-task-option")
          .each(function () {
            var conditionalTaskOption = $(this).val();
            conditionalTaskOptions.push(conditionalTaskOption);
          });

        var conditionalTask = {
          title: conditionalTaskTitle,
          selecttype: conditionalTaskSelecttype,
          uploadFile: conditionalTaskUploadFile,
          values: conditionalTaskOptions,
        };

        topics[subtaskNumber - 1][subtaskQuestionNumber - 1]["options"][
          subtaskQuestionOptionNumber - 1
        ]["parttask"] = conditionalTask;

        // console.log(conditionalTask);
      });
  });
  

  var task = {
    topics,
    topicName,
  };

  var taskObjectString = JSON.stringify(task);

  $("#taskObjectString").val(taskObjectString);
  // console.log(taskObjectString);
});
