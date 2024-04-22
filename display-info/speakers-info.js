jQuery(function ($) {
    $('.speakers-bio').on('click', function (event) {
        $('.no-touch').css("overflow", "hidden");
        element = $(event.target).data("target");

        const modalMainDiv = $('<div>').addClass('info-modal').attr('id', 'info-modal');

        const modalDiv = $('<div>').addClass('speaker');

        if (speakers[element].speaker_bio.length < 1000) {
            $(modalDiv).css('max-width', '800px');
            console.log('1');
        } else if (speakers[element].speaker_bio.length >= 1000 && speakers[element].speaker_bio.length <= 2000) {
            $(modalDiv).css('max-width', '1000px');
            console.log('2');
        } else if (speakers[element].speaker_bio.length > 2000) {
            $(modalDiv).css('max-width', '1200px');
            console.log('3');
        }


        const modalImage = $('<img>').addClass('custom-speaker-modal-img text-centered').attr('src', speakers[element].speaker_image).css({ width: '200px', height: '200px' });
        const modalName = $('<h3>').addClass('speaker-name text-centered').text(speakers[element].speaker_name);
        const modalBio = $('<p>').addClass('speaker-bio').text(speakers[element].speaker_bio);
        const modalClose = $('<i>').addClass('fa fa-times-circle-o fa-2x fa-fw info-close');

        $(modalMainDiv).append(modalDiv);

        $(modalDiv).append(modalClose);
        $(modalDiv).append(modalImage);
        $(modalDiv).append(modalName);
        $(modalDiv).append(modalBio);
        $('body').append(modalMainDiv);

        $(modalClose).on('click', function (event) {
            $(event.target).parent().parent().remove();
            $('.no-touch').css("overflow", "initial");
        });

        $(modalMainDiv).on('click', function (event) {
            if ($(event.target).is(modalMainDiv)) {
                $(event.target).remove();
                $('.no-touch').css("overflow", "initial");
            }
        });
    });
});