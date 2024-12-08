// Function to validate the form
function validateForm() {
  let isValid = true;

  // Resetting previous error messages
  $("#taskname_error").text("");
  $("#startdate_error").text("");
  $("#duedate_error").text("");
  $("#starttime_error").text("");
  $("#duetime_error").text("");
  $("#mtdscrb_error").text("");
  $("#taskcategory_error").text("");
  $("#assignto_error").text("");
  $("#zone_error").text("");
  $("#city_error").text("");
  $("#taskarea_error").text(""); // New line for taskarea error
  $("#user_error").text(""); // New line for taskarea error

  // Checking Task Name
  let taskName = $("#taskname").val();
  if (!taskName) {
    $("#taskname_error").text("Task Name is required");
    isValid = false;

    console.log("taskname_error");

  }

  // Checking User
  // let userChecked = $('input[name="user[]"]:checked').length;
  // if (userChecked === 0) {
  //   $("#user_error").text("User is required");
  //   isValid = false;

  //   console.log("user_error");

    
  // }

  // Checking Start Date
  let startDate = $("#startdate").val();
  if (!startDate) {
    $("#startdate_error").text("Start Date is required");
    isValid = false;
  }
  // Checking Due Date
  let dueDate = $("#duedate").val();
  if (!dueDate) {
    $("#duedate_error").text("Due Date is required");
    isValid = false;

    console.log("duedate_error");

  }

  // Checking Start Time
  let startTime = $("#starttime").val();
  if (!startTime) {
    $("#starttime_error").text("Start Time is required");
    isValid = false;
  }

  // Checking Due Time
  let dueTime = $("#duetime").val();
  if (!dueTime) {
    $("#duetime_error").text("Due Time is required");
    isValid = false;

    console.log("duetime_error");

  }
  // let taskpoints = $('#taskpoints').val();
  // if (!taskpoints) {
  //   $('#taskpoints_error').text('Taskpoints is required');
  //   isValid = false;
  // }

  // Checking Description
  let description = $("#mtdscrb").val();
  if (!description) {
    $("#mtdscrb_error").text("Description is required");
    isValid = false;

    console.log("mtdscrb_error");

    
  }

  // Checking Task Category
  let taskCategory = $('input[name="taskcategory"]:checked').val();
  if (!taskCategory) {
    $("#taskcategory_error").text("Task Category is required");
    isValid = false;

    console.log("taskcategory_error");

  }

  // Checking radio buttons
  let radioChecked = $('input[name="assignto"]:checked').length;
  if (radioChecked === 0) {
    $("#assignto_error").text("Assign to is required");
    isValid = false;
    console.log("assignto_error");
  }

  if (radioChecked === "Zone") {
    // Checking checkbox
    let checkboxChecked = $('input[name="zone[]"]:checked').length;
    if (checkboxChecked === 0) {
      $("#zone_error").text("Zone is required");
      isValid = false;
      console.log("zone_error");
    }

    // Checking taskarea checkboxes
    let taskareaChecked = $('input[name="taskarea[]"]:checked').length;
    if (taskareaChecked === 0) {
      $("#taskarea_error").text("Task Area is required");
      isValid = false;
      console.log("taskareaChecked");
    }

    // Checking city checkbox
    let cityChecked = $('input[name="city[]"]:checked').length;
    if ($("#city_all").is(":checked")) {
      cityChecked = $('.tsk_chk input[name="city[]"]').length;
    }

    if (cityChecked === 0) {
      $("#city_error").text("City is required");
      isValid = false;
      console.log("cityChecked");
    } else {
      $("#city_error").text("");
      isValid = true;
    }
  }

  return isValid;
}

// Remove error message on input change
$("#taskname").on("input", function () {
  $("#taskname_error").text("");
});

$("#startdate").on("input", function () {
  $("#startdate_error").text("");
});

$("#duedate").on("input", function () {
  $("#duedate_error").text("");
});

$("#starttime").on("input", function () {
  $("#starttime_error").text("");
});

$("#duetime").on("input", function () {
  $("#duetime_error").text("");
});

$("#mtdscrb").on("input", function () {
  $("#mtdscrb_error").text("");
});

