document.addEventListener('DOMContentLoaded', () => {
    initCatalogFilters();
    initSearchHUD();
});

function initCatalogFilters() {
    const filterButtons = document.querySelectorAll('.catalog-filter-btn');
    const productItems = document.querySelectorAll('.catalog-product-item');

    if (!filterButtons.length || !productItems.length) return;

    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            filterButtons.forEach(b => b.classList.remove('active', 'btn-warning'));
            filterButtons.forEach(b => b.classList.add('btn-vertex-outline'));

            btn.classList.add('active', 'btn-warning');
            btn.classList.remove('btn-vertex-outline');

            const filter = btn.dataset.filter;

            productItems.forEach(item => {
                if (filter === 'all' || item.dataset.category === filter) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });

    // Activation automatique selon le paramètre d'URL ?cat=
    const urlParams = new URLSearchParams(window.location.search);
    const catParam = urlParams.get('cat');
    if (catParam) {
        const targetBtn = document.querySelector(`.catalog-filter-btn[data-filter="${CSS.escape(catParam)}"]`);
        if (targetBtn) {
            targetBtn.click();
        }
    }
}

function initSearchHUD() {
    const searchInputs = document.querySelectorAll('.tech-search-input');
    const productItems = document.querySelectorAll('.catalog-product-item');

    // Recherche instantanée client-side sur la page produits
    searchInputs.forEach(input => {
        input.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase().trim();

            if (productItems.length > 0) {
                productItems.forEach(item => {
                    const text = item.innerText.toLowerCase();
                    item.style.display = text.includes(query) ? 'block' : 'none';
                });
            }
        });
    });

    // Pré-remplir le champ de recherche avec le paramètre URL
    const urlParams = new URLSearchParams(window.location.search);
    const qParam = urlParams.get('q');
    if (qParam) {
        searchInputs.forEach(input => input.value = qParam);
    }
}
