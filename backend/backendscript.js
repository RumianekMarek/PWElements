jQuery(document).ready(function ($) {
    window.yourFunction = function (toSHow, toHide) {
        const hideElem = ".vc_shortcode-param[data-vc-shortcode-param-name='" + toHide + "']";
        const showElem = ".vc_shortcode-param[data-vc-shortcode-param-name='" + toSHow + "']";
        if ($(showElem).hasClass('vc_dependent-hidden')) {
            $(showElem).removeClass('vc_dependent-hidden')
        }
        $(showElem).removeClass('pwe_dependent-hidden');
        $(hideElem).addClass('pwe_dependent-hidden');
        $(hideElem).find('input').val('');
        $(hideElem).find('select').find('option[selected="selected"]').removeAttr('selected');
    };

    window.hideEmptyElem = function () {
        $('.pwe_dependent-hidden').each(function () {
            if ($(this).find('input').val() != '') {
                $(this).removeClass('pwe_dependent-hidden');
            }
        });
    }
    
    //     // setTimeout(function () {
    //     //     $('.vc_control-btn-edit[title="Edit PWE Elements"]').on('click', function () {
    //     //         setTimeout(function () {
    //     //             console.log($('.vc_shortcode-param[data-vc-shortcode-param-name$="hidden"]'));
    //     //             $('.vc_shortcode-param[data-vc-shortcode-param-name$="hidden"]').each(function () {
    //     //                 if ($(this).find('input').val() != '') {
    //     //                     const colorHex = ".vc_shortcode-param[data-vc-shortcode-param-name='" + $(this).attr('data-vc-shortcode-param-name') + "']";
    //     //                     const ColorPalet = str_replace('_manual_hidden', '', colorHex);
    //     //                     $(colorHex).css('display', 'flex');
    //     //                     $(ColorPalet).css('display', 'none');
    //     //                 }
    //     //             });
    //     //         }, 1000);
    //     //     });
    //     // }, 1000);

});

// Change the display of fields depending on the selected selector (media-gallery.php)
document.addEventListener("DOMContentLoaded", function() {
    const mediaGalleryObserver = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            mutation.addedNodes.forEach(function(addedNode) {
                if (addedNode.nodeType === 1) {
                    handleMediaGalleryChange();
                }
            });
        });
    });

    function handleMediaGalleryChange() {
        const mediaGallerySelect = document.querySelector('select.flex');
        if (mediaGallerySelect) {
            const mediaGalleryHeightTextfields = document.querySelectorAll('.thumbnails_height_flex');
            const mediaGalleryWidthTextfields = document.querySelectorAll('.thumbnails_width_columns');
            
            const toggleTextfields = () => {
                const isFlex = mediaGallerySelect.value === "flex";
                mediaGalleryHeightTextfields.forEach(textfield => textfield.style.display = isFlex ? "block" : "none");
                mediaGalleryWidthTextfields.forEach(textfield => textfield.style.display = isFlex ? "none" : "block");
            };

            toggleTextfields();
            mediaGallerySelect.addEventListener("change", toggleTextfields);
        }
    }

    // Start observing changes to the document
    mediaGalleryObserver.observe(document.body, {
        childList: true,
        subtree: true
    });
});





