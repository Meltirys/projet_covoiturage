class Paginator {
    #ITEMS_PER_PAGE = 10;
    #currentPage = 1;
    #allResults = [];
    #renderItem;
    #resultsContainer;
    #paginationContainer;

    constructor(resultsContainer, paginationContainer, renderItem) {
        this.#renderItem = renderItem;
        this.#resultsContainer = resultsContainer;
        this.#paginationContainer = paginationContainer;
    }

    load(data) {
        this.#allResults = data;
        this.#currentPage = 1;
        this.#displayPage();
        this.#displayPagination();
    }

    /**
 * Display a page 
 * @param mixed page the page number to display
 * @param mixed renderItem a callback function that is responsible of rendering a single item of the result
 * @param mixed resultsDatas The results that will be displayed
 * @param string resultsDiv The div in which the results will be displayed. Default is 'results'
 */
    #displayPage() {
        const start = (this.#currentPage - 1) * this.#ITEMS_PER_PAGE;
        const end = start + this.#ITEMS_PER_PAGE;
        const results = this.#allResults.slice(start, end);

        this.#resultsContainer.replaceChildren();
        results.forEach(item => {
            this.#resultsContainer.appendChild(this.#renderItem(item))
        });
    }

    /**
 * Generates the paginations button and links each buttons to a single page of results
 * @param string paginationDiv The div id of where the paginations button would be rendered. Default is pagination
 * @param mixed renderItem The callback function responsible of rendering the items
 * @param mixed resultsDatas The results that will be displayed
 * @param mixed resultsDiv The div where the results will be displayed
 */
    #displayPagination() {
        const totalPages = Math.ceil(this.#allResults.length / this.#ITEMS_PER_PAGE);
        this.#paginationContainer.replaceChildren();

        if (totalPages <= 1) return; //No need to display the buttons if there is only one page

        for (let i = 1; i <= totalPages; i++) {
            const button = document.createElement('button');
            button.textContent = i;

            if (i === this.#currentPage) button.disabled = true;

                    //Generating the event when the button is clicked
            button.addEventListener('click', () => {
                this.#currentPage = i;
                this.#displayPage();
                this.#displayPagination();
            });

            this.#paginationContainer.appendChild(button);
        }
    }
}
