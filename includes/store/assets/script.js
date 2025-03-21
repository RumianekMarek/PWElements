const tradeFairName = store_js.trade_fair_name;
const fairs_array = {
    edition_1: [
        "mr.glasstec.pl", "bathceramicsexpo.com", "warsawstone.com", "smarthomeexpo.pl",
        "cleantechexpo.pl", "worldofbuildexpo.com", "safetyrescueexpo.com", "filtratecexpo.com",
        "medivisionforum.com", "automechanicawarsaw.com", "futureenergyweekpoland.com", "labotec.pl",
        "aluminiumtechexpo.com", "industrialbuildingexpo.pl", "cybersecurityexpo.pl", "chemtecpoland.com",
        "pneumaticswarsaw.com", "lasertechnicapoland.com", "isoltexexpo.com", "coldtechpoland.com",
        "coiltechexpo.com", "funeralexpo.pl", "pharmacyexpopoland.com", "polandsustainabilityexpo.com",
        "warsawoptiexpo.com", "coffeeeuropeexpo.com", "hairbarberweekpoland.com", "warsawwindowexpo.com",
        "glasstechpoland.com", "valvespumpsexpo.com", "grindtechexpo.com", "concreteexpo.pl",
        "fastechexpo.com", "cosmopharmpack.com", "aiindustryexpo.com", "worldofhydrogenexpo.com",
        "solidsexpopoland.com", "emobilityexpo.pl", "photonicsexpo.pl", "decarbonisationexpo.com",
        "warsawgardentech.com", "lightexpo.pl", "agrofarmaexpo.com", "veterinaryexpopoland.com",
        "globalfoodexpo.pl", "warsawfleetexpo.com", "waterexpopoland.com", "autotuningshow.com",
        "warsawliftexpo.com", "medinnovationsexpo.com", "huntingexpo.pl", "forumwarzywa.com",
        "biurotexexpo.com", "lingerietrends.pl", "warsawshopexpo.com"
    ],
    edition_2: [
        "warsawmetaltech.pl", "warsawplastexpo.com", "forumbhp.com", "weldexpopoland.com",
        "warsawprinttech.com", "heatingtechexpo.com", "recyclingexpo.pl", "warsawsweettech.com",
        "wodkantech.com", "gastroquickservice.com", "bioagropolska.com", "poultrypoland.com",
        "electroinstalexpo.com", "polandcoatings.com", "warsawsecurityexpo.com", "warsawmedicalexpo.com",
        "facadeexpo.pl", "roofexpo.pl", "fruitpolandexpo.com", "packagingpoland.pl",
        "intralogisticapoland.com", "warsawtoys.com", "esteticaexpo.com", "furnitechexpo.pl",
        "furniturecontractexpo.com", "batteryforumpoland.com", "floorexpo.pl", "door-tec.pl",
        "electronics-show.com", "winewarsawexpo.com", "beerwarsawexpo.com", "boattechnica.com",
        "automotive-expo.eu", "buildoutdoorexpo.com", "warsawtoolsshow.com", "warsawconstructionexpo.com",
        "foodtechexpo.pl", "labelingtechpoland.com", "woodwarsawexpo.com", "automaticaexpo.com",
        "targirehabilitacja.pl", "tubetechnicpoland.com", "wiretechpoland.com", "maintenancepoland.com",
        "controldrivespoland.com", "roboticswarsaw.com", "compositepoland.com"
    ],
    edition_3: [
        "warsawpack.pl", "industryweek.pl", "dentalmedicashow.pl", "warsawgardenexpo.com",
        "boatshow.pl", "campercaravanshow.com", "bioexpo.pl", "warsawfoodexpo.pl",
        "fasttextile.com", "centralnetargirolnicze.com", "motorcycleshow.pl", "mttsl.pl",
        "warsawgiftshow.com", "warsawbusexpo.eu", "eurogastro.com.pl", "remadays.com",
        "warsawhomefurniture.com", "warsawbuild.eu", "warsawhomekitchen.com", "warsawhomelight.com",
        "warsawhometextile.com", "warsawhomebathroom.com", "etradeshow.pl", "franczyzaexpo.pl",
        "worldhotel.pl", "beautydays.pl", "solarenergyexpo.com", "warsawhvacexpo.com",
        "warsawhome.eu"
    ],
    edition_b2c: [
        "ttwarsaw.pl", "fiwe.pl", "animalsdays.eu", "warsawmotorshow.com", "oldtimerwarsaw.com"
    ]
};

