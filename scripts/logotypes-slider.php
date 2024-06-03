<?php

class PWELogotypesSlider {
    
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
        private static function createDOM($id_rnd, $media_url, $min_image, $max_image) {
                $output = '
                <style>
                        .pwe-element-logotypes-slider {
                                width: 100%;
                                overflow: hidden;
                                margin: 0 !important;
                        }
                        .pwe-element-logotypes-slider .slides {
                                display: flex;
                                align-items: center;
                                justify-content: space-between;
                                margin: 0 !important;
                                min-height: 0 !important;
                                min-width: 0 !important;
                                pointer-events: auto;
                        }
                        .pwe-element-logotypes-slider .slides div {
                                padding:0;
                                object-fit: contain !important;
                        }
                        .pwe-element-logotypes-slider .slides .image-container div{
                                margin: 5px !important;
                        }
                        @keyframes slideAnimation {
                                from {
                                        transform: translateX(100%);
                                }
                                to {
                                        transform: translateX(0);
                                }
                        }
                        .pwe-element-logotypes-slider .slides .slide{
                                animation: slideAnimation 0.5s ease-in-out;
                        }
                </style>
                
                <div id="PWELogotypesSlider-'. $id_rnd .'" class="pwe-element-logotypes-slider">
                        <div class="slides">';
                        
                        for ($i = $min_image; $i < ($max_image); $i++) {
                                if($i<0){
                                    $imgNumber = count($media_url) + $i;
                                    $imageStyles = "background-image:url('".$media_url[$imgNumber]['img']."');";
                                } elseif($i>=0 && $i<(count($media_url))){
                                    $imgNumber = $i;
                                    $imageStyles = "background-image:url('".$media_url[$imgNumber]['img']."');";
                                } elseif($i>=(count($media_url))){
                                    $imgNumber = ($i - count($media_url));
                                    $imageStyles = "background-image:url(".$media_url[$imgNumber]['img'].");";
                                }

                                $imageId = ($media_url[$imgNumber]['id'] && !empty($media_url[$imgNumber]['id']) && $media_url[$imgNumber]['id'] == 'primary') ? 'as-' . $media_url[$imgNumber]['id'] : '';
                                $imageUrl = $media_url[$imgNumber]['site'];
                                $imageClass = $media_url[$imgNumber]['class'] ? $media_url[$imgNumber]['class'] : '';
                                $imageStyle = $media_url[$imgNumber]['style'] ? $media_url[$imgNumber]['style'] : '';

                                if (!empty($imageUrl)){
                                        $output .= '<a href="'. $imageUrl .'" target="_blank" class="image-container '. $imageId .'"><div class="'.$imageClass.' logo-with-link" style="'.$imageStyles . ' ' . $imageStyle.'"></div></a>';
                                } else {
                                        $output .= '<div class="image-container '.$imageClass.' logo-without-link" style="'.$imageStyles . ' ' . $imageStyle.'"></div>';
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
        private static function generateScript($id_rnd, $media_url, $min_image, $slide_speed) {

                $media_url_count = count($media_url);
                $min_image_adjusted = -$min_image;

                $output = '
                <script>
                        jQuery(function ($) {                         
                                const slider = document.querySelector("#PWELogotypesSlider-'. $id_rnd .'");
                                const slides = document.querySelector("#PWELogotypesSlider-'. $id_rnd .' .slides");
                                const images = document.querySelectorAll("#PWELogotypesSlider-'. $id_rnd .' .slides div");

                                const links = document.querySelectorAll("#PWELogotypesSlider-'. $id_rnd .' a");
                                links.forEach(link => {
                                        link.addEventListener("mousedown", (e) => {
                                        e.preventDefault();
                                        });
                                });

                                let isMouseOver = false;
                                let isDragging = false;
                                
                                let imagesMulti = "";
                                const slidesWidth = slides.clientWidth;
                                
                                if (slidesWidth < 400) {
                                        imagesMulti = 2;
                                } else if (slidesWidth < 600) {
                                        imagesMulti = 3;
                                } else if (slidesWidth < 959) {
                                        imagesMulti = 5;
                                } else {
                                        imagesMulti = 7;
                                }
                                
                                if(imagesMulti >=  '. $media_url_count .'){
                                        $("#PWELogotypesSlider-'. $id_rnd .' .slides").each(function(){
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
                                                slides.querySelectorAll("#PWELogotypesSlider-'. $id_rnd .' .image-container").forEach(function(image){
                                                        image.classList.add("slide");
                                                })
                                                slides.firstChild.classList.add("first-slide");
                                                const firstSlide = slides.querySelector(".first-slide");  

                                                slides.appendChild(firstSlide);

                                                firstSlide.classList.remove("first-slide");

                                                setTimeout(function() {
                                                        slides.querySelectorAll("#PWELogotypesSlider-'. $id_rnd .' .image-container").forEach(function(image){
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
                                                for(i = 0; i< slidesMove; i++){
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
        public static function sliderOutput($media_url, $slide_speed = 3000) {

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
            
                $output = self::createDOM($id_rnd, $media_url, $min_image, $max_image);
            
                $output .= self::generateScript($id_rnd, $media_url, $min_image, $slide_speed);
            
                return $output;
        }
} 