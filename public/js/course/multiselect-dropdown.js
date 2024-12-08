$("#zone-selector .select-all").change(function () {
  $("#zone-selector .option")
    .prop("checked", $(this).prop("checked"))
    .trigger("change");
});

$("#zone-selector .option").change(function () {
  var allChecked =
    $("#zone-selector .option:checked").length ===
    $("#zone-selector .option").length;
  $("#zone-selector .select-all").prop("checked", allChecked);
});

$("#zone-selector .search-box").on("input", function () {
  var filter = $(this).val().toLowerCase();
  $("#zone-selector .dropdown-content label").each(function () {
    var text = $(this).text().toLowerCase();
    $(this).toggle(text.includes(filter));
  });
});

$("#zone-selector .clear-icon").click(function () {
  $("#zone-selector .search-box").val("").trigger("input");
});

$("#subzone-selector .select-all").change(function () {
  $("#subzone-selector .option")
    .prop("checked", $(this).prop("checked"))
    .trigger("change");
});

$("#subzone-selector .option").change(function () {
  var allChecked =
    $("#subzone-selector .option:checked").length ===
    $("#subzone-selector .option").length;
  $("#subzone-selector .select-all").prop("checked", allChecked);
});

$("#subzone-selector .search-box").on("input", function () {
  var filter = $(this).val().toLowerCase();
  $("#subzone-selector .dropdown-content label").each(function () {
    var text = $(this).text().toLowerCase();
    $(this).toggle(text.includes(filter));
  });
});

$("#subzone-selector .clear-icon").click(function () {
  $("#subzone-selector .search-box").val("").trigger("input");
});

$("#city-selector .select-all").change(function () {
  $("#city-selector .option")
    .prop("checked", $(this).prop("checked"))
    .trigger("change");
});

$("#city-selector .option").change(function () {
  var allChecked =
    $("#city-selector .option:checked").length ===
    $("#city-selector .option").length;
  $("#city-selector .select-all").prop("checked", allChecked);
});

$("#city-selector .search-box").on("input", function () {
  var filter = $(this).val().toLowerCase();
  $("#city-selector .dropdown-content label").each(function () {
    var text = $(this).text().toLowerCase();
    $(this).toggle(text.includes(filter));
  });
});

$("#city-selector .clear-icon").click(function () {
  $("#city-selector .search-box").val("").trigger("input");
});

$("#individual-selector .select-all").change(function () {
  $("#individual-selector .option")
    .prop("checked", $(this).prop("checked"))
    .trigger("change");
});

$("#individual-selector .option").change(function () {
  var allChecked =
    $("#individual-selector .option:checked").length ===
    $("#individual-selector .option").length;
  $("#individual-selector .select-all").prop("checked", allChecked);
});

$("#individual-selector .search-box").on("input", function () {
  var filter = $(this).val().toLowerCase();
  $("#individual-selector .dropdown-content label").each(function () {
    var text = $(this).text().toLowerCase();
    $(this).toggle(text.includes(filter));
  });
});

$("#individual-selector .clear-icon").click(function () {
  $("#individual-selector .search-box").val("").trigger("input");
});

$(".dropdown-content").on("change", ".option", function () {
  var isChecked = $(this).prop("checked");
  var optionCategory = $(this).data("option-category");
  var optionId = $(this).attr("id");

  $(`input[type="checkbox"][data-${optionCategory}-id="${optionId}"]`)
    .prop("checked", isChecked)
    .trigger("change");
});
