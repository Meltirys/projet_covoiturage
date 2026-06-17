/**
 * Fills additional fields with the matching data
 * @param {array} feature Data from geocoding API
 * @param {array} inputElement User input element
 */
function fillAddressFields(feature, inputElement) {
  const properties = feature.properties;

  inputElement.value = properties.name || "";
  document.getElementById("city-input").value = properties.city || "";
  document.getElementById("postcode-input").value = properties.postcode || "";
}

document.querySelectorAll(".address-input").forEach((input) => {
  initializeAddressInput(input, fillAddressFields);
});