document.addEventListener('DOMContentLoaded', function() {
    const elImages = document.querySelectorAll(".pwe-store__featured-image");
    const pweMenu = document.querySelector("#pweMenu");
    const mainSection = document.querySelector('.pwe-store__main-section');

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
            categoryActive.style.display = "block";

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
        // Remove all query parameters
        url.search = '';
        // Remove parameters
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

                const fairsContainer = document.querySelector(".pwe-store__fairs");
                fairsContainer.style.display = "flex";
                setTimeout(() => {
                    fairsContainer.style.opacity = "1";
                }, "500");
                
                // Listen for event in search box
                const searchInput = document.querySelector(".pwe-store__fairs-search-input");
                searchInput.addEventListener("input", function () {
                    const searchTerm = searchInput.value.toLowerCase();

                    const allTiles = document.querySelectorAll(".pwe-store__fairs-item");
                    allTiles.forEach(item => {
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

                const allTiles = document.querySelectorAll(".pwe-store__fairs-item");
                allTiles.forEach(item => {
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

    const sortingButtons = document.querySelectorAll(".pwe-store__sorting-item");
    // Iterujemy po każdym przycisku i dodajemy nasłuchiwanie na kliknięcie
    sortingButtons.forEach(button => {
        button.addEventListener("click", function() {
            // document.querySelector(".pwe-store__main-section").style.display = "none";

            // Pobieramy ID klikniętego przycisku
            const buttonId = this.id;

            // Usuwamy klasę 'active' ze wszystkich przycisków
            sortingButtons.forEach(b => b.classList.remove('active'));

            // Dodajemy klasę 'active' do klikniętego przycisku
            this.classList.add('active');

            // Pobieramy wszystkie elementy z klasą 'pwe-store__section'
            const elements = document.querySelectorAll('.pwe-store__section');

            // Usuwamy klasę 'active' ze wszystkich elementów
            elements.forEach(e => e.classList.remove('active'));

            // Iterujemy po wszystkich elementach i sprawdzamy ich ID
            elements.forEach(element => {
                // Jeśli ID elementu zawiera ID przycisku, dodajemy klasę 'active'
                if (element.id.includes(buttonId)) {
                    element.classList.add('active');
                }
            });


            const mainSectioText = document.querySelectorAll('.pwe-store__main-section-text');
            mainSectioText.forEach(text => {
                // Jeśli ID elementu zawiera ID przycisku, dodajemy klasę 'active'
                if (text.className.includes(buttonId)) {
                    text.style.display = "block";
                } else {
                    text.style.display = "none";
                }
            });


            // Pobieramy wszystkie elementy z klasą 'pwe-store__section-hide'
            const hideElements = document.querySelectorAll('.pwe-store__section-hide');
            // Usuwamy klasę 'active' ze wszystkich elementów
            hideElements.forEach(e => e.style.display = "none");
            // Iterujemy po wszystkich elementach i sprawdzamy ich ID
            hideElements.forEach(element => {
                // Jeśli ID elementu zawiera ID przycisku, dodajemy klasę 'active'
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

            // Wywołanie funkcji
            removeURLParams();
        });
    });

    const arrowBack = document.querySelectorAll(".pwe-store__category-header-arrow");
    arrowBack.forEach(button => {
        button.addEventListener("click", function (event) {
            event.preventDefault();
    
            // Pokaż sekcję główną
            mainSection.style.display = "block";
            // Zidentyfikuj odpowiednią sekcję do pokazania na podstawie aktywnego elementu
            
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
    

});