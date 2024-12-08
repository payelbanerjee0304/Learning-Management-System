$(document).on("click", ".assignTo", function () {
  showSelectorsContainer();
  hideAllSelector();

  const taskAssignedTo = $(this).val();

  switch (taskAssignedTo) {
    case "zone":
      loadSelector("zone-selector-container");
      loadSelector("subzone-selector-container");
      loadSelector("city-selector-container");
      break;

    case "subzone":
      loadSelector("subzone-selector-container");
      loadSelector("city-selector-container");
      break;

    case "city":
      loadSelector("city-selector-container");
      break;

    case "individual":
      loadSelector("individual-selector-container");
      break;

    case "general":
      hideSelectorsContainer();
      break;

    default:
      break;
  }
});

const showSelectorsContainer = () => {
  const selectorsContainer = $("#filters-container");
  selectorsContainer.show();
};

const hideSelectorsContainer = () => {
  const selectorsContainer = $("#filters-container");
  selectorsContainer.hide();
};

const hideAllSelector = () => {
  const selectors = $(".filter");
  selectors.hide();
};

const loadSelector = (selectorContainerId) => {
  const selectorContainer = $(`#${selectorContainerId}`);

  const selector = selectorContainer.children(".multiselect-dropdown");

  selector.css("width", "200px");

  selectorContainer.show();
  selector.show();
};
