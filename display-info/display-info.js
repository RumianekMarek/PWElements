jQuery(function ($) {
    $(".open-desc").click(function (event) {
        let targetElement = '';
        if ($(event.target.parentElement).hasClass('text-container')) {
            targetElement = $(event.target.parentElement).find(".inside-text");
            $(event.target.parentElement.parentElement).find(".open-desc i").toggleClass("rotated");
        } else if ($(event.target.parentElement).hasClass('open-desc')) {
            targetElement = $(event.target.parentElement.parentElement).find(".inside-text");
            $(event.target.parentElement.parentElement).find(".open-desc i").toggleClass("rotated");
        }
        let targetHeight = 0;
        $(targetElement).children().each(function () {
            targetHeight += $(this).outerHeight() + 10;
        });
        console.log(targetHeight);
        if (targetElement.css('max-height') === '120px') {
            targetElement.css('max-height', targetHeight + 'px');
        } else {
            targetElement.css('max-height', '120px');
        }
    });

    const allLecturers = document.querySelectorAll('.chevron-slide .lecturers-bio');
    for (i = 0; i < allLecturers.length; i++) {
        allLecturers[i].addEventListener('click', function (event) {
            const modal = event.target.parentElement.parentElement.querySelector('.info-modal');
            modal.style.display = 'grid';
            $('.no-touch').css("overflow", "hidden");

            modal.querySelector('.info-close').addEventListener('click', function () {
                modal.style.display = 'none';
                $('.no-touch').css("overflow", "initial");
            });
            window.addEventListener('click', function (event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                    $('.no-touch').css("overflow", "initial");
                }
            });
        });
    }

    const descElem = $('.chevron-slide .inside-text');
    ShowMore(descElem);

    $('#stickyButtons .custom-sticky-button-item').on('click', function () {
        const tabId = $('.nav-tabs').find('.active').attr('data-tab-id');
        const descElem = $('#' + tabId + ' .inside-text');
        ShowMore(descElem);
    });

    $('.vc_tta-tab').on('click', function () {
        const tabId = $(this).attr('data-tab-id');
        const descElem = $('#' + tabId + ' .inside-text');
        ShowMore(descElem);
    });

    function ShowMore(targetElement) {
        setTimeout(function () {
            targetElement.each(function () {
                const childrens = $(this).children();
                let childrensHeight = 0;
                for (let i = 0; i < childrens.length; i++) {
                    const child = $(childrens[i]);
                    childrensHeight += child.outerHeight(true);
                }
                if (childrensHeight > 120) {
                    $(childrens).parent().next().show(0);
                }
            })
        }, 200);
    }
});