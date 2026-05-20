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

  const container = inputElement.parentElement;

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

  stop.className = "stop address-field flex flex-col gap-1";

  stop.innerHTML = `  
                <input 
                    type="text" 
                    name="stops[${stopIndex}][label]"
                    class="stop-input border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-[#253F72] focus:outline-none focus:border-[#253F72]"
                    placeholder="Entrer un arrêt">
                <input type="hidden" name="stops[${stopIndex}][lat]">
                <input type="hidden" name="stops[${stopIndex}][lon]">
                <input type="hidden" name="stops[${stopIndex}][city]">
                <input type="hidden" name="stops[${stopIndex}][postcode]">
                <div class="results"></div>
                    <button type="button" class="remove-stop text-xs text-[rgba(37,63,114,0.5)] underline text-right bg-transparent border-none cursor-pointer">
                        Retirer
                    </button>
            `;
  stopsContainer.appendChild(stop);

  initializeAddressInput(
    stop.querySelector(".stop-input"),
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