// Remove error message on radio or checkbox selection
$('input[name="assignto"]').on("change", function () {
  $("#assignto_error").text("");
});

$('input[name="zone[]"]').on("change", function () {
  $("#zone_error").text("");
});
$('input[name="user[]"]').on("change", function () {
  $("#user_error").text("");
});

$('input[name="taskarea[]"]').on("change", function () {
  $("#taskarea_error").text("");
});

// Handle the 'All' radio button
$("#taskarea_all").on("change", function () {
  if ($(this).is(":checked")) {
    $('.tsk_chk input[name="taskarea[]"]')
      .prop("checked", true)
      .trigger("change");
    $("#taskarea_error").text(""); // Clear error message when 'All' is selected
  }
});

$('input[name="city[]"]').on("change", function () {
  $("#city_error").text("");
});

// Handle the 'All' radio button
$("#city_all").on("change", function () {
  if ($(this).is(":checked")) {
    $('.tsk_chk input[name="city[]"]').prop("checked", true).trigger("change");
    $("#city_error").text(""); // Clear error message when 'All' is selected
  }
});

// Remove error message when task category radio button is selected
$('input[name="taskcategory"]').on("change", function () {
  $("#taskcategory_error").text("");
});

$("#city_all").on("change", function () {
  if ($(this).is(":checked")) {
    $('.tsk_chk input[id="city"]').prop("checked", true);
  }
});

$("#city_select").on("change", function () {
  if ($(this).is(":checked")) {
    $('.tsk_chk input[id="city"]').prop("checked", false);
  }
});

// Function to handle "All" and "Select" options for Zone checkboxes
$("#zone_all").on("change", function () {
  if ($(this).is(":checked")) {
    $('.tsk_chk input[id="zone"]').prop("checked", true);
  }
});

$("#zone_select").on("change", function () {
  if ($(this).is(":checked")) {
    $('.tsk_chk input[id="zone"]').prop("checked", false);
  }
});

// Function to handle "All" and "Select" options for Task Area checkboxes
$("#taskarea_all").on("change", function () {
  if ($(this).is(":checked")) {
    $('.tas_c_flx input[id="taskarea"]').prop("checked", true);
  }
});

$("#taskarea_select").on("change", function () {
  if ($(this).is(":checked")) {
    $('.tas_c_flx input[id="taskarea"]').prop("checked", false);
  }
});

$('input[name="assignto"]').change(function () {
  $("#userZoneHideShow").css("border-bottom", "1px solid #ccc");
  $("#userOrZoneSelect").show();
  if ($(this).val() === "Individual") {
    $("#userValues").show();
    $("#selectZone").hide();
    $("#areaCityHideShow").hide();
    $("#areaHideShow").hide();
    $("#cityHideShow").hide();
  } else {
    $("#userValues").hide();
  }

  if ($(this).val() === "Zone") {
    $("#selectZone").show();
  } else {
    $("#selectZone").hide();
  }
});

