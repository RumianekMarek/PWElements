<?php

class PWEPostsSlider {

        /**
         * Initializes the slider.
         */
        public function __construct() {}

        /**
         * Creates the DOM structure for the slider.
         * 
         * @param int $id_rnd - Random ID for the slider element.
         * @param array $media_url - Array of media URLs.
         * @param int $min_image - Minimum image index.
         * @param int $max_image - Maximum image index.
         * @return string The DOM structure as HTML.
         */
        private static function createDOM($id_rnd, $media_url, $min_image, $max_image) {
                
                $output = '
                <style>
                        .pwe-posts .pwe-posts-slider {
                                width: 100%;
                                overflow: hidden !important;
                                margin: 0 !important;
                        }
                        .pwe-posts .slides {
                                display: flex;
                                align-items: flex-start !important;
                                justify-content: space-between;
                                min-height : 0 !important;
                                min-width : 0 !important;
                                pointer-events: auto;
                        }
                        .pwe-posts .slide {
                                padding:0;
                        }
                        @keyframes slideAnimation {
                                from {
                                transform: translateX(100%);
                                }
                                to {
                                transform: translateX(0);
                                }
                        }
                        .pwe-posts .slides .slide{
                                animation: slideAnimation 0.5s ease-in-out;
                        }
                        @media (max-width: 1200px) {
                                .pwe-posts .pwe-posts-slider {
                                        overflow: visible !important;
                                }
                        }
                </style>';

                if ($posts_full_width === 'true') {
                        $output .= '<style>
                                        .pwe-posts-wrapper {
                                                overflow: visible !important;
                                        }
                                </style>';
                }

                $output .= '
                <div id="PWEPostsSlider-'. $id_rnd .'" class="pwe-posts-slider">
                        <div class="slides">';
                        
                        for ($i = $min_image; $i < ($max_image); $i++) {
                                if($i<0){
                                        $imgNumber = count($media_url) + $i;
                                        $imageStyles = "background-image:url('".$media_url[$imgNumber]['img']."');";
                                } elseif( $i>=0 && $i < count($media_url)) {
                                        $imgNumber = $i;
                                        $imageStyles = "background-image:url('".$media_url[$imgNumber]['img']."');";
                                } elseif ($i >= count($media_url)) {
                                        $imgNumber = $i - count($media_url);
                                        $imageStyles = "background-image:url(".$media_url[$imgNumber]['img'].");";
                                }

                                if(is_array($media_url[$imgNumber]) && !empty($media_url[$imgNumber]['img']) && !empty($media_url[$imgNumber]['link']) && !empty($media_url[$imgNumber]['title'])){
                                        $imageUrl = $media_url[$imgNumber]['link'];
                                        $imageTitle = $media_url[$imgNumber]['title'];
                                        $output .= '<a class="pwe-post" href="'.$imageUrl.'">
                                                        <div class="pwe-post-thumbnail image-shadow">
                                                                <div class="t-entry-visual">
                                                                        <div class="image-container" style="'.$imageStyles.'"></div>
                                                                </div>
                                                        </div> 
                                                        <h5 class="pwe-post-title">'.$imageTitle.'</h5>
                                                </a>';  
                                }
                                
                        }

                $output .='</div></div>';
                return $output;
        }

        /**
         * Generates the necessary JavaScript for the slider functionality.
         * 
         * @param int $id_rnd - Random ID for the slider element.
         * @param array $media_url - Array of media URLs.
         * @param int $min_image - Minimum image index.
         * @param int $slide_speed - Slide transition speed in milliseconds.
         * @return string The JavaScript code as HTML.
         */
        private static function generateScript($id_rnd, $media_url, $min_image, $slide_speed) {
                $media_url_count = count($media_url);
                $min_image_adjusted = -$min_image;

                $output = '
                <script>
                        jQuery(function ($) {                         
                                const slider = document.querySelector("#PWEPostsSlider-'.$id_rnd.'");
                                const slides = document.querySelector("#PWEPostsSlider-'.$id_rnd.' .slides");
                                const images = document.querySelectorAll("#PWEPostsSlider-'.$id_rnd.' .slides .pwe-post");

                                let isMouseOver = false;
                                let isDragging = false;
                                
                                let imagesMulti = "";
                                const slidesWidth = slider.clientWidth;

                                if (slidesWidth < 400) {
                                        imagesMulti = 1;
                                } else if (slidesWidth < 600) {
                                        imagesMulti = 2;
                                } else if (slidesWidth < 900) {
                                        imagesMulti = 3;
                                } else if (slidesWidth < 1100) {
                                        imagesMulti = 4;
                                } else {
                                        imagesMulti = 4;
                                }
                                
                                if(imagesMulti >=  '. $media_url_count .'){
                                        $("#PWEPostsSlider-'. $id_rnd .' .slides").each(function(){
                                                $(this).css("justify-content", "center");
                                                if ($(this).children().length > '. $media_url_count .'){
                                                        $(this).children().slice('. $media_url_count .').remove();
                                                };
                                        });
                                        const imageWidth = Math.floor((slidesWidth - imagesMulti * 10) / imagesMulti);
                                        images.forEach((image) => {
                                                image.style.minWidth = imageWidth + "px";
                                                image.style.maxWidth = imageWidth + "px";
                                        });
                                } else {
                                        const imageWidth = Math.floor((slidesWidth - imagesMulti * 10) / imagesMulti);
                                        images.forEach((image) => {
                                                image.style.minWidth = imageWidth + "px";
                                                image.style.maxWidth = imageWidth + "px";
                                        });

                                        const slidesTransform = (imageWidth + 18) * '. $min_image_adjusted .';

                                        slides.style.transform = `translateX(-${slidesTransform}px)`; 

                                        function nextSlide() {
                                                slides.querySelectorAll("#PWEPostsSlider-'. $id_rnd .' .pwe-post").forEach(function(image){
                                                        image.classList.add("slide");
                                                })
                                                slides.firstChild.classList.add("first-slide");
                                                const firstSlide = slides.querySelector(".first-slide");  

                                                slides.appendChild(firstSlide);

                                                firstSlide.classList.remove("first-slide");

                                                setTimeout(function() {
                                                        slides.querySelectorAll("#PWEPostsSlider-'. $id_rnd .' .pwe-post").forEach(function(image){
                                                                image.classList.remove("slide");
                                                        })
                                                }, '.($slide_speed / 2).');
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
                                        }, '.$slide_speed.');
                                }
                        });                 
                </script>'; 
                return $output;
        }

        /**
         * Prepares and returns the HTML output for the slider.
         * 
         * @param array $media_url - Array of media URLs or structures containing URLs and additional data.
         * @param int $slide_speed - Speed of the slide transition.
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
                
                $output .= self::createDOM($id_rnd, $media_url, $min_image, $max_image);
                
                $output .= self::generateScript($id_rnd, $media_url, $min_image, 3000);
                
                return $output;
        }
} 

?>