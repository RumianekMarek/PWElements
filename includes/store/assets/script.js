const tradeFairName = store_js.trade_fair_name;
const fairs_array = store_js.fairs_array;
const admin = store_js.admin;

document.addEventListener('DOMContentLoaded', function() {
    const elImages = document.querySelectorAll(".pwe-store__featured-image");
    const pweMenu = document.querySelector("#pweMenu");

    function updateImagesPosition() {
        const viewportHeight = window.innerHeight;

        elImages.forEach(elImage => {
            const elContainer = elImage.parentElement;
            const containerRect = elContainer.getBoundingClientRect();

            if (pweMenu) {
                if (containerRect.top >= pweMenu.offsetHeight) {
                    elImage.classList.remove("sticky");
                    elImage.style.paddingTop = "0px";
                } else if (containerRect.top < pweMenu.offsetHeight && containerRect.bottom > viewportHeight) {
                    elImage.classList.add("sticky");
                    elImage.style.paddingTop = pweMenu.offsetHeight + 50 + "px";
                } 
            } else {
                if (containerRect.top >= 0) {
                    elImage.classList.remove("sticky");
                } else if (containerRect.top < 0 && containerRect.bottom > viewportHeight) {
                    elImage.classList.add("sticky");
                } 
            }
        });
    }
    window.addEventListener("resize", function () {
        if (window.innerWidth > 1024) {
            window.addEventListener("scroll", updateImagesPosition);
            updateImagesPosition();
        }
    });

    if (window.innerWidth > 1024) {
        window.addEventListener("scroll", updateImagesPosition);
        updateImagesPosition();
    }


    // Handle clicking the "MORE" button and card item
    const moreButtons = document.querySelectorAll('.pwe-store__service-card a');
    moreButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const featuredId = this.getAttribute('data-featured');
            showFeaturedService(featuredId);

            // Update the URL by adding a parameter
            const url = new URL(window.location);
            url.searchParams.set('featured-service', featuredId);
            window.history.pushState({}, '', url);

            // Scroll to top of page
            window.scrollTo({
                top: 18,
                behavior: "smooth"
            });
        });
    });

    // Handling parameter in URL
    const urlParams = new URLSearchParams(window.location.search);
    const featuredServiceParam = urlParams.get('featured-service');
    if (featuredServiceParam) {
        showFeaturedService(featuredServiceParam);

        // Scroll to top of page
        window.scrollTo({
            top: 18,
            behavior: "smooth"
        });
    }

    function showFeaturedService(featuredId) {
        // Hide all pwe-store__featured-service sections
        const featuredServices = document.querySelectorAll('.pwe-store__featured-service');
        featuredServices.forEach(service => service.style.display = 'none');

        // Show the appropriate section
        const featuredService = document.getElementById(featuredId);
        if (featuredService) {
            featuredService.style.display = 'block';
        }
    }

    let parent = document.querySelector('.pwe-store__featured-image')?.parentElement;

    while (parent) {
        const computedStyle = getComputedStyle(parent);
        const hasOverflow = computedStyle.overflow;
        const hasOverflowX = computedStyle.overflowX;
        const hasOverflowY = computedStyle.overflowY;

        if (hasOverflow !== 'visible' || hasOverflowX !== 'visible' || hasOverflowY !== 'visible') {
            parent.style.overflow = 'unset';
        }

        parent = parent.parentElement;
    }

    

    const allEditions = [...fairs_array.edition_1, ...fairs_array.edition_2, ...fairs_array.edition_3, ...fairs_array.edition_b2c];
    allEditions.sort((a, b) => new Date(a.date) - new Date(b.date));
  
    // Get domain address
    const currentUrl = window.location.hostname;

    let editionNumber = "";
    if (fairs_array.edition_1.includes(currentUrl)) {
        editionNumber = "1";
    } else if (fairs_array.edition_2.includes(currentUrl)) {
        editionNumber = "2";
    } else if (fairs_array.edition_3.includes(currentUrl)) {
        editionNumber = "3";
    } else if (fairs_array.edition_b2c.includes(currentUrl)) {
        editionNumber = "b2c";
    } else {
        editionNumber = "other";
    }

    // Redirect page to warsawexpo.eu with parameters for contact form
    const redirectButtons = document.querySelectorAll(".pwe-store__redirect-button");
    redirectButtons.forEach(button => {
        button.addEventListener("click", function (event) {
            event.preventDefault();

            // Get name of service
            const serviceName = this.closest(".pwe-store__service").querySelector(".pwe-store__service-name-mailing").textContent.trim();
            // Get domain 
            const currentDomain = window.location.hostname;
            // Get the page language
            const htmlLang = document.documentElement.lang;
            const baseUrl = (htmlLang === "pl-PL") 
                ? "https://warsawexpo.eu/sklep-uslugi-premium/" 
                : "https://warsawexpo.eu/en/shop-premium-services/";
            
            if (currentDomain === "mr.glasstec.pl") {
                
                const pweStore = document.querySelector(".pwe-store");

                if (pweStore) {
                    // Hide pwe-store
                    Array.from(pweStore.children).forEach(child => {
                        child.style.display = "none";
                    });
                }

                const fairsItemsContainer = document.querySelector(".pwe-store__fairs");
                fairsItemsContainer.style.display = "flex";
                const fairsItems = document.querySelector(".pwe-store__fairs-items");
                // Add options to select
                allEditions.forEach(fair => {
                    const fairItem = document.createElement("div");
                    fairItem.className = "pwe-store__fairs-item";
                    fairItem.id = fair.domain.replace(/\.[^.]*$/, "");
                    fairItem.style.background = `url('https://${fair.domain}/doc/kafelek.jpg')`; 
                    
                    fairItem.setAttribute("data-name", fair.name); // Fair name as attribute
                    fairItem.setAttribute("data-tooltip", fair.desc); // Fair description as attribute
                    fairItem.setAttribute("data-date", fair.date); // Fair date as attribute
                    fairItem.setAttribute("data-edition", fair.edition); // Fair edition as attribute
                    fairItem.setAttribute("data-domain", fair.domain); // Fair domain as attribute
                    
                    fairsItems.appendChild(fairItem);
                });

                // Add select to pweStore container
                pweStore.appendChild(fairsItemsContainer);

                // Nasłuchuj na zdarzenie w polu wyszukiwania
                const searchInput = document.querySelector(".pwe-store__fairs-search-input");
                searchInput.addEventListener("input", function () {
                    const searchTerm = searchInput.value.toLowerCase();

                    // Przechodzimy przez wszystkie elementy fairs
                    const allTales = document.querySelectorAll(".pwe-store__fairs-item");

                    allTales.forEach(item => {
                        const name = item.getAttribute("data-name").toLowerCase();
                        const tooltip = item.getAttribute("data-tooltip").toLowerCase();

                        // Jeśli wyszukiwany tekst znajduje się w nazwie lub opisie, pokazujemy element
                        if (name.includes(searchTerm) || tooltip.includes(searchTerm)) {
                            item.style.display = "block";
                        } else {
                            item.style.display = "none";
                        }
                    });
                });

                const allTales = document.querySelectorAll(".pwe-store__fairs-item");

                allTales.forEach(item => {
                    item.addEventListener("click", function () {
                        const selectedDomain = this.getAttribute("data-domain");
                        const selectedEdition = this.getAttribute("data-edition");
                        const selectedName = this.getAttribute("data-name");

                        const redirectUrl = `${baseUrl}?service=${encodeURIComponent(serviceName)}&domain=${encodeURIComponent(selectedDomain)}&event=${encodeURIComponent(selectedName)}&edition=${encodeURIComponent(selectedEdition)}`;
                        
                        // Open in new blank
                        window.open(redirectUrl, "_blank");
                        

                        // Reload page without params
                        window.location.replace(window.location.origin + window.location.pathname);
                    });
                });
            } else {
                const redirectUrl = `${baseUrl}?service=${encodeURIComponent(serviceName)}&domain=${encodeURIComponent(currentDomain)}&event=${encodeURIComponent(tradeFairName)}&edition=${encodeURIComponent(editionNumber)}`;
                // Open new window
                window.open(redirectUrl, "_blank");
            }
            
        });
    });

});