$('input[name="zone[]"]').change(function () {
  let zoneIds = [];

  // Collect all checked checkbox values
  $('input[name="zone[]"]:checked').each(function () {
    zoneIds.push($(this).val());
  });

  if (zoneIds.length > 0) {
    $.ajax({
      url: "{{ route('zone.taskArea') }}",
      data: {
        zoneIds: zoneIds, // Send the array of selected zone IDs
      },
      method: "GET",
      success: function (response) {
        console.log(response[0]);

        const areaList = $("#areasOfSelectedZones");
        areaList.empty();

        let taskareaIds = [];

        // Iterate over the response and generate the HTML for each area
        response.forEach(function (area) {
          const areaId = area._id.$oid;
          taskareaIds.push(areaId);
          const areaItem = `
                                            <div class="chk_i">
                                                <input type="checkbox" id="taskarea_${areaId}" name="taskarea[]" autocomplete="off"
                                                    value="${areaId}" checked  onclick="checkMe(this, this.checked);">
                                                <label for="taskarea_${areaId}">${area.name}</label>
                                            </div>
                                            <div id="a_${areaId}">
                                                <div class="tas_i_rdo" style="display:none;">
                                                    <div class="rdo_i">
                                                        <input type="radio" id="select_m_${areaId}" value="M" name="m_${areaId}">
                                                        <label for="select_m_${areaId}">M</label><span>*</span>
                                                    </div>
                                                    <div class="rdo_i">
                                                        <input type="radio" id="select_nm_${areaId}" value="NM" name="m_${areaId}">
                                                        <label for="select_nm_${areaId}">NM</label>
                                                    </div>
                                                </div>
                                            </div>
                                        `;
          areaList.append(areaItem); // Append the new area item to the list
        });
        fetchCities(taskareaIds);
        $('input[name="taskarea[]"]').change(function () {
          let taskareaIds = [];

          // Collect all checked checkbox values
          $('input[name="taskarea[]"]:checked').each(function () {
            taskareaIds.push($(this).val());
          });
          fetchCities(taskareaIds);
        });
      },
      error: function (xhr, status, error) {
        console.error("Error fetching task areas:", error);
      },
    });

    $("#areaCityHideShow").show();
    $("#areaHideShow").show();
  } else {
    // Hide the areas if no checkboxes are checked
    $("#areaCityHideShow").hide();
    $("#areaHideShow").hide();
  }

  function fetchCities(taskareaIds) {
    if (taskareaIds.length > 0) {
      $.ajax({
        url: "{{ route('taskarea.cities') }}", // Adjust the route as necessary
        data: {
          taskareaIds: taskareaIds, // Send the array of selected taskarea IDs
        },
        method: "GET",
        success: function (response) {
          console.log(response);

          const citiesList = $("#citiesOfSelectedTaskareas");
          citiesList.empty(); // Clear previous cities

          let cityIds = [];

          // Iterate over the response and generate the HTML for each city
          response.forEach(function (city) {
            const cityId = city._id.$oid; // Extract city ID from MongoDB _id field
            cityIds.push(cityId);
            const cityItem = `
                                            <div class="chk_i">
                                                <input type="checkbox" id="city_${cityId}" name="city[]" autocomplete="off"
                                                    value="${cityId}" checked onclick="checkCity(this, this.checked);">
                                                <label for="city_${cityId}">${city.name}</label>
                                            </div>
                                        `;
            citiesList.append(cityItem); // Append the new city item to the container
          });

          fetchUsers(cityIds);
          $('input[name="city[]"]').change(function () {
            let cityIds = [];

            // Collect all checked checkbox values
            $('input[name="city[]"]:checked').each(function () {
              cityIds.push($(this).val());
            });
            fetchUsers(cityIds);
          });

          citiesList.show(); // Show the cities container
        },
        error: function (xhr, status, error) {
          console.error("Error fetching cities:", error);
        },
      });

      $("#cityHideShow").show();
    } else {
      // $('#citiesOfSelectedTaskareas').hide(); // Hide the cities container if no checkboxes are checked
      $("#cityHideShow").hide();
    }
  }

  function fetchUsers(cityIds) {
    // Check if there is at least one checkbox checked
    if (cityIds.length > 0) {
      $.ajax({
        url: "{{ route('cities.getUsers') }}", // Adjust the route as necessary
        data: {
          cityIds: cityIds, // Send the array of selected taskarea IDs
        },
        method: "GET",
        success: function (response) {
          console.log(response);

          const prabhariList = $("#prabhariList");
          prabhariList.empty(); // Clear previous cities
          if (response.length > 0) {
            // Iterate over the response and generate the HTML for each city
            response.forEach(function (user) {
              const userId = user._id.$oid; // Extract city ID from MongoDB _id field
              const allUsers = `
                                                <div class="chk_i">
                                                    <input type="checkbox" id="user_${userId}" name="user[]" autocomplete="off" value="${userId}" checked onclick="checkPrabhari(this, this.checked);">
                                                    <label>${user.name}</label>
                                                </div>
                                                
                                            `;
              prabhariList.append(allUsers); // Append the new city item to the container
            });

            prabhariList.show(); // Show the cities container
          } else {
            const allUsers = `
                                        <div class="chk_i">
                                            <p style="font-size: 14px;">No user found.</ style="font-size: 14px;">
                                        </div>
                                        `;
            prabhariList.append(allUsers); // Append the new city item to the container
          }
        },
        error: function (xhr, status, error) {
          console.error("Error fetching cities:", error);
        },
      });

      $("#prabhariOfSelectedArea").show();
      $("#prabhariList").show();
    } else {
      // $('#citiesOfSelectedTaskareas').hide(); // Hide the cities container if no checkboxes are checked
      $("#prabhariOfSelectedArea").hide();
      $("#prabhariList").hide();
    }
  }

  // if ($(this).is(':checked')) {

  //     zoneId = $('input[name="zone[]"]:checked').val();
  //     console.log(zoneId);

  //     $.ajax({
  //         url: "{{ route('zone.taskArea') }}",
  //         data: {
  //             zoneId: zoneId
  //         },
  //         method: 'GET',
  //         success: function(response) {
  //             console.log(response)
  //         },

  //     });

  //     $("#areaCityHideShow").show();
  //     $("#areaHideShow").show();
  // }
});

