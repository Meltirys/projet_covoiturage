/**
 * Fills the hidden fields with the matching data
 * @param {*} feature Data from geocoding API
 * @param {*} inputElement User input element
 */
function fillAddressFields(feature, inputElement) {
  const coords = feature.geometry.coordinates;
  const properties = feature.properties;
  const container = inputElement.parentElement;

  inputElement.value = feature.properties.label;
  container.querySelector('input[name$="[label]"]').value =
    properties.name || "";
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
const stops = document.querySelectorAll(".stop-input");
if (stops.length !== 0) {
  stops.forEach((input) => {
    initializeAddressInput(input, handleStopSelection);
  });

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

  // Initializing optional stops

  const stopsContainer = document.getElementById("stops-container");
  let stopIndex = stops.length;

  /**
   * Creates input fields for new stops
   */
  function createStop() {
    const stop = document.createElement("div");

    stop.className = "stop address-field flex flex-col gap-1";

    stop.innerHTML = `  
                <input 
                    type="text" 
                    name="drive[stops][${stopIndex}][address]"
                    class="stop-input border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-[#253F72] focus:outline-none focus:border-[#253F72]"
                    placeholder="Entrer un arrêt">
                <input type="hidden" name="drive[stops][${stopIndex}][label]">
                <input type="hidden" name="drive[stops][${stopIndex}][lat]">
                <input type="hidden" name="drive[stops][${stopIndex}][lon]">
                <input type="hidden" name="drive[stops][${stopIndex}][city]">
                <input type="hidden" name="drive[stops][${stopIndex}][postcode]">
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
}
