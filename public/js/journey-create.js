/**
 * Fills the hidden fields with the matching data
 * @param {*} feature Data from geocoding API
 * @param {*} inputElement User input element
 */
function fillAddressFields(feature, inputElement) {
  const coords = feature.geometry.coordinates;
  const properties = feature.properties;
  const container = inputElement.parentElement;

  container.querySelector('input[name$="[lat]"]').value = coords[1];
  container.querySelector('input[name$="[lon]"]').value = coords[0];
  container.querySelector('input[name$="[city]"]').value =
    properties.city || "";
  container.querySelector('input[name$="[postcode]"]').value =
    properties.postcode || "";
}
// ===== Start/End
document.querySelectorAll(".address-input").forEach((input) => {
  initializeAddressInput(input, fillAddressFields);
});
// ===== Stops
/**
 * Applies fillAddressFields and handles callback of createStop function if needed
 * @param {*} feature
 * @param {*} inputElement User input element
 */
function handleStopSelection(feature, inputElement) {
  fillAddressFields(feature, inputElement);

  if (
    container === stopsContainer.lastElementChild &&
    container.querySelector('input[name$="[lat]"]').value !== ""
  ) {
    createStop();
  }
}

document.querySelectorAll(".stop-input").forEach((input) => {
  initializeAddressInput(input, handleStopSelection);
});

// Initializing optional stops

const stopsContainer = document.getElementById("stops-container");
let stopIndex = document.querySelectorAll(".stop").length;

/**
 * Creates input fields for new stops
 */
function createStop() {
  const stop = document.createElement("div");

  stop.classList.add("stop", "address-field");

  stop.innerHTML = `
    <input 
        class="stop-input" 
        type="text" 
        name="stops[${stopIndex}][label]"
        placeholder="Entrer un arrêt"
    >
    
    <input type="hidden" name="stops[${stopIndex}][lat]">
    <input type="hidden" name="stops[${stopIndex}][lon]">
    <input type="hidden" name="stops[${stopIndex}][city]">
    <input type="hidden" name="stops[${stopIndex}][postcode]">
    
    <div class="results"></div>
    <button type="button" class="remove-stop">Retirer</button>
    `;

  stopsContainer.appendChild(stop);

  initializeAddressInput(
    stop.querySelector(".address-input"),
    handleStopSelection,
  );

  stopIndex++;
}

/*
 * Adds a remove button
 */
stopsContainer.addEventListener("click", (e) => {
  if (e.target.classList.contains("remove-stop")) {
    e.target.closest(".stop").remove();
  }
});
