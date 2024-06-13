<?php

class PWESpeakersSlider {
        
        /**
         * Initializes the slider.
         */
        public function __construct() {
        }

        /**
         * Creates the DOM structure for the slider.
         * 
         * @param int $id_rnd Random ID for the slider element.
         * @param array $media_url Array of media URLs.
         * @param int $min_image Minimum image index.
         * @param int $max_image Maximum image index.
         * @return string The DOM structure as HTML.
         */
        private static function createDOM($id_rnd, $media_url, $min_image, $max_image, $options) {
                
                if ($options[0]['display_items_desktop'] == 1 || $options[0]['display_items_tablet'] == 1 || $options[0]['display_items_mobile'] == 1) {
                        $speaker_max_width_img = (empty($options[0]['max_width_img'])) ? "150px" : $options[0]['max_width_img'];
                }

                $output = '
                <style>
                        #PWESpeakersSlider-'. $id_rnd .' {
                                width: 100%;
                                overflow: hidden;
                                margin: 0 !important;
                                -webkit-touch-callout: none; 
                                -webkit-user-select: none;
                                -khtml-user-select: none;
                                -moz-user-select: none; 
                                -ms-user-select: none; 
                                user-select: none;
                                opacity: 0;
                        }
                        #PWESpeakersSlider-'. $id_rnd .' .slides {
                                display: flex;
                                align-items: start;
                                justify-content: space-between;
                                margin: 0 !important;
                                min-height: 0 !important;
                                min-width: 0 !important;
                                pointer-events: auto;
                        }
                        #PWESpeakersSlider-'. $id_rnd .' .pwe-speaker {
                                padding:0;
                                object-fit: contain !important;
                        }
                        #PWESpeakersSlider-'. $id_rnd .' .pwe-speaker-container{
                                margin: 5px !important;
                                padding: 10px;
                        }
                        #PWESpeakersSlider-'. $id_rnd .' .pwe-speaker-img {
                                max-width: '. $speaker_max_width_img .';
                                background-repeat: no-repeat;
                                background-position: center;
                                background-size: cover;
                        }
                        #PWESpeakersSlider-'. $id_rnd .' .pwe-speaker-name {
                                font-size: 24px;
                        }
                        @keyframes slideAnimation {
                                from {
                                        transform: translateX(100%);
                                }
                                to {
                                        transform: translateX(0);
                                }
                        }
                        #PWESpeakersSlider-'. $id_rnd .' .slides .slide{
                                animation: slideAnimation 0.5s ease-in-out;
                        }
                </style>
                
                <div id="PWESpeakersSlider-'. $id_rnd .'" class="pwe-speakers-slider">
                        <div class="slides">';
                        
                        for ($i = $min_image; $i < ($max_image); $i++) {
                                if($i<0){
                                        $elNumber = count($media_url) + $i;
                                        $imageStyles = "background-image:url('".$media_url[$elNumber]['img']."');";
                                } elseif($i>=0 && $i<(count($media_url))){
                                        $elNumber = $i;
                                        $imageStyles = "background-image:url('".$media_url[$elNumber]['img']."');";
                                } elseif($i>=(count($media_url))){
                                        $elNumber = ($i - count($media_url));
                                        $imageStyles = "background-image:url(".$media_url[$elNumber]['img'].");";
                                }

                                if (is_array($media_url[$elNumber]) && !empty($media_url[$elNumber]['img']) && !empty($media_url[$elNumber]['name']) && !empty($media_url[$elNumber]['bio'])){
                                        $speakerUrl = $media_url[$elNumber]['img'];
                                        $speakerName = $media_url[$elNumber]['name'];
                                        $speakerBio = $media_url[$elNumber]['bio'];
                                        preg_match('/\s([A-Z][^\.!?]*[\.!?])/', $speakerBio, $matches);
                                        $firstSentence = isset($matches[1]) ? $matches[1] : '';
                                        $output .= '<div class="pwe-speaker-'. $id_rnd .' pwe-speaker pwe-speaker-container" href="'. $speakerUrl .'">
                                                        <div class="pwe-speaker-thumbnail">
                                                            <div class="pwe-speaker-img" style="'.$imageStyles.'"></div>
                                                        </div> 
                                                        <h5 class="pwe-speaker-name">'. $speakerName .'</h5>
                                                        <p class="pwe-speaker-desc" style="display: none;">'. $speakerBio .'</p>
                                                        <p class="pwe-speaker-first-sentence" style="">'. $firstSentence .'</p>';
                                                        if(!empty($speakerBio)){
                                                            $output .='<button class="pwe-speaker-btn">BIO</button>';
                                                        }
                                        $output .= '</div>';
                                }
                        }

                $output .= '</div></div>';
                return $output;
        }

        /**
         * Generates the necessary JavaScript for the slider functionality.
         * 
         * @param int $id_rnd Random ID for the slider element.
         * @param array $media_url Array of media URLs.
         * @param int $min_image Minimum image index.
         * @param int $slide_speed Slide transition speed in milliseconds.
         * @return string The JavaScript code as HTML.
         */
        private static function generateScript($id_rnd, $media_url, $min_image, $slide_speed, $options) {
                $breakpoint_tablet = str_replace("px", "", $options[0]['breakpoint_tablet']);
                $breakpoint_mobile = str_replace("px", "", $options[0]['breakpoint_mobile']);

                $breakpoint_tablet = (empty($breakpoint_tablet)) ? '768' : $breakpoint_tablet;
                $breakpoint_mobile = (empty($breakpoint_mobile)) ? '420' : $breakpoint_mobile;

                $media_url_count = count($media_url);
                $min_image_adjusted = -$min_image;

                $output = '
                <script>
                        jQuery(function ($) {                         
                                const slider = document.querySelector("#PWESpeakersSlider-'. $id_rnd .'");
                                const slides = slider.querySelector(".slides");
                                const images = slides.querySelectorAll(".pwe-speaker");          

                                let isMouseOver = false;
                                let isDragging = false;
                                
                                let imagesMulti = "";
                                const slidesWidth = slides.clientWidth;
                                
                                if (slidesWidth < '. $breakpoint_mobile .') {
                                        imagesMulti = '. $options[0]['display_items_mobile'] .';
                                } else if (slidesWidth < '. $breakpoint_tablet .') {
                                        imagesMulti = '. $options[0]['display_items_tablet'] .';
                                } else {
                                        imagesMulti = '. $options[0]['display_items_desktop'] .';
                                }
                                
                                if(imagesMulti >=  '. $media_url_count .'){
                                        $("#PWESpeakersSlider-'. $id_rnd .' .slides").each(function(){
                                                $(this).css("justify-content", "center");
                                                if ($(this).children().length > '. $media_url_count .'){
                                                        $(this).children().slice('. $media_url_count .').remove();
                                                };

                                        });
                                        const imageWidth = Math.floor((slidesWidth - imagesMulti * 10) / imagesMulti);
                                        images.forEach((image) => {
                                                image.style.maxWidth = imageWidth + "px";
                                                image.style.minWidth = imageWidth + "px";
                                        });
                                } else {
                                        const imageWidth = Math.floor((slidesWidth - imagesMulti * 10) / imagesMulti);
                                        images.forEach((image) => {
                                                image.style.minWidth = imageWidth + "px";
                                                image.style.maxWidth = imageWidth + "px";
                                        });
                                        const slidesTransform =  (imageWidth + 10) * '. $min_image_adjusted .';

                                        slides.style.transform = `translateX(-${slidesTransform}px)`;

                                        function nextSlide() {
                                                slides.querySelectorAll("#PWESpeakersSlider-'. $id_rnd .' .pwe-speaker-container").forEach(function(image){
                                                        image.classList.add("slide");
                                                })
                                                slides.firstChild.classList.add("first-slide");
                                                const firstSlide = slides.querySelector(".first-slide");  

                                                slides.appendChild(firstSlide);

                                                firstSlide.classList.remove("first-slide");

                                                setTimeout(function() {
                                                        slides.querySelectorAll("#PWESpeakersSlider-'. $id_rnd .' .pwe-speaker-container").forEach(function(image){
                                                                image.classList.remove("slide");
                                                        })
                                                }, '. ($slide_speed / 2) .');
                                        }                       

                                        slider.addEventListener("mousemove", function() {
                                                isMouseOver = true;
                                        });
                                        
                                        slider.addEventListener("mouseleave", function() {
                                                isMouseOver = false;
                                        });

                                        let isDown = false;
                                        let startX;
                                        let startY;
                                        let slideMove = 0;

                                        slider.addEventListener("mousedown", (e) => {
                                                isDown = true;
                                                slider.classList.add("active");
                                                startX = e.pageX - slider.offsetLeft;
                                        });

                                        slider.addEventListener("mouseleave", () => {
                                                isDown = false;
                                                slider.classList.remove("active");
                                                resetSlider(slideMove);
                                                slideMove = 0;
                                        });

                                        slider.addEventListener("mouseup", () => {
                                                isDown = false;
                                                slider.classList.remove("active");
                                                resetSlider(slideMove);
                                                slideMove = 0;
                                        });

                                        slider.addEventListener("mousemove", (e) => {
                                                if (!isDown) return;
                                                e.preventDefault();
                                                let preventDefaultNextTime = true;

                                                $(e.target).parent().on("click", function(event) {
                                                        if (preventDefaultNextTime) {
                                                                event.preventDefault();
                                                                preventDefaultNextTime = true;

                                                                setTimeout(() => {
                                                                        preventDefaultNextTime = false;
                                                                }, 200);
                                                        }
                                                });
                                                const x = e.pageX - slider.offsetLeft;
                                                const walk = (x - startX);
                                                const transformWalk = slidesTransform - walk;
                                                slides.style.transform = `translateX(-${transformWalk}px)`;
                                                slideMove = (walk / imageWidth);
                                        });

                                        // Kod obsługujący przesuwanie dotykiem na urządzeniach mobilnych

                                        slider.addEventListener("touchstart", (e) => {
                                                isDown = true;
                                                slider.classList.add("active");
                                                startX = e.touches[0].pageX - slider.offsetLeft;
                                                startY = e.touches[0].pageY;
                                        });

                                        slider.addEventListener("touchend", () => {
                                                isDown = false;
                                                slider.classList.remove("active");
                                                resetSlider(slideMove);
                                                slideMove = 0;
                                        });

                                        slider.addEventListener("touchmove", (e) => {
                                                if (!isDown) return;
                                        
                                                if (!e.cancelable) return; // Dodajemy ten warunek, aby uniknąć błędu
                                        
                                                const x = e.touches[0].pageX - slider.offsetLeft;
                                                const y = e.touches[0].pageY;
                                                const walk = (x - startX);
                                                const verticalDiff = Math.abs(y - startY);
                                        
                                                if (Math.abs(walk) > verticalDiff) { // Tylko jeśli ruch poziomy jest większy niż pionowy
                                                e.preventDefault();
                                                const transformWalk = slidesTransform - walk;
                                                slides.style.transform = `translateX(-${transformWalk}px)`;
                                                slideMove = (walk / imageWidth);
                                                }
                                        });
                                        
                                        const resetSlider = (slideWalk) => {
                                                const slidesMove = Math.abs(Math.round(slideWalk));
                                                for(i = 0; i < slidesMove; i++){
                                                        if(slideWalk > 0){
                                                                slides.lastChild.classList.add("last-slide");
                                                                const lastSlide = slides.querySelector(".last-slide");  
                                                                slides.insertBefore(lastSlide, slides.firstChild);
                                                                lastSlide.classList.remove("last-slide");
                                                        } else {
                                                                slides.firstChild.classList.add("first-slide");
                                                                const firstSlide = slides.querySelector(".first-slide");  
                                                                slides.appendChild(firstSlide);
                                                                firstSlide.classList.remove("first-slide");
                                                        }
                                                }
                                                slides.style.transform = `translateX(-${slidesTransform}px)`;
                                        }
                                        setInterval(function() {
                                                if(!isMouseOver) { 
                                                        nextSlide()
                                                }
                                        }, '. $slide_speed .');
                                }

                                if (slider) {
                                        slider.style.opacity = 1;
                                        slider.style.transition = "opacity 0.3s ease";
                                }
                        });                 
                </script>'; 
                
                return $output;
        }

        /**
         * Prepares and returns the HTML output for the slider.
         * 
         * @param array $media_url_array Array of media URLs or structures containing URLs and additional data.
         * @param int $slide_speed Speed of the slide transition.
         * @return string The HTML output for the slider.
         */
        public static function sliderOutput($media_url, $slide_speed = 3000, $info_speakers_options) {
                $info_speakers_options_json = json_encode($info_speakers_options);
                $options = json_decode($info_speakers_options_json, true);

                /*Random "id" if there is more than one element on page*/  
                $id_rnd = rand(10000, 99999);
                
                /*Counting min elements for the gallery slider*/   
                if(count($media_url) > 10){
                        $max_image = floor(count($media_url) * 1.5);
                        $min_image = floor(-count($media_url) / 2);
                } else {
                        $max_image = count($media_url) * 2; 
                        $min_image = -count($media_url);
                }
                
                $output = self::createDOM($id_rnd, $media_url, $min_image, $max_image, $options);
                
                $output .= self::generateScript($id_rnd, $media_url, $min_image, $slide_speed, $options);
                
                return $output;
        }
} 
