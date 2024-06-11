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
        const mediaGallerySelects = document.querySelectorAll('select.flex, select.columns, select.grid, select.carousel, select.slider');
        
        if (mediaGallerySelects.length) {
            const mediaGalleryHeightTextfields = document.querySelectorAll('.thumbnails_height_flex');
            const mediaGalleryWidthTextfields = document.querySelectorAll('.thumbnails_width_columns');
            
            const toggleTextfields = (mediaGallerySelect) => {
                const isFlex = mediaGallerySelect.classList.contains("flex") && mediaGallerySelect.value === "flex";
                const isColumns = mediaGallerySelect.classList.contains("columns") && mediaGallerySelect.value === "columns";
                const isGrid = mediaGallerySelect.classList.contains("grid") && mediaGallerySelect.value === "grid";
                const isCarousel = mediaGallerySelect.classList.contains("carousel") && mediaGallerySelect.value === "carousel";
                
                if (isFlex) {
                    mediaGalleryHeightTextfields.forEach(textfield => textfield.style.display = "block");
                    mediaGalleryWidthTextfields.forEach(textfield => textfield.style.display = "none");
                } else if (isColumns || isGrid || isCarousel) {
                    mediaGalleryHeightTextfields.forEach(textfield => textfield.style.display = "none");
                    mediaGalleryWidthTextfields.forEach(textfield => textfield.style.display = "block");
                } else {
                    mediaGalleryHeightTextfields.forEach(textfield => textfield.style.display = "none");
                    mediaGalleryWidthTextfields.forEach(textfield => textfield.style.display = "none");
                }
            };

            mediaGallerySelects.forEach(select => {
                toggleTextfields(select);
                select.addEventListener("change", () => toggleTextfields(select));
            });
        }
    }

    // Start observing changes to the document
    mediaGalleryObserver.observe(document.body, {
        childList: true,
        subtree: true
    });

    // Initial call to handle existing elements
    handleMediaGalleryChange();
});







