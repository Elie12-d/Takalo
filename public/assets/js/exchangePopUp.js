// Attendre que le DOM soit chargé
document.addEventListener('DOMContentLoaded', function() {
    
    // Récupérer tous les boutons "Echanger"
    const exchangeButtons = document.querySelectorAll('.btn.main-btn.btn-inline');
    
    // Ajouter un écouteur d'événement à chaque bouton
    exchangeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault(); // Empêcher la navigation par défaut
            
            // Récupérer l'ID du produit actuel depuis le href
            const href = this.getAttribute('href');
            const currentProductId = href.split('/').pop();
            
            // Récupérer le nom du produit actuel
            const productCard = this.closest('.blog-card');
            const currentProductName = productCard.querySelector('.blog-title a').textContent;
            
            // Ouvrir la popup de sélection avec les produits de l'utilisateur connecté
            openProductSelectionPopup(currentProductId, currentProductName);
        });
    });
    
    // Fonction pour ouvrir la popup de sélection des produits
    async function openProductSelectionPopup(currentProductId, currentProductName) {
        
        // Afficher un loader pendant le chargement
        const overlay = createPopupOverlay();
        const popup = createPopupContainer();
        
        // Ajouter le loader
        const loader = createLoader();
        popup.appendChild(loader);
        overlay.appendChild(popup);
        document.body.appendChild(overlay);
        
        try {
            // Récupérer les produits de l'utilisateur connecté
            const response = await fetch('/myproducts/lists', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            
            if (!response.ok) {
                throw new Error('Erreur lors du chargement des produits');
            }
            
            // Analyser la réponse
            const data = await response.json();
            
            // Vider le popup et enlever le loader
            popup.innerHTML = '';
            
            // Ajouter l'en-tête
            const header = createPopupHeader();
            header.querySelector('button').onclick = () => overlay.remove();
            popup.appendChild(header);
            
            // Ajouter les informations du produit actuel
            const currentProductInfo = createCurrentProductInfo(currentProductName, currentProductId);
            popup.appendChild(currentProductInfo);
            
            // Titre de la liste
            const listTitle = document.createElement('h4');
            listTitle.textContent = 'Mes produits disponibles pour l\'échange :';
            listTitle.style.cssText = `
                margin: 20px 0 15px;
                color: #555;
                font-size: 16px;
                font-weight: 600;
            `;
            popup.appendChild(listTitle);
            
            // Créer la liste des produits de l'utilisateur
            const productList = document.createElement('div');
            productList.className = 'user-products-list';
            productList.style.cssText = `
                display: grid;
                gap: 12px;
                max-height: 400px;
                overflow-y: auto;
                padding-right: 5px;
            `;
            
            // Vérifier si l'utilisateur a des produits
            if (data.objects && data.objects.length > 0) {
                
                // Filtrer pour ne pas afficher le produit actuel
                const userProducts = data.objects.filter(product => 
                    product.id.toString() !== currentProductId.toString()
                );
                
                if (userProducts.length > 0) {
                    userProducts.forEach(product => {
                        const productItem = createProductItem(product, currentProductId, currentProductName, overlay);
                        productList.appendChild(productItem);
                    });
                } else {
                    // Message si aucun autre produit
                    const noProducts = createNoProductsMessage(
                        'Vous n\'avez pas d\'autres produits disponibles pour l\'échange.'
                    );
                    productList.appendChild(noProducts);
                }
            } else {
                // Message si aucun produit
                const noProducts = createNoProductsMessage(
                    'Vous n\'avez aucun produit dans votre liste.'
                );
                productList.appendChild(noProducts);
            }
            
            popup.appendChild(productList);
            
            // Ajouter un bouton pour fermer
            const closeButtonContainer = document.createElement('div');
            closeButtonContainer.style.cssText = `
                margin-top: 20px;
                text-align: center;
            `;
            
            const closeBtn = document.createElement('button');
            closeBtn.textContent = 'Fermer';
            closeBtn.style.cssText = `
                background: #6c757d;
                color: white;
                border: none;
                padding: 10px 30px;
                border-radius: 5px;
                cursor: pointer;
                font-size: 14px;
                transition: background 0.3s;
            `;
            closeBtn.onmouseenter = () => closeBtn.style.background = '#5a6268';
            closeBtn.onmouseleave = () => closeBtn.style.background = '#6c757d';
            closeBtn.onclick = () => overlay.remove();
            
            closeButtonContainer.appendChild(closeBtn);
            popup.appendChild(closeButtonContainer);
            
        } catch (error) {
            console.error('Erreur:', error);
            
            // Afficher un message d'erreur
            popup.innerHTML = '';
            
            const errorDiv = document.createElement('div');
            errorDiv.style.cssText = `
                padding: 40px;
                text-align: center;
                color: #dc3545;
            `;
            errorDiv.innerHTML = `
                <div style="font-size: 48px; margin-bottom: 20px;">⚠️</div>
                <h3 style="margin-bottom: 15px;">Erreur de chargement</h3>
                <p style="margin-bottom: 20px; color: #666;">
                    Impossible de charger vos produits.<br>
                    Veuillez réessayer.
                </p>
                <button onclick="location.reload()" style="
                    background: #007bff;
                    color: white;
                    border: none;
                    padding: 10px 30px;
                    border-radius: 5px;
                    cursor: pointer;
                    font-size: 14px;
                ">Réessayer</button>
                <button onclick="this.closest('.exchange-popup-overlay').remove()" style="
                    background: #6c757d;
                    color: white;
                    border: none;
                    padding: 10px 30px;
                    border-radius: 5px;
                    cursor: pointer;
                    font-size: 14px;
                    margin-left: 10px;
                ">Fermer</button>
            `;
            
            popup.appendChild(errorDiv);
        }
    }
    
    // Fonction pour créer l'overlay de la popup
    function createPopupOverlay() {
        const overlay = document.createElement('div');
        overlay.className = 'exchange-popup-overlay';
        overlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        `;
        return overlay;
    }
    
    // Fonction pour créer le conteneur de la popup
    function createPopupContainer() {
        const popup = document.createElement('div');
        popup.className = 'exchange-popup';
        popup.style.cssText = `
            background: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 700px;
            width: 90%;
            max-height: 85vh;
            overflow-y: auto;
            position: relative;
            box-shadow: 0 5px 30px rgba(0,0,0,0.3);
            animation: slideIn 0.3s ease;
        `;
        
        // Ajouter l'animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from {
                    opacity: 0;
                    transform: translateY(-20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);
        
        return popup;
    }
    
    // Fonction pour créer le loader
    function createLoader() {
        const loader = document.createElement('div');
        loader.style.cssText = `
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
        `;
        
        const spinner = document.createElement('div');
        spinner.style.cssText = `
            border: 4px solid #f3f3f3;
            border-top: 4px solid #007bff;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin-bottom: 20px;
        `;
        
        const style = document.createElement('style');
        style.textContent = `
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(style);
        
        const text = document.createElement('p');
        text.textContent = 'Chargement de vos produits...';
        text.style.cssText = `
            color: #666;
            font-size: 16px;
            margin: 0;
        `;
        
        loader.appendChild(spinner);
        loader.appendChild(text);
        
        return loader;
    }
    
    // Fonction pour créer l'en-tête de la popup
    function createPopupHeader() {
        const header = document.createElement('div');
        header.style.cssText = `
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 15px;
        `;
        
        const title = document.createElement('h3');
        title.textContent = 'Échange de produits';
        title.style.cssText = `
            margin: 0;
            color: #333;
            font-size: 22px;
            font-weight: 600;
        `;
        
        const closeButton = document.createElement('button');
        closeButton.innerHTML = '&times;';
        closeButton.style.cssText = `
            background: none;
            border: none;
            font-size: 32px;
            cursor: pointer;
            color: #999;
            padding: 0;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s;
        `;
        closeButton.onmouseenter = () => {
            closeButton.style.background = '#f8f9fa';
            closeButton.style.color = '#dc3545';
        };
        closeButton.onmouseleave = () => {
            closeButton.style.background = 'none';
            closeButton.style.color = '#999';
        };
        
        header.appendChild(title);
        header.appendChild(closeButton);
        
        return header;
    }
    
    // Fonction pour créer les informations du produit actuel
    function createCurrentProductInfo(productName, productId) {
        const info = document.createElement('div');
        info.style.cssText = `
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            border-radius: 8px;
            color: white;
            margin-bottom: 20px;
        `;
        
        info.innerHTML = `
            <div style="font-size: 14px; opacity: 0.9; margin-bottom: 5px;">Produit à échanger</div>
            <div style="font-weight: bold; font-size: 18px; margin-bottom: 5px;">${productName}</div>
            <div style="font-size: 13px; opacity: 0.9;">ID: ${productId}</div>
        `;
        
        return info;
    }
    
    // Fonction pour créer un élément produit
    function createProductItem(product, currentProductId, currentProductName, overlay) {
        const productItem = document.createElement('div');
        productItem.className = 'user-product-item';
        productItem.style.cssText = `
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        `;
        
        // Effet hover
        productItem.onmouseenter = () => {
            productItem.style.background = '#e9ecef';
            productItem.style.borderColor = '#28a745';
            productItem.style.transform = 'translateY(-2px)';
            productItem.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
        };
        productItem.onmouseleave = () => {
            productItem.style.background = '#f8f9fa';
            productItem.style.borderColor = 'transparent';
            productItem.style.transform = 'translateY(0)';
            productItem.style.boxShadow = 'none';
        };
        
        // Informations du produit
        const productInfo = document.createElement('div');
        productInfo.style.flex = '1';
        
        // Formater la date si elle existe
        const publishDate = product.published_at ? 
            `<span style="margin-left: 10px; color: #999;">📅 ${product.published_at}</span>` : '';
        
        productInfo.innerHTML = `
            <div style="display: flex; align-items: center; margin-bottom: 5px;">
                <span style="font-weight: bold; color: #333; font-size: 16px;">${product.name}</span>
            </div>
            <div style="font-size: 13px; color: #666; margin-bottom: 3px;">
                ${product.description || 'Aucune description'}
            </div>
            <div style="display: flex; align-items: center; font-size: 12px;">
                <span style="color: #999;">ID: ${product.id}</span>
                ${publishDate}
            </div>
        `;
        
        const selectButton = document.createElement('button');
        selectButton.textContent = 'Échanger';
        selectButton.style.cssText = `
            background: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s;
            margin-left: 15px;
        `;
        selectButton.onmouseenter = () => {
            selectButton.style.background = '#218838';
            selectButton.style.transform = 'scale(1.05)';
        };
        selectButton.onmouseleave = () => {
            selectButton.style.background = '#28a745';
            selectButton.style.transform = 'scale(1)';
        };
        
        // Action de sélection
        selectButton.onclick = (e) => {
            e.stopPropagation();
            submitExchange(currentProductId, product.id.toString(), currentProductName, product.name);
            overlay.remove();
        };
        
        // Clic sur l'ensemble de l'élément
        productItem.onclick = () => {
            submitExchange(currentProductId, product.id.toString(), currentProductName, product.name);
            overlay.remove();
        };
        
        productItem.appendChild(productInfo);
        productItem.appendChild(selectButton);
        
        return productItem;
    }
    
    // Fonction pour créer un message "aucun produit"
    function createNoProductsMessage(message) {
        const noProducts = document.createElement('div');
        noProducts.style.cssText = `
            padding: 40px 20px;
            text-align: center;
            color: #666;
            background: #f8f9fa;
            border-radius: 8px;
            font-size: 15px;
        `;
        noProducts.innerHTML = `
            <div style="font-size: 48px; margin-bottom: 15px;">📦</div>
            <p style="margin: 0;">${message}</p>
        `;
        return noProducts;
    }
    
    // Fonction pour envoyer les deux IDs
    function submitExchange(productId1, productId2, productName1, productName2) {
        // Confirmation de l'échange
        const confirmExchange = confirm(
            `Confirmez-vous l'échange de votre produit :\n\n` +
            `"${productName1}" (ID: ${productId1})\n\n` +
            `Contre :\n\n` +
            `"${productName2}" (ID: ${productId2}) ?`
        );
        
        if (confirmExchange) {
            
            // Afficher un indicateur de chargement
            const loadingToast = document.createElement('div');
            loadingToast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: #007bff;
                color: white;
                padding: 15px 25px;
                border-radius: 5px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                z-index: 10000;
                animation: slideInRight 0.3s ease;
            `;
            loadingToast.textContent = 'Traitement de l\'échange en cours...';
            document.body.appendChild(loadingToast);
            
            // Envoyer les données via fetch
            fetch('/products/exchange/confirm', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    product_id_1: productId1,
                    product_id_2: productId2,
                    timestamp: new Date().toISOString()
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur réseau');
                }
                return response.json();
            })
            .then(data => {
                // Retirer le toast de chargement
                loadingToast.remove();
                
                // Afficher un message de succès
                const successToast = document.createElement('div');
                successToast.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: #28a745;
                    color: white;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                    z-index: 10000;
                    animation: slideInRight 0.3s ease;
                    max-width: 350px;
                `;
                successToast.innerHTML = `
                    <div style="font-size: 24px; margin-bottom: 10px;">✅</div>
                    <div style="font-weight: bold; margin-bottom: 5px;">Échange initié avec succès !</div>
                    <div style="font-size: 13px; opacity: 0.9;">
                        Produit 1: ${productName1}<br>
                        Produit 2: ${productName2}
                    </div>
                `;
                document.body.appendChild(successToast);
                
                // Disparaître après 5 secondes
                setTimeout(() => {
                    successToast.style.animation = 'slideOutRight 0.3s ease';
                    setTimeout(() => successToast.remove(), 300);
                }, 5000);
                
                console.log('Échange envoyé:', { 
                    product_1: { id: productId1, name: productName1 },
                    product_2: { id: productId2, name: productName2 }
                });
            })
            .catch(error => {
                console.error('Erreur:', error);
                
                // Retirer le toast de chargement
                loadingToast.remove();
                
                // Afficher un message d'erreur
                alert(`❌ Une erreur est survenue lors de l'échange.\nVeuillez réessayer.`);
            });
        }
    }
    
    // Ajouter les animations de sortie
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
});