// Validate task points on form submission
$("#dynamic-form").on("submit", function (event) {
  var isValid = true;

  var taskpoints = $("#taskpoints").val();
  if (!taskpoints) {
    $("#taskpoints_error").text("Task points is required");
    isValid = false;
  } else {
    $("#taskpoints_error").text("");
  }

  var taskPoints = parseFloat($("#taskpoints").val()) || 0;
  var subtaskPoints = 0;

  $(".subtaskpoint").each(function () {
    if ($(this).val() != "") {
      subtaskPoints += parseFloat($(this).val()) || 0;
      $(this).next(".subtaskpoint_error").html("");
    } else {
      $(this).next(".subtaskpoint_error").html("Enter Subtask Point");
    }
  });

  if (subtaskPoints !== taskPoints) {
    $("#taskpoint_error").html(
      "The total of subtask points (" +
        subtaskPoints +
        ") does not equal the task points (" +
        taskPoints +
        "). Please adjust the subtask points."
    );
    isValid = false;
  } else {
    $("#taskpoint_error").html("");
  }

  $(".subtask-question-text").each(function () {
    if ($(this).val() != "") {
      $(this).next(".subtask-question-text-error").html("");
    } else {
      $(this).next(".subtask-question-text-error").html("Enter Question");
      isValid = false;
    }
  });

  $(".subtask-question-select").each(function () {
    if ($(this).val() != "") {
      $(this).next(".subtask-question-select-error").html("");
    } else {
      $(this).next(".subtask-question-select-error").html("Select An Option");
      isValid = false;
    }
  });

  $(".conditional-task-question").each(function () {
    if ($(this).val() != "") {
      $(this).next(".conditional-task-question-error").html("");
    } else {
      $(this).next(".conditional-task-question-error").html("Enter Question");
      isValid = false;
    }
  });

  $(".conditional-task-selecttype").each(function () {
    if ($(this).val() != "") {
      $(this).next(".conditional-task-selecttype-error").html("");
    } else {
      $(this)
        .next(".conditional-task-selecttype-error")
        .html("Select An Option");
      isValid = false;
    }
  });

  // if (!validateForm() || !isValid || !validateForms()) {
  //   event.preventDefault();
  // }

  console.log(validateForm());
  console.log(validateForms());
  console.log(isValid);

  if (validateForm() && isValid && validateForms()) {
    const taskName = $("#taskname").val();
    const taskAssignedTo = $(".assignTo:checked").val();
    let assignedZones = [];
    $(".zone-option:checked").each(function () {
      assignedZones.push($(this).val());
    });

    let assignedSubzones = [];
    $(".subzone-option:checked").each(function () {
      assignedSubzones.push($(this).val());
    });

    let assignedAreas = [];
    $(".city-option:checked").each(function () {
      assignedAreas.push($(this).val());
    });

    let assignedIndividuals = [];
    $(".individual-option:checked").each(function () {
      assignedIndividuals.push($(this).val());
    });

    const startDate = convertDateFormat($("#startdate").val());
    const dueDate = convertDateFormat($("#duedate").val());
    const startTime = $("#starttime").val();
    const dueTime = $("#duetime").val();

    const taskCategory = $("#taskcategory:checked").val();

    const description = $("#mtdscrb").val();

    const taskPoints = Number($("#taskpoints").val());

    const subtasks = JSON.parse($("#taskObjectString").val());

    var csrfToken = $('meta[name="csrf-token"]').attr("content");

    var mandatoryAreaCategories = getCategoryObject();

    // console.log(validateForms());

    $.ajax({
      url: "insert-task",
      type: "POST",
      data: {
        taskName,
        taskAssignedTo,
        assignedZones,
        assignedSubzones,
        assignedAreas,
        assignedIndividuals,
        startDate,
        dueDate,
        startTime,
        dueTime,
        taskCategory,
        description,
        taskPoints,
        subtasks,
        mandatoryAreaCategories,
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
              window.location.href = "taskview";
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
  } else {
    event.preventDefault();
  }

  // if (!isValid) {
  //   event.preventDefault();
  // }

  // if (!validateForms()) {
  //   event.preventDefault(); // Prevent form submission if validation fails
  // }
});

// Function to validate all form sections
function validateForms() {
  var isValid = true;
  var taskpoints = parseInt($("#taskpoints").val()) || 0;
  var totalSubtaskpoints = 0;
  var allSubtaskPointsEmpty = true; // Flag to track if all subtask points are empty

  // Loop through each form section
  $(".form-section").each(function (index) {
    var question = $(this).find('input[name*="[question]"]');
    var type = $(this).find('select[name*="[type]"]');
    var subtaskpoint =
      parseInt($(this).find('input[name*="[subtaskpoint]"]').val()) || 0;
    totalSubtaskpoints += subtaskpoint;

    // Check if the question field is empty
    if (question.val() === "") {
      $(this).find("#ques_error").text("This field is required.");
      isValid = false;
    } else {
      $(this).find("#ques_error").text("");
    }

    // Check if the type field is not selected
    if (type.val() === "") {
      $(this).find("#typ_error").text("This field is required.");
      isValid = false;
    } else {
      $(this).find("#typ_error").text("");
    }

    // Check if the subtask point field is empty
    if (subtaskpoint === 0) {
      $(this).find(".subtask_error").text("Subtask point is required.");
    } else {
      allSubtaskPointsEmpty = false; // Set the flag to false if any subtask point is not empty
      $(this).find(".subtask_error").text("");
    }
  });

  // Check if taskpoints match the sum of subtask points
  if (!allSubtaskPointsEmpty) {
    if (taskpoints !== totalSubtaskpoints) {
      $("#points_error").text("Please complete the sub-task points.");
      isValid = false;
    } else {
      $("#points_error").text("");
    }
  }

  return isValid;
}

$("#subtask-container").on("input", ".subtaskpoint", function () {
  if ($(this).val() != "") {
    $(this).next(".subtaskpoint_error").html("");
  } else {
    $(this).next(".subtaskpoint_error").html("Enter Subtask Point");
  }
});

$("#subtask-container").on("input", ".subtask-question-text", function () {
  if ($(this).val() != "") {
    $(this).next(".subtask-question-text-error").html("");
  } else {
    $(this).next(".subtask-question-text-error").html("Enter Question");
  }
});

$("#subtask-container").on("change", ".subtask-question-select", function () {
  if ($(this).val() != "") {
    $(this).next(".subtask-question-select-error").html("");
  } else {
    $(this).next(".subtask-question-select-error").html("Select An Option");
  }
});

$("#subtask-container").on(
  "change",
  ".conditional-task-selecttype",
  function () {
    if ($(this).val() != "") {
      $(this).next(".conditional-task-selecttype-error").html("");
    } else {
      $(this)
        .next(".conditional-task-selecttype-error")
        .html("Select An Option");
    }
  }
);

$("#subtask-container").on("input", ".conditional-task-question", function () {
  if ($(this).val() != "") {
    $(this).next(".conditional-task-question-error").html("");
  } else {
    $(this).next(".conditional-task-question-error").html("Enter Question");
  }
});
