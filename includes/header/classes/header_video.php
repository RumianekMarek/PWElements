<?php

$text_color = self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'white');
$btn_text_color = self::findColor($atts['btn_text_color_manual_hidden'], $atts['btn_text_color'], 'white');
$btn_color = self::findColor($atts['btn_color_manual_hidden'], $atts['btn_color'], self::$main2_color);
$btn_border = '1px solid ' . self::findColor($atts['btn_color_manual_hidden'], $atts['btn_color'], 'black');
$darker_btn_color = self::adjustBrightness($btn_color, -20);

$output .= '
<style>
    .pwelement_'. $el_id .' .pwe-header-wrapper {
        position: relative;
        max-width: 100%;
        justify-content: center;
        align-items: center;
    }
    .pwelement_'. $el_id .' .pwe-header-column {
        max-width: 1200px;
        width: 100%;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        justify-content: left;
    }
    .pwelement_'. $el_id .' .pwe-header-logo {
        max-width: '. $pwe_header_logo_width .'px !important;
    }
    .pwelement_'. $el_id .' .pwe-header-text {
        padding: 0 !important;
    }
    .pwelement_'. $el_id .' .pwe-header-text :is(h1, h2, h3) {
        color: '. $text_color .';
        text-align: start;
        margin: 0;
    }
    .pwelement_'. $el_id .' .pwe-header-text h1 {
        text-transform: uppercase;
        font-size: 30px;
        font-weight: 500 !important;
        max-width: 600px;
        padding-top: 24px;
    }
    .pwelement_'. $el_id .' .pwe-header-text h2 {
        text-transform: lowercase;
        margin-top: 24px;
        font-size: 28px;
    }
    .pwelement_'. $el_id .' .pwe-header-text h3 {
        text-transform: uppercase;
        font-size: 30px;
        padding: 6px 8px;
    }
    .pwelement_'. $el_id .' .pwe-header-text p {
        color: '. $text_color .';
        display: none;
    }
    .pwelement_'. $el_id .' .pwe-header-edition {
        background-color: white;
    }
    .pwelement_'. $el_id .' .pwe-header-edition span {
        color: black;
    }
    .pwelement_'. $el_id .' .pwe-header-bottom {
        display: flex;
        justify-content: start;
        align-items: center;
        padding-top: 24px;
    }
    .pwelement_'. $el_id .' .pwe-header-bottom .header-button {
        width: 40%;
    }
    .pwelement_'. $el_id .' .pwe-header .pwe-btn-container {
        position: relative;
        width: 300px;
        height: 60px;
        padding: 0;
    }
    .pwelement_'. $el_id .' .pwe-header .pwe-btn {
        background-color: '. $btn_color .' !important;
        color: '. $btn_text_color .' !important;
        border: '. $btn_color .' !important;
        width: 100%;
        height: 100%;
        transform: scale(1) !important;
        transition: .3s ease;
        font-size: 16px;
        font-weight: 600;
        padding: 6px 18px !important;
        letter-spacing: 0.1em;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-transform: uppercase;
    }
    .pwelement_'. $el_id .' .pwe-header .pwe-btn-container .btn-small-text {
        font-size: 10px;
    }
    .pwelement_'. $el_id .' .pwe-header .pwe-btn-container .btn-angle-right {
        color: '. $btn_text_color .';
        position: absolute;
        right: 25px;
        top: -30%;
        height: 35px;
        font-size: 72px;
        transition: .3s ease;
    }
    .pwelement_'. $el_id .' .pwe-header .pwe-btn-container:hover .btn-angle-right {
        right: 20px;
    }
    .pwelement_'. $el_id .' .pwe-header .pwe-btn:hover {
        color: '. $btn_text_color .';
        background-color: '. $darker_btn_color .'!important;
        border: 1px solid '. $darker_btn_color .'!important;
    }
    .pwelement_'. $el_id .' .pwe-header .video-background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: -1; /* Umieszczamy wideo za innymi elementami */
        pointer-events: none; /* Blokujemy interakcje z wideo */
    }

    /* Dopasowanie wideo do całego tła */
    .pwelement_'. $el_id .' .pwe-header .video-background iframe {
        position: absolute;
        top: -36vh;
        left: 0;
        width: 100vw;
        height: 160vh;
        object-fit: cover;
        z-index: -1; /* Wideo w tle za elementami */
        pointer-events: none; /* Brak interakcji z wideo */
    }

    /* Kontener na całą zawartość */
    .pwelement_'. $el_id .' .pwe-header .pwe-header-container {
        position: relative;
        width: 100%;
        height: 80vh;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }

    .pwelement_'. $el_id .' .pwe-header .pwe-header-wrapper {
        position: relative;
        z-index: 1; /* Ustawia elementy nad wideo */
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        padding: 0 20px;
        min-height: 80vh;
    }
    .pwelement_'. $el_id .' .pwe-header-column-container {
        max-width: 600px;
        padding: 36px;
        background-color: rgb(25 25 25 / 80%);
        border-radius: 35px;
        min-height: 50vh;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
    }
    .pwelement_'. $el_id .' .video-background video {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 100%;
        height: 100%;
        object-fit: cover; /* Sprawia, że wideo jest skalowane bez zniekształceń */
        transform: translate(-50%, -50%);
    }
    @media(max-width:1350px){
        .pwelement_'. $el_id .' .pwe-header .video-background iframe {
            width: 100vw;
            height: 100vh;
            top: -9vh;
        }
    }
    @media(max-width: 960px) {
        .pwelement_'. $el_id .' .video-background {
            display:none !important;
        }
        .pwelement_'. $el_id .' .pwe-header .pwe-header-container {
            height: auto;
        }
        .pwelement_'. $el_id .' .pwe-header-column-container {
            padding: 0;
            background-color: inherit;
            min-height: auto;
            margin: 0 auto;
        }
        .pwelement_'. $el_id .' .pwe-header .pwe-header-wrapper {
            min-height: auto;
            padding: 0;
        }
        .pwelement_'. $el_id .' .pwe-header-background {
            background-image: url("/doc/header_mobile.webp") !important;
            position: relative;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        .pwelement_'. $el_id .' .pwe-bg-image1,
        .pwelement_'. $el_id .' .pwe-bg-image2,
        .pwelement_'. $el_id .' .pwe-bg-image3 {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0;
            transition: opacity 2s ease-in-out;
            z-index: 1 !important;
        }
        .pwelement_'. $el_id .' .pwe-bg-image1 {
            background-image: url("/doc/header_mobile.webp");
            z-index: 1;
        }
        .pwelement_'. $el_id .' .pwe-bg-image2 {
            background-image: url("/wp-content/plugins/PWElements/media/bg_mobile_2.webp");
            z-index: 2;
        }
        .pwelement_'. $el_id .' .pwe-bg-image3 {
            background-image: url("/wp-content/plugins/PWElements/media/bg_mobile_3.webp");
            z-index: 3;
        }
        .pwelement_'. $el_id .' .pwe-header-background .visible {
            opacity: 1;
        }
        .pwelement_'. $el_id .' .pwe-header-main-content-block,
        .pwelement_'. $el_id .' .pwe-header-date-block {
            background-color: #00000099;
            padding: 18px;
            border-radius: 18px;
        }
        .pwelement_'. $el_id .' .pwe-header-main-content-block {
            max-width: 400px;
            display: flex;
            flex-direction: column-reverse;
            justify-content: center;
            align-items: center;
            text-align: center;
            gap: 18px;
        }
        .pwelement_'. $el_id .' .pwe-header-date-block {
            margin-top: 36px;
        }
        .pwelement_'. $el_id .' .pwe-header-text {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .pwelement_'. $el_id .' .pwe-header-text p {
            display: block;
            margin: 0;
        }
        .pwelement_'. $el_id .' .pwe-header-edition span {
            color: black;
        }
        .pwelement_'. $el_id .' .pwe-header-img-v1-desktop {
            display: none;
        }
        .pwelement_'. $el_id .' .pwe-header-img-v1-mobile {
            display: flex;
        }
        .pwe-header-wrapper {
            flex-direction: column;
        }
        .pwelement_'. $el_id .' .pwe-header-column,
        .pwelement_'. $el_id .' .pwe-header-content-column,
        .pwelement_'. $el_id .' .pwe-header-image-column {
            width: 100%;
            max-width: 1200px;
            padding: 0;
            text-align: center;
        }
        .pwelement_'. $el_id .' .pwe-header-content-column {
            padding: 36px 18px;
        }
        .pwelement_'. $el_id .' .pwe-header-bottom {
            flex-direction: column-reverse;
            justify-content: center;
            gap: 18px;
            padding-top: 18px;
        }
        .pwelement_'. $el_id .' .pwe-header-text :is(h1, h2, h3) {
            text-align: center;
            width: auto;
            font-size: 22px;
        }
        .pwelement_'. $el_id .' .pwe-header-text h1 {
            padding-top: 0;
        }
        .pwelement_'. $el_id .' .pwe-header-text h2 {
            margin-top: 0;
        }
        .pwelement_'. $el_id .' .pwe-header-text h3 {
            margin-top: 10px;
        }
        .pwelement_'. $el_id .' .pwe-header-title {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .pwelement_'. $el_id .' .pwe-header-edition {
            width: fit-content;
        }
        .pwelement_'. $el_id .' .pwe-header-content-column {
            width: 100%;
        }
        .pwelement_'. $el_id .' .pwe-header-image-column {
            width: 100%;
        }
        .pwelement_'. $el_id .' .pwe-header-bottom .pwe-association {
            width: 100% !important;
        }
        .pwelement_'. $el_id .' .pwe-header-bottom .header-button {
            width: 100% !important;
            max-width: 320px !important;
        }
    }
    @media(max-width: 450px) {
        .pwelement_'. $el_id .' .pwe-header-date-block {
            margin-top: 18px;
        }
    }
</style>

<div id="pweHeader" class="pwe-header">
    <div class="pwe-header-container pwe-header-background" style="background-image: url('. $background_header .');">

        <div class="pwe-bg-image1 pwe-bg-image"></div>
        <div class="pwe-bg-image2 pwe-bg-image"></div>
        <div class="pwe-bg-image3 pwe-bg-image"></div>
        
        <div class="pwe-header-wrapper">

            <div class="pwe-header-column pwe-header-content-column">
                <div class="pwe-header-column-container">

                    <div class="pwe-header-text">
                        <div class="pwe-header-main-content-block">
                            <img class="pwe-header-logo" src="'. $logo_url .'" alt="logo-'. $trade_fair_name .'">
                            <div class="pwe-header-title">
                                <h1>'. $trade_fair_desc .'</h1>
                                <h3 class="pwe-header-edition"><span>'. $trade_fair_edition .'</span></h3>
                            </div>
                        </div>
                        <div class="pwe-header-date-block">
                            <h2>'. $trade_fair_date .'</h2>
                            <p>'. self::languageChecker('Warszawa, Polska', 'Warsaw, Poland') .'</p>
                        </div>
                    </div>

                    <div class="pwe-header-bottom">
                        <div id="pweBtnRegistration" class="pwe-btn-container header-button">
                            <a class="pwe-link pwe-btn" href="'. $pwe_header_register_button_link .'" alt="'. self::languageChecker('link do rejestracji', 'link to registration') .'">
                                '. self::languageChecker('Zarejestruj się', 'Register') .'
                                <span class="btn-small-text" style="display: block; font-weight: 300;">
                                    '. self::languageChecker('Odbierz darmowy bilet', 'Get a free ticket') .'
                                </span>
                            </a>
                            <span class="btn-angle-right">&#8250;</span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="video-background">
                <video autoplay="" muted="" loop="" preload="auto" class="bg-video" src="/doc/header.mp4"></video>
            </div>

        </div>
    </div>
</div>';