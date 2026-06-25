/**
 * Adds an event listener to an address input
 * @param {array} input User input element
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
 * @param {array} inputElement User input element
 * @param {function} onSelect Callback function
 */
async function searchAddress(inputElement, onSelect = null) {
    const query = inputElement.value.trim();
    const container = inputElement.parentElement;
    container.style.position = 'relative';
    const resultsBox = container.querySelector(".results");

    if (query.length < 3) {
        resultsBox.innerHTML = "";
        return;
    }

    try {
        // Requête API
        const response = await fetch(
            `https://data.geopf.fr/geocodage/search?q=${encodeURIComponent(query)}&autocomplete=1&index=address,poi&limit=10&returntruegeometry=false&lat=48.103&lon=-1.672`,
        );
        const data = await response.json();

        resultsBox.innerHTML = "";

        Object.assign(resultsBox.style, {
        position: 'absolute',
        top: '100%',
        left: '0',
        right: '0',
        zIndex: '100',
        background: 'var(--color-ocean-mid)',
        border: '0.5px solid rgba(180,140,60,0.3)',
        borderRadius: '10px',
        marginTop: '4px',
        overflow: 'hidden',
        maxHeight: '220px',
        overflowY: 'auto',
        boxShadow: '0 8px 24px rgba(0,0,0,0.12)',
      });

        if (!data.features || !Array.isArray(data.features)) {
            return;
        }

        // Displays autocompletion results
        data.features.forEach((feature) => {
            const option = document.createElement("div");
            option.style.cssText = 'padding: 10px 14px; font-size: 12px; cursor: pointer; color: var(--color-lightgrey); border-bottom: 0.5px solid rgba(180,140,60,0.1); background: var(--color-ocean-mid);';
            option.addEventListener('mouseenter', () => option.style.background = 'rgba(180,140,60,0.08)');
            option.addEventListener('mouseleave', () => option.style.background = 'var(--color-ocean-mid)');
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
        resultsBox.textContent = "Erreur de chargement, veuillez réessayer plus tard.";
        console.log(error);
    }
}