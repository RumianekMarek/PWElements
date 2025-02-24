window.speakersData = speakersData.data || {};
jQuery(document).ready(function($){
//   console.log(speakersData);

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
                            // console.log(speakers);
        var overlay = $("<div>").addClass("custom-modal-overlay");

        var modal = $("<div>").addClass("custom-modal visible");

        var modalContent = "";
        $(speakers).each(function(index, speaker) {
        console.log(speaker);
            modalContent += `<div class="modal-speaker">
                ${ speaker.url ? `<img src="${speaker.url}" alt="${speaker.name}">` : "" }
                <h2>${speaker.name}</h2>
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
});