window.speakersData = speakersData.data || {};
jQuery(document).ready(function($){

    $(".conference_cap__lecture-speaker-btn").each(function() {
        $(this).on("click", function(){
            const lectureId = $(this).closest(".conference_cap__lecture-box").attr("id");
            if (!lectureId || !window.speakersData[lectureId]) return;
            openSpeakersModal(window.speakersData[lectureId]);
        });
    });

    function disableScroll() {
        $("body").css("overflow", "hidden");
        $("html").css("overflow", "hidden");
    }

    function enableScroll() {
        $("body").css("overflow", "");
        $("html").css("overflow", "");
    }

    function openSpeakersModal(speakers) {
        var overlay = $("<div>").addClass("custom-modal-overlay");

        var modal = $("<div>").addClass("custom-modal");

        var modalContent = "";
        $(speakers).each(function(index, speaker) {
            modalContent += `<div class="modal-speaker">
                ${ speaker.url ? `<img src="${speaker.url}" alt="${speaker.name}">` : "" }
                <h2>${speaker.name_html}</h2>
                <p>${speaker.bio}</p>
            </div>`;
            if(index < speakers.length - 1) {
                modalContent += "<hr>";
            }
        });

        modal.html(`<button class="custom-modal-close">&times;</button>
            <div class="custom-modal-content">${modalContent}</div>`);
        overlay.append(modal);
        $("body").append(overlay);

        disableScroll();

        setTimeout(function() {
            modal.addClass("visible");
        }, 10);

        $(".custom-modal-close").on("click", function() {
            overlay.remove();
            enableScroll();
        });



        overlay.on("click", function(e) {
            if(e.target === overlay[0]) {
                overlay.remove();
                enableScroll();
            }
        });
        
    }

    function initializeConferenceNavigation() {
        // Uaktualniony selektor obejmuje oba typy kontenerów
        const confTabs = $(".conference_cap__conf-slug, .konferencja");
        const confImages = $(".conference_cap__conf-slug-img");
        const tabs = $(".conference_cap__conf-slug-navigation-day");
        
        // Przełączanie konferencji po kliknięciu obrazka
        confImages.on("click", function () {
            const parentLink = $(this).closest('a');
        
            const slug = this.id.replace("nav_", "");
            const targetSelector = `#conf_${slug}, #${slug}`;
            const targetContainer = $(targetSelector).first();
            
            if (!targetContainer.length) return;
        
            confTabs.removeClass("active-slug").hide();
            confImages.removeClass("active-slug");
        
            targetContainer.addClass("active-slug").show();
            $(this).addClass("active-slug");
        
            const firstDayButton = targetContainer.find(".conference_cap__conf-slug-navigation-day").first();
            if (firstDayButton.length) {
                firstDayButton.click();
            }
        
            if (parentLink.length === 0) {
                const containerMasthead = document.querySelector('.pwe-menu');
                if (containerMasthead) {
                    targetContainer.get(0).style.scrollMarginTop = containerMasthead.offsetHeight + "px";
                }
                targetContainer.get(0).scrollIntoView({ behavior: "smooth" });
            }
        
        });
        
        
        // Przełączanie dni w wybranej konferencji
        tabs.on("click", function () {
            const parts = this.id.split("_");
            // Zakładamy, że struktura id przycisku dnia to "tab_slug_dzien"
            const selectedConfSlug = parts[1];
            const selectedDay = parts[2];
            const targetId = `content_${selectedConfSlug}_${selectedDay}`;
                        
            // Znalezienie najbliższego kontenera konferencji, który może mieć klasę .conference_cap__conf-slug lub .konferencja
            const currentConf = $(this).closest(".conference_cap__conf-slug, .konferencja");
            
            // Usunięcie klasy active-day ze wszystkich dni w danej konferencji
            currentConf.find(".conference_cap__conf-slug-navigation-day").removeClass("active-day");
            // Dodanie klasy active-day do klikniętego przycisku
            $(this).addClass("active-day");
            
            // Usunięcie klasy active-content z zawartości dni
            currentConf.find(".conference_cap__conf-slug-content").removeClass("active-content");
            
            // Dodanie klasy active-content do docelowej zawartości dnia
            const targetContent = $(`#${targetId}`);
            if (targetContent.length) {
                targetContent.addClass("active-content");
            } 
        });
        
        // Opcjonalnie: ustawienie domyślnego stanu, np. automatyczne kliknięcie pierwszego obrazka
        // if (confImages.length > 0) {
        //     confImages.first().click();
        // }

        const urlParams = new URLSearchParams(window.location.search);
        const confSlug = urlParams.get('konferencja');

        if (confSlug) {
            const targetImage = $(`#nav_${confSlug}`);
            if (targetImage.length) {
                targetImage.click(); 
            }
        }
    }
    

    initializeConferenceNavigation();

});