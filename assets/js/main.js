document.addEventListener('DOMContentLoaded', () => {
    initCartSystem();
    initCatalogFilters();
    initSearchHUD();
});

function initCartSystem() {
    const cartDrawer = document.getElementById('cartDrawer');
    const cartBackdrop = document.getElementById('cartBackdrop');
    const cartTriggers = document.querySelectorAll('.cart-trigger-btn, .open-cart-btn');
    const cartCloseBtn = document.getElementById('closeCartBtn');
    const cartItemsContainer = document.getElementById('cartItemsContainer');
    const cartTotalElement = document.getElementById('cartTotalElement');
    const cartBadge = document.getElementById('cartCountBadge');
    const freeShippingBar = document.getElementById('freeShippingProgress');
    const freeShippingText = document.getElementById('freeShippingText');

    let cart = JSON.parse(localStorage.getItem('vertex_cart')) || [];

    function openCart() {
        if (cartDrawer && cartBackdrop) {
            cartDrawer.classList.add('open');
            cartBackdrop.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeCart() {
        if (cartDrawer && cartBackdrop) {
            cartDrawer.classList.remove('open');
            cartBackdrop.classList.remove('show');
            document.body.style.overflow = '';
        }
    }

    cartTriggers.forEach(btn => btn.addEventListener('click', (e) => {
        e.preventDefault();
        openCart();
    }));

    if (cartCloseBtn) cartCloseBtn.addEventListener('click', closeCart);
    if (cartBackdrop) cartBackdrop.addEventListener('click', closeCart);

    function renderCart() {
        if (!cartItemsContainer) return;

        cartItemsContainer.innerHTML = '';
        let total = 0;
        let totalItems = 0;

        if (cart.length === 0) {
            cartItemsContainer.innerHTML = `
                <div class="text-center py-5">
                    <i class="bi bi-bag-x display-4 text-muted mb-3 d-block"></i>
                    <p class="text-muted mb-3">Votre panier est vide.</p>
                    <a href="produits.php" class="btn btn-vertex-outline btn-sm-tech">
                        Explorer les sacs à dos
                    </a>
                </div>
            `;
        } else {
            cart.forEach((item, index) => {
                total += item.price * item.quantity;
                totalItems += item.quantity;

                const itemRow = document.createElement('div');
                itemRow.className = 'cart-item-card';
                itemRow.innerHTML = `
                    <img src="${item.image}" alt="${item.name}" class="cart-item-thumb">
                    <div class="cart-item-info">
                        <div class="cart-item-title">${item.name}</div>
                        <div class="cart-item-meta">${item.volume} | ${item.weight}</div>
                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <div class="d-flex align-items-center gap-2">
                                <button class="btn btn-sm btn-dark px-2 py-0 border border-secondary" onclick="updateItemQuantity(${index}, -1)">-</button>
                                <span class="tech-mono">${item.quantity}</span>
                                <button class="btn btn-sm btn-dark px-2 py-0 border border-secondary" onclick="updateItemQuantity(${index}, 1)">+</button>
                            </div>
                            <span class="text-amber fw-bold">${(item.price * item.quantity).toFixed(2)} €</span>
                            <button class="btn btn-link text-muted p-0 text-decoration-none" onclick="removeCartItem(${index})" title="Supprimer">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
                cartItemsContainer.appendChild(itemRow);
            });
        }

        // Mise à jour des totaux et badges
        if (cartTotalElement) cartTotalElement.innerText = `${total.toFixed(2)} €`;
        if (cartBadge) {
            cartBadge.innerText = totalItems;
            cartBadge.style.display = totalItems > 0 ? 'inline-block' : 'none';
        }

        // Barre de livraison gratuite (Seuil 150€)
        const freeShippingThreshold = 150;
        if (freeShippingBar && freeShippingText) {
            const percentage = Math.min(100, (total / freeShippingThreshold) * 100);
            freeShippingBar.style.width = `${percentage}%`;

            if (total >= freeShippingThreshold) {
                freeShippingText.innerHTML = '<span class="text-success"><i class="bi bi-check-circle-fill me-1"></i>Livraison gratuite offerte !</span>';
                freeShippingBar.className = 'progress-bar bg-success';
            } else {
                const remaining = (freeShippingThreshold - total).toFixed(2);
                freeShippingText.innerHTML = `Ajoutez <strong class="text-amber">${remaining} €</strong> pour la livraison offerte`;
                freeShippingBar.className = 'progress-bar bg-warning';
            }
        }

        localStorage.setItem('vertex_cart', JSON.stringify(cart));
    }

    // Fonctions globales pour gestion des clics
    window.updateItemQuantity = function (index, change) {
        if (cart[index]) {
            cart[index].quantity += change;
            if (cart[index].quantity <= 0) {
                cart.splice(index, 1);
            }
            renderCart();
        }
    };

    window.removeCartItem = function (index) {
        if (cart[index]) {
            cart.splice(index, 1);
            renderCart();
        }
    };

    window.addToCart = function (productData) {
        const existing = cart.find(item => item.id === productData.id);
        if (existing) {
            existing.quantity += 1;
        } else {
            cart.push({ ...productData, quantity: 1 });
        }
        renderCart();
        openCart();
        showFeedbackToast(`Ajouté au panier : ${productData.name}`);
    };

    // Détection des boutons d'ajout au panier
    document.querySelectorAll('.btn-add-to-cart').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const productData = {
                id: parseInt(btn.dataset.id),
                name: btn.dataset.name,
                price: parseFloat(btn.dataset.price),
                volume: btn.dataset.volume,
                weight: btn.dataset.weight,
                image: btn.dataset.image
            };
            window.addToCart(productData);
        });
    });

    renderCart();
}

function showFeedbackToast(message) {
    let toast = document.getElementById('vertexToast');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'vertexToast';
        toast.style.position = 'fixed';
        toast.style.bottom = '24px';
        toast.style.left = '24px';
        toast.style.backgroundColor = '#131a20';
        toast.style.border = '1px solid #ff6b00';
        toast.style.color = '#fff';
        toast.style.padding = '12px 20px';
        toast.style.borderRadius = '6px';
        toast.style.fontFamily = 'monospace';
        toast.style.fontSize = '0.85rem';
        toast.style.zIndex = '2000';
        toast.style.boxShadow = '0 6px 20px rgba(0,0,0,0.5)';
        toast.style.transition = 'all 0.2s ease';
        document.body.appendChild(toast);
    }
    toast.innerHTML = `<i class="bi bi-check-circle-fill text-warning me-2"></i> ${message}`;
    toast.style.opacity = '1';
    toast.style.transform = 'translateY(0)';

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(8px)';
    }, 2500);
}

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
        const targetBtn = document.querySelector(`.catalog-filter-btn[data-filter="${catParam}"]`);
        if (targetBtn) {
            targetBtn.click();
        }
    }
}

function initSearchHUD() {
    const searchInputs = document.querySelectorAll('.tech-search-input');
    const productItems = document.querySelectorAll('.catalog-product-item');

    searchInputs.forEach(input => {
        input.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase().trim();

            if (productItems.length > 0) {
                productItems.forEach(item => {
                    const text = item.innerText.toLowerCase();
                    if (text.includes(query)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            }
        });

        input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                const query = input.value.trim();
                if (query && !window.location.pathname.includes('produits.php')) {
                    window.location.href = `produits.php?q=${encodeURIComponent(query)}`;
                }
            }
        });
    });

    const urlParams = new URLSearchParams(window.location.search);
    const qParam = urlParams.get('q');
    if (qParam && productItems.length > 0) {
        searchInputs.forEach(input => input.value = qParam);
        productItems.forEach(item => {
            const text = item.innerText.toLowerCase();
            if (text.includes(qParam.toLowerCase())) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }
}
