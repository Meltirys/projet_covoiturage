const ITEMS_PER_PAGE = 20;
let currentPage = 1;
let allResults = []; // Tous les résultats stockés en mémoire

function displayPage(page, renderItem, resultsDiv = "results") {
    const start   = (page - 1) * ITEMS_PER_PAGE;
    const end     = start + ITEMS_PER_PAGE;
    const results = allResults.slice(start, end);

    const container = document.querySelector('#' + resultsDiv);
    container.replaceChildren();

    results.forEach(item => {
        container.appendChild(renderItem(item))
    });
}

// Génère les boutons de pagination
function displayPagination(paginationDiv = "pagination", renderItem, resultsDiv) {
    const totalPages = Math.ceil(allResults.length / ITEMS_PER_PAGE);
    const container = document.querySelector('#' + paginationDiv);
    container.replaceChildren();

    if (totalPages <= 1) return; // Pas besoin de pagination

    for (let i = 1; i <= totalPages; i++) {
        const button = document.createElement('button');
        button.textContent = i;

        if (i === currentPage) {
            button.disabled = true; // Page courante désactivée
        }

        button.addEventListener('click', () => {
            currentPage = i;
            displayPage(currentPage, renderItem, resultsDiv);
            displayPagination(paginationDiv, renderItem, resultsDiv);
        })

        container.appendChild(button);
    }
}