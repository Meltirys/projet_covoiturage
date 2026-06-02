/**
 * Adds an event listener to an address input
 *
 * @param {*} input User input element
 * @param {function} onSelect Callback function
 */
function initializeAddressInput(input, onSelect = null) {
  let timeout;

  // A chaque lettre tapée, attend 300 milisecondes avant l'exécution du code
  input.addEventListener("input", () => {
    clearTimeout(timeout);

    timeout = setTimeout(() => {
      searchAddress(input, onSelect);
    }, 300);
  });
}

/**
 * Function which allows the usage of geocoding queries with data.geopf.fr/geocodage API
 *
 * @param {*} inputElement User input element
 * @param {function} onSelect Callback function
 */
async function searchAddress(inputElement, onSelect = null) {
  const query = inputElement.value.trim();
  const container = inputElement.parentElement;
  const resultsBox = container.querySelector(".results");

  if (query.length < 3) {
    resultsBox.innerHTML = "";
    return;
  }

  try {
    const response = await fetch(
      `https://data.geopf.fr/geocodage/search?q=${encodeURIComponent(query)}&autocomplete=1&index=address,poi&limit=10&returntruegeometry=false`,
    );

    const data = await response.json();
    resultsBox.innerHTML = "";

    if (!data.features || !Array.isArray(data.features)) {
      return;
    }

    data.features.forEach((feature) => {
      const option = document.createElement("div");

      option.className = ""; // Ajouter classes CSS

      option.textContent = feature.properties.label;

      option.addEventListener("click", () => {
        resultsBox.innerHTML = "";

        if (onSelect) {
          onSelect(feature, inputElement);
        }
      });

      resultsBox.appendChild(option);
    });
  } catch (error) {
    resultsBox.textContent =
      "Erreur de chargement, veuillez réessayer plus tard.";
    console.log(error);
  }
}
