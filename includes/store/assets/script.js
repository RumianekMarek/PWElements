const tradeFairName = store_js.trade_fair_name;
const trade_fair_groups = store_js.trade_fair_groups;

let edition_1 = [];
let edition_2 = [];
let edition_3 = [];
let edition_b2c = [];

trade_fair_groups.forEach(group => {
    if (group.fair_group === "gr1") {
        edition_1.push(group.fair_domain);
    }
    if (group.fair_group === "gr2") {
        edition_2.push(group.fair_domain);
    }
    if (group.fair_group === "gr3") {
        edition_3.push(group.fair_domain);
    }
    if (group.fair_group === "b2c") {
        edition_b2c.push(group.fair_domain);
    }
});

const fairs_array = {
    edition_1,
    edition_2,
    edition_3,
    edition_b2c
};

document.addEventListener('DOMContentLoaded', function() {
    const pweStore = document.querySelector(".pwe-store");
    const elImages = document.querySelectorAll(".pwe-store__featured-image");
    const pweMenu = document.querySelector("#pweMenu");
    const mainSection = document.querySelector('.pwe-store__main-section');

    if (pweStore) {

        function updateImagesPosition() {
            const viewportHeight = window.innerHeight;

            elImages.forEach(elImage => {
                const elContainer = elImage.parentElement;
                const containerRect = elContainer.getBoundingClientRect();

                if (pweMenu) {
                    if (containerRect.top >= pweMenu.offsetHeight) {
                        elImage.classList.remove("sticky");
                        elImage.style.top = "0px";
                    } else if (containerRect.top < pweMenu.offsetHeight && containerRect.bottom > viewportHeight) {
                        elImage.classList.add("sticky");
                        elImage.style.top = pweMenu.offsetHeight + 50 + "px";
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

                const categoryActive = document.querySelector('.pwe-store__section-hide:has(.pwe-store__featured-service.active)');
                if (categoryActive) {
                    categoryActive.style.display = "block";
                }
                
                const categoryHeaders = document.querySelectorAll('.pwe-store__section-hide:has(.pwe-store__featured-service) .pwe-store__category-header');
                const categoryHeadersActive = document.querySelectorAll('.pwe-store__section-hide:has(.pwe-store__featured-service.active) .pwe-store__category-header');
                // Hide the main section and show the category header
                showCategoryHeader(mainSection, categoryHeaders, categoryHeadersActive);

                // Scroll to top of page
                scrollToTop();
            });
        });

        // Handling parameter in URL
        const urlParams = new URLSearchParams(window.location.search);
        const featuredServiceParam = urlParams.get('featured-service');
        if (featuredServiceParam) {
            showFeaturedService(featuredServiceParam);

            const categoryHeaders = document.querySelectorAll('.pwe-store__section-hide:has(.pwe-store__featured-service) .pwe-store__category-header');
            const categoryHeadersActive = document.querySelectorAll(`.pwe-store__section-hide:has(.pwe-store__featured-service.active) .pwe-store__category-header`);
            // Hide the main section and show the category header
            showCategoryHeader(mainSection, categoryHeaders, categoryHeadersActive);

            // Scroll to top of page
            scrollToTop();
        }

        // Scroll to top of page
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        }

        function showFeaturedService(featuredId) {
            // Hide all pwe-store__featured-service sections
            const featuredServices = document.querySelectorAll('.pwe-store__featured-service');
            featuredServices.forEach(service => service.classList.remove("active"));

            // Show the appropriate section
            const featuredService = document.getElementById(featuredId);
            if (featuredService) {
                featuredService.classList.add("active");
            }
        }

        // Hide the main section and show the category header
        function showCategoryHeader(mainSection, categoryHeaders, categoryHeadersActive) {
            // Hide main section
            mainSection.style.display = "none";
            categoryHeaders.forEach(header => {
                if (header) {
                    // Show the category header
                    header.style.display = "none";
                }
            });
            categoryHeadersActive.forEach(headerActive => {
                if (headerActive) {
                    // Show the category header
                    headerActive.style.display = "flex";
                }
            });
        }

        // Show the main section and hide the category header
        function hideCategoryHeader(mainSection, categoryHeaders) {
            // Show main section
            mainSection.style.display = "block";
            categoryHeaders.forEach(header => {
                if (header) {
                    // Hide the category header
                    header.style.display = "none";
                }
            });
        }

        // Function to remove query parameters from URL
        function removeURLParams() {
            // Get the current URL
            const url = new URL(window.location.href);
            const category = url.searchParams.get('category');

            // Clear all parameters
            url.search = '';

            // If the category existed, add it back
            if (category) {
                url.searchParams.set('category', category);
            }

            // Update url in history without reload
            window.history.replaceState({}, '', url.toString());
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

        // Get domain address
        const currentDomain = window.location.hostname;

        let editionNumber = "";
        if (fairs_array.edition_1.includes(currentDomain)) {
            editionNumber = "1";
        } else if (fairs_array.edition_2.includes(currentDomain)) {
            editionNumber = "2";
        } else if (fairs_array.edition_3.includes(currentDomain)) {
            editionNumber = "3";
        } else if (fairs_array.edition_b2c.includes(currentDomain)) {
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
                
                if (currentDomain === "warsawexpo.eu" || currentDomain === "rfl.warsawexpo.eu") {  

                    if (pweStore) {
                        // Hide pwe-store
                        Array.from(pweStore.children).forEach(child => {
                            child.style.display = "none";
                        });
                    }

                    const fairsContainer = document.querySelector(".pwe-store__fairs");
                    fairsContainer.style.display = "flex";
                    setTimeout(() => {
                        fairsContainer.style.opacity = "1";
                    }, "500");

                    // Return to shop
                    document.querySelector(".pwe-store__fairs-arrow-back").addEventListener("click", function () {
                        // Hide pwe-store
                        Array.from(pweStore.children).forEach(child => {
                            child.style.display = "block";
                        });
                
                        const categoryHeaders = document.querySelectorAll('.pwe-store__section-hide:has(.pwe-store__featured-service) .pwe-store__category-header');
                        // Show the main section and hide the category header
                        hideCategoryHeader(mainSection, categoryHeaders);
                
                        const featuredService = document.querySelectorAll(".pwe-store__featured-service");
                        featuredService.forEach(service => {
                            service.classList.remove('active');
                        });
                        
                        fairsContainer.style.opacity = "0";
                        fairsContainer.style.display = "none";
                
                        removeURLParams();
                    });
                    
                    // Listen for event in search box
                    const searchInput = document.querySelector(".pwe-store__fairs-search-input");
                    searchInput.addEventListener("input", function () {
                        const searchTerm = searchInput.value.toLowerCase();

                        const allTiles = document.querySelectorAll(".pwe-store__fairs-item");
                        allTiles.forEach(item => {
                            const name = item.getAttribute("data-name").toLowerCase();
                            const tooltip = item.getAttribute("data-tooltip").toLowerCase();

                            // If the search text is in the name or description, show the element
                            if (name.includes(searchTerm) || tooltip.includes(searchTerm)) {
                                item.style.display = "block";
                            } else {
                                item.style.display = "none";
                            }
                        });
                    });

                    const allTiles = document.querySelectorAll(".pwe-store__fairs-item");
                    allTiles.forEach(item => {
                        item.addEventListener("click", function () {
                            const selectedDomain = this.getAttribute("data-domain");
                            const selectedEdition = this.getAttribute("data-edition");
                            const selectedName = this.getAttribute("data-name");

                            const redirectUrl = `${baseUrl}?service=${encodeURIComponent(serviceName)}&domain=${encodeURIComponent(selectedDomain)}&pwevent=${encodeURIComponent(selectedName)}&edition=${encodeURIComponent(selectedEdition)}`;
                            
                            // Open in new blank
                            window.open(redirectUrl, "_blank");
                            

                            // Reload page without params
                            window.location.replace(window.location.origin + window.location.pathname);
                        });
                    });

                    // Scroll to top of page
                    scrollToTop();

                } else {
                    const redirectUrl = `${baseUrl}?service=${encodeURIComponent(serviceName)}&domain=${encodeURIComponent(currentDomain)}&pwevent=${encodeURIComponent(tradeFairName)}&edition=${encodeURIComponent(editionNumber)}`;
                    // Open new window
                    window.open(redirectUrl, "_blank");

                    // Reload page without params
                    window.location.replace(window.location.origin + window.location.pathname);
                }
                
            });
        });

        const sortingButtons = document.querySelectorAll(".pwe-store__category-item"); 
        const currentUrl = new URL(window.location.href);
        const categoryParam = currentUrl.searchParams.get("category");
        const mainSectionsText = document.querySelectorAll('.pwe-store__main-section-text');

        // Clicking on the category buttons
        sortingButtons.forEach(button => {
            if (!button.classList.contains("dropdown")) {
                button.addEventListener("click", function() {
                    // Get ID of button
                    const buttonId = this.id;

                    // Update category parameter
                    currentUrl.search = '';
                    currentUrl.searchParams.set('category', buttonId);
                    window.history.pushState({}, '', currentUrl.toString());

                    // Removing the 'active' class from all buttons
                    sortingButtons.forEach(b => b.classList.remove('active'));

                    // Adding 'active' class to clicked button
                    this.classList.add('active');

                    const cardsContainers = document.querySelectorAll('.pwe-store__section');

                    // Removing the 'active' class from all elements
                    cardsContainers.forEach(e => e.classList.remove('active'));

                    // Iterate through all elements and check their IDs
                    cardsContainers.forEach(element => {
                        const category = element.getAttribute('category');
                
                        // If the 'category' attribute is the same as the button ID, we add the 'active' class
                        if (category === buttonId) {
                            element.classList.add('active');
                        }
                    });

                    mainSectionsText.forEach(item => {
                        // Split the className by spaces and check if the exact class is present
                        const classes = item.className.split(' ');
                        
                        // Only display the item if the buttonId matches exactly one of the classes
                        if (classes.indexOf(buttonId) !== -1 && classes.length > 1) {
                            item.style.display = "block";
                        } else {
                            item.style.display = "none";
                        }
                    });

                    const hideElements = document.querySelectorAll('.pwe-store__section-hide');
                    // Remove the 'active' class from all elements
                    hideElements.forEach(e => e.style.display = "none");
                    // Iterate over all elements and check their IDs
                    hideElements.forEach(element => {
                        // If the element ID contains the button ID, add the 'active' class
                        if (element.id.includes(buttonId)) {
                            element.style.display = "block";
                        }
                    });

                    const featuredService = document.querySelectorAll(".pwe-store__featured-service");
                    featuredService.forEach(service => {
                        service.classList.remove('active');
                    });

                    const categoryHeaders = document.querySelectorAll('.pwe-store__section-hide:has(.pwe-store__featured-service) .pwe-store__category-header');
                    // Show the main section and hide the category header
                    hideCategoryHeader(mainSection, categoryHeaders);

                    const categoriesSection = document.querySelector(".pwe-store__anchor");
                    const elementTop = categoriesSection.getBoundingClientRect().top + window.scrollY;

                    window.scrollTo({
                        top: elementTop - 72,
                        behavior: "smooth"
                    });
                    
                });
            }
        });

        // If the button is not active and the URL does not contain category
        if (!categoryParam) {
            const activeButton = Array.from(sortingButtons).find(btn => btn.classList.contains("active"));
        
            if (!activeButton) {
                const firstButton = sortingButtons[0];
                firstButton.classList.add("active");
        
                const firstButtonId = firstButton.id;
                const newUrl = new URL(window.location.href);
                newUrl.searchParams.set("category", firstButtonId);
                window.history.replaceState({}, '', newUrl.toString());
        
                // Trigger a click to load the appropriate category
                firstButton.click();
            } else {
                const newUrl = new URL(window.location.href);
                newUrl.searchParams.set("category", activeButton.id);
                window.history.replaceState({}, '', newUrl.toString());
            }
        }
        
        // If the URL has a category, set the active button and show the correct category
        if (categoryParam) {
            sortingButtons.forEach(btn => {
                btn.classList.remove("active");
                if (btn.id === categoryParam) {
                    btn.classList.add("active");
                    const currentCardsContainer = document.querySelector(`.pwe-store__section[category="${categoryParam}"]`)
                    if (currentCardsContainer) {
                        currentCardsContainer.classList.add("active");
                    }

                    mainSectionsText.forEach(item => {
                        // Split the className by spaces and check if the exact class is present
                        const classes = item.className.split(' ');
                        
                        // Only display the item if the buttonId matches exactly one of the classes
                        if (classes.indexOf(btn.id) !== -1 && classes.length > 1) {
                            item.style.display = "block";
                        } else {
                            item.style.display = "none";
                        }
                    });
                }
            });
        }

        // Back to the shop
        const arrowBack = document.querySelectorAll(".pwe-store__category-header-arrow");
        arrowBack.forEach(button => {
            button.addEventListener("click", function (event) {
                event.preventDefault();
        
                mainSection.style.display = "block";

                const categoryHeaders = document.querySelectorAll('.pwe-store__section-hide:has(.pwe-store__featured-service) .pwe-store__category-header');
                // Show the main section and hide the category header
                hideCategoryHeader(mainSection, categoryHeaders);
        
                const featuredService = document.querySelectorAll(".pwe-store__featured-service");
                featuredService.forEach(service => {
                    service.classList.remove('active');
                });
        
                removeURLParams();
        
                // Scroll to top of page
                scrollToTop();
            });
        });

        // Gallery popup
        let enableScrolling = true;
        window.isDragging = false;
        document.querySelectorAll(".pwe-store__featured-gallery img").forEach((image, index) => {
            image.addEventListener("click", (e) => {

                if (window.isDraggingMedia) {
                    e.preventDefault(); // Block the opening of the modal if there was movement
                    window.isDraggingMedia = false; // Reset the flag after the click is handled
                    return;
                }

                // Find the closest .pwe-store__featured-gallery container
                const galleryContainer = image.closest('.pwe-store__featured-gallery');
                
                // Get all images inside this gallery container
                const imagesArray = Array.from(galleryContainer.querySelectorAll('img'));

                // Create popup
                const popupDiv = document.createElement("div");
                popupDiv.className = "pwe-media-gallery-popup";

                // Left arrow for previous image
                const leftArrow = document.createElement("span");
                leftArrow.innerHTML = "&#10094;"; // HTML entity for left arrow
                leftArrow.className = "pwe-media-gallery-left-arrow pwe-media-gallery-arrow";
                popupDiv.appendChild(leftArrow);

                // Right arrow for next image
                const rightArrow = document.createElement("span");
                rightArrow.innerHTML = "&#10095;"; // HTML entity for right arrow
                rightArrow.className = "pwe-media-gallery-right-arrow pwe-media-gallery-arrow";
                popupDiv.appendChild(rightArrow);
        
                // Close btn
                const closeSpan = document.createElement("span");
                closeSpan.innerHTML = "&times;";
                closeSpan.className = "pwe-media-gallery-close";
                popupDiv.appendChild(closeSpan);
        
                const popupImage = document.createElement("img");
                popupImage.src = image.getAttribute("src");
                popupImage.alt = "Popup Image";
                popupDiv.appendChild(popupImage);
        
                // Add popup to <body>
                document.body.appendChild(popupDiv);
                popupDiv.style.display = "flex";

                disableScroll();
                enableScrolling = false;

                // Function to change image in popup
                let currentIndex = imagesArray.indexOf(image);

                const changeImage = (direction) => {
                    // Applying the fade-out class before changing the image source
                    popupImage.classList.add("fade-out");
                    popupImage.classList.remove("fade-in");

                    setTimeout(() => {
                        currentIndex += direction;

                        if (currentIndex >= imagesArray.length) {
                            currentIndex = 0; // Goes back to the first image
                        } else if (currentIndex < 0) {
                            currentIndex = imagesArray.length - 1; // Goes to the last image
                        }

                        popupImage.src = imagesArray[currentIndex].getAttribute("src");

                        // Remove fade-out class and add fade-in after image source change
                        popupImage.classList.remove("fade-out");
                        popupImage.classList.add("fade-in");
                    }, 100);
                };

                leftArrow.addEventListener("click", () => changeImage(-1));
                rightArrow.addEventListener("click", () => changeImage(1));

                // Remove popup when clicking the close button
                closeSpan.addEventListener("click", () => {
                    popupDiv.remove();
                    enableScroll();
                    enableScrolling = true;
                });

                // Remove popup when clicking outside the image
                popupDiv.addEventListener("click", (event) => {
                    if (event.target === popupDiv) { // Checks if the clicked element is the popupDiv itself
                        popupDiv.remove();
                        enableScroll();
                        enableScrolling = true;
                    }
                });
            });
        });

        // Prevent scrolling on touchmove when enableScrolling is false
        document.body.addEventListener("touchmove", (event) => {
            if (!enableScrolling) {
                event.preventDefault();
            }
        }, { passive: false });

        // Disable page scrolling
        function disableScroll() {
            document.body.style.overflow = "hidden";
            document.documentElement.style.overflow = "hidden";
        }

        // Enable page scrolling
        function enableScroll() {
            document.body.style.overflow = "";
            document.documentElement.style.overflow = "";
        }


        // Clicking on the language change link
        const wpmlLinks = document.querySelectorAll('a:has(img.wpml-ls-flag)');
        wpmlLinks.forEach(link => {
            if (link) {
                link.addEventListener('click', function(event) {
                    // Getting the original link URL
                    let originalUrl = link.href;

                    // Getting all parameters from the current page URL
                    const currentUrlParams = new URLSearchParams(window.location.search);

                    // Adding parameter to original link
                    const url = new URL(originalUrl);
                    currentUrlParams.forEach((value, key) => {
                        url.searchParams.set(key, value);
                    });

                    // Redirect to a new link with added parameters
                    window.location.href = url.toString();

                    event.preventDefault();
                });
            }
        });

        // Create modal
        const packageCards = document.querySelectorAll(".pwe-store__packages-section-hide .pwe-store__service-card");
        packageCards?.forEach(card => {
            card.addEventListener("click", function (event) {
                event.preventDefault();

                const cardAttribute = card.getAttribute("data-featured");
                const selectItem = document.querySelector(`#${cardAttribute}`);

                if (selectItem) {
                    // Placing the selected element in the modal
                    const modalContent = document.querySelector(".pwe-store__modal-content-placeholder");
                    modalContent.innerHTML = "";
                    const clonedItem = selectItem.cloneNode(true);
                    modalContent.appendChild(clonedItem);

                    const modal = document.querySelector("#pweStoreModal");
                    modal.style.display = "flex";

                    clonedItem.id = cardAttribute + "-modal";
                    clonedItem.classList.add("pwe-store__featured-service-modal");
                    clonedItem.style.display = "flex";
                    clonedItem.style.position = "relative";

                    document.querySelector("body").style.setProperty('overflow', 'hidden', 'important');
                }
            });
        });

        const modalContent = document.querySelector(".pwe-store__modal-content");
        const closeBtn = document.querySelector(".pwe-store__modal-close-btn");

        modalContent.addEventListener("scroll", function() {
            const scrollTop = modalContent.scrollTop;
            const offset = 0;

            closeBtn.style.top = `${scrollTop + offset}px`;
        });

        // Closing modal
        const modal = document.getElementById("pweStoreModal");

        closeBtn.addEventListener("click", function () {
            modal.style.display = "none";
            document.querySelector("body").style.removeProperty('overflow');
        });

        // Close the modal by clicking outside it
        window.addEventListener("click", function (event) {
            if (event.target === modal) {
                modal.style.display = "none";
                document.querySelector("body").style.removeProperty('overflow');
            }
        });

    }

});