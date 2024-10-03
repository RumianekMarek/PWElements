<?php 

/**
 * Class PWElementPosts
 * Extends PWElements class and defines a custom Visual Composer element for vouchers.
 */
class PWElementPosts extends PWElements {

    /**
     * Constructor method.
     * Calls parent constructor and adds an action for initializing the Visual Composer map.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Static method to initialize Visual Composer elements.
     * Returns an array of parameters for the Visual Composer element.
     */
    public static function initElements() {
        $element_output = array(
            array(
                'type' => 'dropdown',
                'group' => 'PWE Element',
                'heading' => __('Select form', 'pwelement'),
                'param_name' => 'posts_modes',
                'save_always' => true,
                'value' => array(
                    'Slider mode' => 'posts_slider_mode',
                    'Full mode' => 'posts_full_mode',
                    'Full mode newest (top 6)' => 'posts_full_newest_mode',
                    'Full mode newest slider' => 'posts_full_newest_slider_mode',
                ),
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementPosts',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Category', 'pwelement'),
                'param_name' => 'posts_category',
                'save_always' => true,
                'dependency' => array(
                  'element' => 'pwe_element',
                  'value' => 'PWElementPosts',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Posts count', 'pwelement'),
                'param_name' => 'posts_count',
                'save_always' => true,
                'dependency' => array(
                  'element' => 'pwe_element',
                  'value' => 'PWElementPosts',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Aspect ratio', 'pwelement'),
                'param_name' => 'posts_ratio',
                'description' => __('Default 1/1', 'pwelement'),
                'save_always' => true,
                'dependency' => array(
                  'element' => 'posts_modes',
                  'value' => 'posts_slider_mode',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Button link', 'pwelement'),
                'param_name' => 'posts_link',
                'description' => __('Default aktualnosci-news', 'pwelement'),
                'save_always' => true,
                'dependency' => array(
                  'element' => 'posts_modes',
                  'value' => 'posts_slider_mode',
                ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Hide posts button', 'pwelement'),
                'param_name' => 'posts_btn',
                'save_always' => true,
                'value' => array(__('True', 'pwelement') => 'true',),
                'dependency' => array(
                  'element' => 'posts_modes',
                  'value' => 'posts_slider_mode',
                ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Display all categories (<= 5 posts)', 'pwelement'),
                'param_name' => 'posts_all_cat',
                'save_always' => true,
                'value' => array(__('True', 'pwelement') => 'true',),
                'dependency' => array(
                  'element' => 'posts_modes',
                  'value' => 'posts_slider_mode',
                ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Display all posts (> 5 posts)', 'pwelement'),
                'param_name' => 'posts_all',
                'description' => __('View all posts in such categories (more than 5 posts)', 'pwelement'),
                'save_always' => true,
                'value' => array(__('True', 'pwelement') => 'true',),
                'dependency' => array(
                  'element' => 'posts_modes',
                  'value' => 'posts_slider_mode',
                ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Full width', 'pwelement'),
                'param_name' => 'posts_full_width',
                'save_always' => true,
                'value' => array(__('True', 'pwelement') => 'true',),
                'dependency' => array(
                  'element' => 'posts_modes',
                  'value' => 'posts_slider_mode',
                ),
            ),
        );
        return $element_output;
    }

    // public static function get_custom_excerpt($post_id, $word_count = 10) {
    //     // Pobierz zawartość posta
    //     $post_content = get_post_field('post_content', $post_id);
    
    //     // Usuń shortcode'y i HTML
    //     $post_content = strip_shortcodes($post_content);
    //     $post_content = wp_strip_all_tags($post_content);
    
    //     // Podziel treść na słowa
    //     $words = explode(' ', $post_content);
    
    //     // Wyodrębnij pierwsze $word_count słów
    //     $excerpt = array_slice($words, 0, $word_count);
    
    //     // Połącz słowa w jeden ciąg znaków
    //     $excerpt = implode(' ', $excerpt);
    
    //     // Dodaj wielokropek na końcu
    //     $excerpt .= '...';
    
    //     return $excerpt;
    // }

    /**
     * Static method to generate the HTML output for the PWE Element.
     * Returns the HTML output as a string.
     * 
     * @param array @atts options
     */
    public static function output($atts) {
        $text_color = self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'black') . ' !important;';
        $btn_text_color = self::findColor($atts['btn_text_color_manual_hidden'], $atts['btn_text_color'], 'white') . '!important';
        $btn_color = self::findColor($atts['btn_color_manual_hidden'], $atts['btn_color'], self::$accent_color) . '!important';
        $btn_border = self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], self::$accent_color) . '!important';
        $darker_btn_color = self::adjustBrightness($btn_color, -20);

        $darker_main2_color = self::adjustBrightness(self::$main2_color, -20);

        extract( shortcode_atts( array(
            'posts_modes' => 'posts_slider_mode',
            'posts_category' => '',
            'posts_count' => '',
            'posts_ratio' => '',
            'posts_link' => '',
            'posts_btn' => '',
            'posts_all_cat' => '',
            'posts_all' => '',
            'posts_full_width' => '',
        ), $atts )); 

        $trade_end = do_shortcode('[trade_fair_enddata]');
        $mobile = preg_match('/Mobile|Android|iPhone/i', $_SERVER['HTTP_USER_AGENT']);

        $posts_title = "";
        if(get_locale() == "pl_PL") {
            $posts_title = ($posts_title == "") ? "Aktualności" : $posts_title;
            $posts_link = ($posts_link == "") ? "/aktualnosci/" : $posts_link;
            $posts_text = "Zobacz wszystkie";
        } else {
            $posts_title = ($posts_title == "") ? "News" : $posts_title;
            $posts_link = ($posts_link == "") ? "/en/news/" : $posts_link;
            $posts_text = "See all";
        }
        
        if ($posts_modes == "posts_slider_mode") {
            $posts_ratio = ($posts_ratio == "") ? "1/1" : $posts_ratio;
        } else {
            $posts_ratio = ($posts_ratio == "") ? "21/9" : $posts_ratio;
        }
        
        $output = '';
        $output .= '
            <style>
                .pwelement_'.self::$rnd_id.' .pwe-btn {
                    color: '. $btn_text_color .';
                    background-color:'. $btn_color .';
                    border:'. $btn_color .';
                }
                .pwelement_'.self::$rnd_id.' .pwe-btn:hover {
                    color: '. $btn_text_color .';
                    background-color:'. $darker_btn_color .' !important;
                    border:'. $darker_btn_color .' !important;
                }
                .pwelement_'. self::$rnd_id .' .pwe-post-thumbnail .image-container {
                    width: 100%;
                    background-size: cover;
                    background-repeat: no-repeat;
                    background-position: center;
                    aspect-ratio: '. $posts_ratio .';
                }
                .pwelement_'. self::$rnd_id .' .pwe-post-title {
                    text-align: left;
                }
            </style>';

        if ($posts_modes == "posts_slider_mode") {
            
            $output .= '
            <style>
                .row-parent:has(.pwelement_'.self::$rnd_id.' .pwe-container-posts) {
                    max-width: 100%;
                    padding: 0 !important;
                }
                .pwelement_'.self::$rnd_id.' .pwe-posts-wrapper {
                    max-width: 1200px; 
                    margin: 0 auto; 
                    padding: 36px;  
                } 
                .pwelement_'. self::$rnd_id .' .pwe-posts {
                    display: flex;
                    justify-content: center;
                    gap: 18px;
                    padding-bottom: 18px;
                    opacity: 0;
                }
                .pwelement_'. self::$rnd_id .' .pwe-post-title {
                    margin: 0;
                    padding: 10px 0 0 10px;
                }
                .pwelement_'. self::$rnd_id .' .pwe-posts-title h4 {
                    margin: 0 0 36px;
                }
                .pwelement_'. self::$rnd_id .' .pwe-post-thumbnail .image-container {
                    border-radius: 18px;
                }
                .pwelement_'. self::$rnd_id .' .pwe-posts .slides {
                    align-items: flex-start !important;
                    gap: 16px;
                }
                .pwelement_'. self::$rnd_id .' .pwe-posts .slides a {
                    padding: 10px;
                }
                @media (max-width: 1128px) {
                    .pwelement_'.self::$rnd_id.' .pwe-posts-wrapper {
                        padding: 36px;  
                    } 
                }
                @media (max-width: 650px) {
                    .pwelement_'. self::$rnd_id .' .pwe-posts .slides {
                        gap: 18px;
                    } 
                }
            </style>';

            // Display all categories across the full width of the page
            if ($posts_full_width === 'true' && $mobile != 1) {
                $output .= '
                <style>
                    .pwelement_'. self::$rnd_id .' .pwe-posts-wrapper {
                        max-width: 100% !important;  
                        padding: 36px 0 !important; 
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-posts-title {
                        max-width: 1200px;
                        margin: 0 auto;
                        padding-left: 36px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-posts .slides {
                        margin-right: 36px !important;
                        gap: 36px !important;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-post .t-entry-visual,
                    .pwelement_'. self::$rnd_id .' .pwe-post .image-container,
                    .pwelement_'. self::$rnd_id .' .pwe-post .pwe-post-thumbnail {
                        min-width: 300px !important;
                        max-width: 300px !important;
                    }
                </style>'; 
            }   
        } else {
            if ($posts_modes == "posts_full_mode" || $posts_modes == "posts_full_newest_mode") {
                $output .= '
                <style>
                    .pwelement_'. self::$rnd_id .' .pwe-posts {
                        display: grid;
                        grid-template-columns: repeat(3, 1fr);
                        gap: 20px;
                        opacity: 0;
                    }
                    @media (max-width: 960px) {
                        .pwelement_'. self::$rnd_id .' .pwe-posts {
                            grid-template-columns: repeat(2, 1fr);
                        }
                    }
                    @media (max-width: 500px) {
                        .pwelement_'. self::$rnd_id .' .pwe-posts {
                            grid-template-columns: repeat(1, 1fr);
                        }
                    }
                </style>';
            }
            $output .= '
            <style>
                .pwelement_'. self::$rnd_id .' .pwe-post {
                    display: flex;
                    flex-direction: column;
                    position: relative;
                    background-color: white;
                    border: 1px solid '. self::$main2_color .';
                    border-radius: 11px;
                    transition: .3s ease;
                    height: auto;
                    min-height: 300px;
                }
                .pwelement_'. self::$rnd_id .' .pwe-post:hover {
                    transform: scale(1.05);
                }   
                .pwelement_'. self::$rnd_id .' .pwe-post-title {
                    font-weight: 600;
                }
                .pwelement_'. self::$rnd_id .' .pwe-post-thumbnail {
                    position: relative;
                    overflow: hidden;
                    border-radius: 10px 10px 0 0;
                    background-color: white;
                }
                .pwelement_'. self::$rnd_id .' .pwe-post-thumbnail .image-container {
                    border-radius: 10px 10px 0 0;
                    transition: .3s ease;
                }
                .pwelement_'. self::$rnd_id .' .pwe-post:hover .pwe-post-thumbnail .image-container  {
                    transform: scale(1.05);
                }  
                .pwelement_'. self::$rnd_id .' .pwe-post-date {
                    position: absolute;
                    bottom: 10px;
                    left: 10px;
                    color: white;
                    font-size: 19px;
                    font-weight: 600;
                    line-height: 1.3;
                    width: 50px;
                    height: 50px;
                    text-transform: uppercase;
                    background-color: '. self::$main2_color .';
                    border-radius: 5px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    text-align: center;
                    z-index: 1;
                }
                .pwelement_'. self::$rnd_id .' .pwe-post-date:before {
                    position: absolute;
                    content:"";
                    background-color: rgba(0, 0, 0, 0.1);
                    bottom: 0;
                    left: 0;
                    right: 0;
                    width: 100%;
                    height: 50%;
                    z-index: 2;
                }
                .pwelement_'. self::$rnd_id .' .pwe-post-title, 
                .pwelement_'. self::$rnd_id .' .pwe-post-excerpt {
                    text-align: left;
                    color: #222;
                    padding: 9px;
                    margin: 0;
                }
                .pwelement_'. self::$rnd_id .' .pwe-post-excerpt {
                    padding: 9px 9px 50px;
                    line-height: 1.5;
                }
                .pwelement_'. self::$rnd_id .' .pwe-post-btn {
                    position: absolute;
                    color: white;
                    bottom: 0;
                    left: 0;
                    right: 0;
                    padding: 10px;
                    background-color: '. self::$main2_color .';
                    border-radius: 0 0 10px 10px;
                    transition: .3s ease;
                }
                .pwelement_'. self::$rnd_id .' .pwe-post-btn:hover  {
                    background-color: '. $darker_main2_color .';
                } 

                .pwelement_'. self::$rnd_id .' .load-more-btn-container {
                    margin: 36px auto;
                    text-align: center;
                }
                .pwelement_'. self::$rnd_id .' .load-more-btn-container button {
                    min-width: 240px;
                    padding: 10px;
                    text-transform: uppercase;
                    font-size: 14px;
                    font-weight: 600;
                    transition: .3s ease;
                }
                @media (max-width: 960px) {
                    .pwelement_'. self::$rnd_id .' .pwe-post-excerpt {
                        font-size: 14px;  
                    }    
                }
            </style>'; 
        }

        $output .= '<div id="pwePosts" class="pwe-container-posts">
                        
            <div class="pwe-posts-wrapper">'; 

            if ($posts_modes == "posts_slider_mode") {

                $posts_count = ($posts_count == "") ? 5 : $posts_count;
            
                $output .= '
                <div class="pwe-posts-title main-heading-text">
                    <h4 class="pwe-uppercase"><span>' . $posts_title . '</span></h4>
                </div>  
                <div class="pwe-posts">';
        
                if (strlen($trade_end) <= 10) { // Assuming the date format is 'Y/m/d'
                    $trade_end .= ' 17:00'; // Adding '17:00' to the date
                }
                $trade_end_date = DateTime::createFromFormat('Y/m/d H:i', $trade_end);
                $now = new DateTime();
        
                if ($trade_end_date !== false) {
                    // Getting the year from the end date of the fair
                    $trade_end_year = $trade_end_date->format('Y');
        
                    // Create a category name with the "news-" prefix and the year
                    $category_year = 'news-' . $trade_end_year;

                    // Check if `$posts category` is set and not empty
                    if (!empty($posts_category) && term_exists($posts_category, 'category')) {
                        // We only use categories from `$posts category`
                        $categories = $posts_category;
                    } else {
                        // Create an array for categories
                        $categories_array = [];
                        // Add a categories to the array, if it's exists
                        if (term_exists($category_year, 'category')) {
                            // Check if a category with the "news-" prefix and year exists
                            array_push($categories_array, $category_year);
                        }
                        if (term_exists("current", 'category')) {
                            // Check if category "current" exists
                            array_push($categories_array, "current");
                        }

                        // Transform the category array into a string
                        $categories = implode(',', $categories_array);
                    }
        
                    $max_posts = ($posts_all !== 'true') ? min($posts_count, 18) : -1;
        
                    $args = array(
                        'posts_per_page' => $max_posts,
                        'orderby' => 'date',
                        'order' => 'DESC',
                        'post_status' => 'publish',
                        'category_name' => $categories,
                    );

                    $query = new WP_Query($args);

                    $posts_displayed = $query->post_count;

                    $post_image_urls = array();
                    if ($query->have_posts()) {
                        while ($query->have_posts()) : $query->the_post();
                            $link = get_permalink();
                            $image = has_post_thumbnail() ? get_the_post_thumbnail_url(null, 'full') : '';
                            $title = get_the_title();

                            $post_image_urls[] = array(
                                "img" => $image,
                                "link" => $link,
                                "title" => $title
                            );
                            
                        endwhile;
                    }
        
                    wp_reset_postdata();

                    include_once plugin_dir_path(__FILE__) . '/../scripts/posts-slider.php';
                    $output .= PWEPostsSlider::sliderOutput($post_image_urls);

                } else {
                    echo 'Błąd: Nieprawidłowy format daty.';
                    return;
                }
        
                $output .= '</div>';
                if ($posts_btn !== "true") {
                    $output .= '
                    <div class="pwe-btn-container" style="padding-top: 18px;">
                        <span>
                            <a class="pwe-link btn pwe-btn" href="'. $posts_link .'">'. $posts_text .'</a>
                        </span>
                    </div>';
                }
            } else if ($posts_modes == "posts_full_mode" || $posts_modes == "posts_full_newest_mode" || $posts_modes == "posts_full_newest_slider_mode") {

                $output .= '<div class="pwe-posts">';

                if ($posts_modes == "posts_full_mode") {
                    $posts_count = ($posts_count == "") ? 18 : $posts_count;
                    $max_posts = ($posts_all !== 'true') ? min($posts_count, 18) : -1;
                } else if ($posts_modes == "posts_full_newest_mode") {
                    $posts_count = ($posts_count == "") ? 6 : $posts_count;
                    $max_posts = $posts_count;
                } else if ($posts_modes == "posts_full_newest_slider_mode") {
                    $posts_count = ($posts_count == "") ? 10 : $posts_count;
                    $max_posts = ($posts_all !== 'true') ? min($posts_count, 10) : -1;  
                }

                $all_categories = get_categories(array('hide_empty' => true));

                if (!empty($posts_category) && term_exists($posts_category, 'category')) {
                    // We only use categories from `$posts category`
                    $category_name = $posts_category;
                } else {
                    $category_names = array();

                    foreach ($all_categories as $category) {
                        // Checks if the category name contains the word 'news'
                        if (strpos(strtolower($category->name), 'news') !== false) {
                            // Use slug instead of category name
                            $category_names[] = $category->slug; 
                        }
                    }

                    $category_name = implode(', ', $category_names); 
                }         

                $args = array(
                    'posts_per_page' => $max_posts,
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'post_status' => 'publish',
                    'category_name' => $category_name
                );

                $query = new WP_Query($args);
                
                $posts_displayed = $query->post_count;

                $post_image_urls = array();
                if ($query->have_posts()) {
                    while ($query->have_posts()) : $query->the_post();
                        $post_id = get_the_ID();
                        $word_count = 10;

                        // Get post content
                        $post_content = get_post_field('post_content', $post_id);
                
                        // Extract content inside [vc_column_text] shortcode
                        preg_match('/\[vc_column_text.*?\](.*?)\[\/vc_column_text\]/s', $post_content, $matches);
                        $vc_content = isset($matches[1]) ? $matches[1] : '';
                
                        // Remove HTML
                        $vc_content = wp_strip_all_tags($vc_content);
                
                        // Check if the content is not empty
                        if (!empty($vc_content)) {
                            // Split content into words
                            $words = explode(' ', $vc_content);
                
                            // Extract the first $word_count words
                            $excerpt = array_slice($words, 0, $word_count);
                
                            // Combine words into one string
                            $excerpt = implode(' ', $excerpt);
                
                            // Add an ellipsis at the end
                            $excerpt .= '...';
                        } else {
                            $excerpt = '';
                        }
                
                        $link = get_permalink();
                        $image = has_post_thumbnail() ? get_the_post_thumbnail_url(null, 'full') : '';
                        $title = get_the_title();
                        $date = get_the_date('Y-m-d'); // Get date in YYYY-MM-DD format

                        $title_words = explode(' ', $title);
                        if (count($title_words) > 10) {
                            $title = implode(' ', array_slice($title_words, 0, 10)) . '...';
                        }

                        // Format the date
                        $date_obj = new DateTime($date);
                        $formatted_date = $date_obj->format('d M'); // Format as DD Mmm
                        
                        if (get_locale() == 'pl_PL') {
                            // Convert month abbreviations to Polish
                            $formatted_date = str_replace(
                                array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'),
                                array('sty', 'lut', 'mar', 'kwi', 'maj', 'cze', 'lip', 'sie', 'wrz', 'paź', 'lis', 'gru'),
                                $formatted_date
                            );
                        }
                
                        if ($posts_modes == "posts_full_newest_slider_mode") {
                            $post_image_urls[] = array(
                                "img" => $image,
                                "link" => $link,
                                "title" => $title,
                                "excerpt" => $excerpt,
                                "date" => $formatted_date
                            );
                        } else {
                            if (!empty($image)) {
                                $output .= '
                                <a class="pwe-post" href="'. $link .'">
                                    <div class="pwe-post-thumbnail">
                                        <div class="image-container" style="background-image:url('. $image .');"></div>
                                        <p class="pwe-post-date">'. $formatted_date .'</p>
                                    </div> 
                                    <h5 class="pwe-post-title">'. $title .'</h5>
                                    <p class="pwe-post-excerpt">'. $excerpt .'</p>
                                    <button class="pwe-post-btn">' . self::languageChecker('CZYTAJ WIĘCEJ', 'READ MORE') . '</button>
                                </a>';
                            }
                        }
                
                    endwhile;
                }
                
                wp_reset_postdata();

                if ($posts_modes == "posts_full_newest_slider_mode") {
                    include_once plugin_dir_path(__FILE__) . '/../scripts/posts-slider.php';
                    $output .= PWEPostsSlider::sliderOutput($post_image_urls, 3000, $full_mode = 'true');
                }

                $output .= '</div>';

                if ($posts_modes == "posts_full_mode" && $posts_displayed == 18) {
                    $output .= '
                    <div class="load-more-btn-container">
                        <button id="load-more-posts" class="pwe-btn" data-offset="18">' . self::languageChecker('Załaduj więcej','Load more') . '</button>
                    </div>';
                }
                
            }
                
            $output .= '</div>
                        
        </div>';
        
        $output .= '
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const pwePostsElement = document.querySelector(".pwelement_' . self::$rnd_id . ' .pwe-posts");
                const pweSliderElement = document.querySelector(".pwe-posts .slides");
                const pwePostsRow = document.querySelector(".row-container:has(.pwe-posts)");
                pwePostsElement.style.opacity = 1;
                pwePostsElement.style.transition = "opacity 0.3s ease";
                if ((pwePostsElement && pwePostsElement.children.length === 0) || (pweSliderElement && pweSliderElement.children.length === 0)) {
                    pwePostsRow.classList.add("desktop-hidden", "tablet-hidden", "mobile-hidden");
                }

                const loadMoreButton = document.getElementById("load-more-posts");

                if (loadMoreButton) {
                    loadMoreButton.addEventListener("click", function() {
                        const button = this;
                        const offset = parseInt(button.getAttribute("data-offset"));

                        button.innerText = "' . self::languageChecker('Ładowanie...','Loading...') . '";
                        button.disabled = true;

                        const xhr = new XMLHttpRequest();
                        xhr.open("POST", "' . admin_url('admin-ajax.php') . '", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
                        xhr.onload = function() {
                            if (xhr.status >= 200 && xhr.status < 400) {
                                const response = xhr.responseText;
                                const container = document.querySelector(".pwe-posts");
                                container.insertAdjacentHTML("beforeend", response);
                                
                                const newOffset = offset + 18;
                                button.setAttribute("data-offset", newOffset);
                                
                                // Check if all posts have been loaded
                                if (response.trim() === "") {
                                    button.remove();
                                } else {
                                    button.innerText = "' . self::languageChecker('Załaduj więcej','Load more') . '";
                                    button.disabled = false;
                                }
                            }
                        };
                        xhr.send("action=load_more_posts&offset=" + offset);
                    });
                }
            });
        </script>';

        return $output;

    }
}