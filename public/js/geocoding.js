const addressInputs = document.querySelectorAll(".address-input");

addressInputs.forEach((input) => {
  let timeout;
  // A chaque lettre tapée, attend 300 milisecondes avant l'exécution du code
  input.addEventListener("input", () => {
    clearTimeout(timeout);

    timeout = setTimeout(() => {
      searchAddress(input);
    }, 300);
  });
});

/**
 * Function which allows geocoding queries using data.geopf.fr/geocodage API
 */
async function searchAddress(inputElement) {
  const query = inputElement.value; // Récupère la valeur de l'input

  const resultsBox = inputElement.nextElementSibling; // L'élément suivant dans le DOM

  // Si l'utilisateur a entré moins de 3 caractères, ne fait rien
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

    /*
     * Affichage des données
     */
    data.features.forEach((element) => {
      const option = document.createElement("div");
      option.textContent = element.properties.label;

      option.addEventListener("click", () => {
        input.value = element.properties.label;
      });

      resultsBox.appendChild(option);
    });
  } catch (error) {
    resultsBox.textContent =
      "Erreur de chargement, veuillez réessayer plus tard.";

    console.log("Erreur geocoding" + error);
    return;
  }
}
