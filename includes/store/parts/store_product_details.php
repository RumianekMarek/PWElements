<?php

$output .= '
<div class="pwe-store__hide-sections pwe-store__desc">';

    foreach ($categories as $category) {
        $output .= '
        <!-- Desc section <------------------------------------------------------------------------------------------>
        <div id="'. str_replace("-", "", $category) .'SectionHide" category="'. $category .'" class="pwe-store__'. $category .'-section-hide pwe-store__section-hide">

            <div class="pwe-store__category-header">
                <div class="pwe-store__category-header-arrow">
                    <div class="pwe-store__category-header-arrow-el">
                        <span></span>
                    </div>
                </div>
                <div class="pwe-store__category-header-title">
                    <p class="pwe-uppercase">'. 
                        (self::lang_pl() ? 
                        'USŁUGI '. str_replace("marketing", "marketingowe", str_replace("-", " ", $category)) : 
                        str_replace("-", " ", $category) .' SERVICES') .'
                    </p>
                </div>
            </div>';

            foreach ($pwe_store_data as $product) {
                $status = null;
                if ($category == $product->prod_category && (self::lang_pl() ? !empty($product->prod_title_short_pl) : !empty($product->prod_title_short_en))) {
                    foreach ($store_options as $domain_options) {
                        if ($domain_options['domain'] === $current_domain) {
                            if (!empty($domain_options['options'])) {
                                $options = json_decode($domain_options['options'], true);
                    
                                if (isset($options['products'])) {
                                    foreach ($options['products'] as $key => $option) {
                                        if ($product->prod_slug == $key) {
                                            $sold_out = $option['sold_out'] ? "sold-out" : "";
                                            $status_text = (self::lang_pl() ? $option['prod_image_text_pl'] : $option['prod_image_text_en']) 
                                                            ? (self::lang_pl() ? $option['prod_image_text_pl'] : $option['prod_image_text_en']) 
                                                            : "";
                                            $status = !empty($status_text) ? "status" : "";
                                        }
                                    }
                                }
                            }
                
                            break;
                        }
                    }
                    
                    if ($sold_out) {
                        $output .= '
                        <style>
                            .pwe-store__featured-service-'. $product->prod_slug .'.sold-out .pwe-store__featured-image:before {
                                content: "'. (self::lang_pl() ? 'WYPRZEDANE' : 'SOLD OUT') .'";
                            }
                        </style>';
                    } else if (!empty($status)) {
                        $output .= '
                        <style>
                            .pwe-store__featured-service-'. $product->prod_slug .'.status .pwe-store__featured-image:before {
                                content: "'. $status_text .'"; 
                            }
                        </style>';
                    } else if (!empty($product->prod_image_text_pl) && !empty($product->prod_image_text_en)) {
                        $status = "status";
                        $output .= '
                        <style>
                            .pwe-store__featured-service-'. $product->prod_slug .'.status .pwe-store__featured-image:before {
                                content: "'. (self::lang_pl() ? $product->prod_image_text_pl : $product->prod_image_text_en) .'";
                            }
                        </style>';
                    }

                    $output .= '
                    <!-- Desc item -->
                    <div id="'. $product->prod_slug .'" class="pwe-store__featured-service pwe-store__featured-service-'. $product->prod_slug .' pwe-store__service '. $sold_out . ' ' . $status .'" category="'. $category .'" data-slug="'. $product->prod_slug .'">
                        <div class="pwe-store__featured-content">
                            <div class="pwe-store__featured-image">
                                <img  
                                    class="pwe-store__featured-single-image"
                                    src="https://cap.warsawexpo.eu/public/uploads/shop/'. ( self::lang_pl() ? $product->prod_image_pl : (!empty($product->prod_image_en) ? $product->prod_image_en : $product->prod_image_pl)) .'" 
                                    alt="'. ( self::lang_pl() ? $product->prod_title_short_pl : $product->prod_title_short_en ) .'"
                                >';
                                if (!empty($product->prod_image_gallery)) {
                                    $output .= '
                                    <div class="pwe-store__featured-gallery">';
                                        $gallery_urls = explode(',', $product->prod_image_gallery);

                                        foreach ($gallery_urls as $url) {
                                            $output .= '<img src="https://cap.warsawexpo.eu/public/uploads/shop/' . $product->prod_slug . '/gallery/' . $url . '" alt="Gallery image" width="200" height="300">';
                                        }
                                    $output .= '
                                    </div>';
                                }
                            $output .= '
                            </div>
                            
                            <div class="pwe-store__featured-details">
                                <div class="pwe-store__featured-text-content">
                                    <h3 class="pwe-store__service-name">'. ( self::lang_pl() ? (!empty($product->prod_title_full_pl) ? $product->prod_title_full_pl : $product->prod_title_short_pl) : (!empty($product->prod_title_full_en) ? $product->prod_title_full_en : $product->prod_title_short_en) ) .'</h3>
                                    <span class="pwe-store__service-name-mailing">'. ( self::lang_pl() ? $product->prod_title_short_pl : $product->prod_title_short_en ) .'</span>
                                    <div class="pwe-store__featured-text">
                                        '. ( self::lang_pl() ? $product->prod_desc_full_pl : $product->prod_desc_full_en ) .' 
                                    </div>
                                </div>
                                <div class="pwe-store__featured-footer">
                                    <span class="pwe-store__featured-price">'. self::price($product, $store_options, $pwe_meta_data, $category, $current_domain) .'</span>
                                    <span class="pwe-store__featured-price-info">'. ( self::lang_pl() ? '* Do ceny netto należy doliczyć podatek VAT 23%.' : '* VAT 23% should be added to the net price.' ) .'</span>
                                    <div class="pwe-store__featured-buttons">
                                        <a href="#" class="pwe-store__contact-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'KONTAKT' : 'CONTACT' ) .'</a>
                                        <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
            }  
            
        $output .= '
        </div>'; 
    }  
    
    foreach ($packages_categories as $category) {
        $output .= '
        <!-- Desc section <------------------------------------------------------------------------------------------>
        <div id="'. str_replace("-", "", $category) .'PackagesSectionHide" category="'. $category .'-packages" class="pwe-store__'. $category .'-packages-section-hide pwe-store__section-hide pwe-store__packages-section-hide">

            <div class="pwe-store__category-header">
                <div class="pwe-store__category-header-arrow">
                    <div class="pwe-store__category-header-arrow-el">
                        <span></span>
                    </div>
                </div>
                <div class="pwe-store__category-header-title">
                    <p class="pwe-uppercase">'. 
                        (self::lang_pl() ? 
                        'PAKIETY '. str_replace("marketing", "marketingowe", str_replace("-", " ", $category)) : 
                        str_replace("-", " ", $category) .' PACKAGES') .'
                    </p>
                </div>
            </div>';

            foreach ($pwe_store_packages_data as $package) {
                if ($category == $package->packs_category && (self::lang_pl() ? !empty($package->packs_name_pl) : !empty($package->packs_name_en))) {
                    $output .= '
                    <!-- Package desc item -->
                    <div class="pwe-store__featured-service pwe-store__featured-service-'. $package->packs_slug .' pwe-store__service" id="'. $package->packs_slug .'" category="'. $category .'-packages" data-slug="'. $product->prod_slug .'">
                        <div class="pwe-store__featured-content">
                            <div class="pwe-store__featured-image">';

                                $package_products_explode_slugs = explode(' ', $package->packs_data);

                                foreach ($pwe_store_data as $product) {
                                    $product_slug = $product->prod_slug;

                                    foreach ($package_products_explode_slugs as $package_product) {

                                        $slug = strpos($package_product, '*') !== false ? explode('*', $package_product)[0] : $package_product;

                                        if ($slug === $product_slug) {
                                            $output .= '
                                            <!-- Package product -->
                                            <div class="pwe-store__service-card pwe-store__service package-product" data-featured="'. $product->prod_slug .'">
                                                <div class="pwe-store__service-card-wrapper">
                                                    <div class="pwe-store__service-image">
                                                        <img  
                                                            class="pwe-store__featured-single-image"
                                                            src="https://cap.warsawexpo.eu/public/uploads/shop/'. ( self::lang_pl() ? $product->prod_image_pl : (!empty($product->prod_image_en) ? $product->prod_image_en : $product->prod_image_pl)) .'" 
                                                            alt="'. ( self::lang_pl() ? $product->prod_title_short_pl : $product->prod_title_short_en ) .'"
                                                        >
                                                    </div>
                                                    <div class="pwe-store__service-content">
                                                        <div class="pwe-store__service-content-wrapper">
                                                            <h4 class="pwe-store__service-name">'. ( self::lang_pl() ? $product->prod_title_short_pl : $product->prod_title_short_en ) .'</h4>
                                                            <span class="pwe-store__service-name-mailing">'. ( self::lang_pl() ? $product->prod_title_short_pl : $product->prod_title_short_en ) .'</span>
                                                            <div class="pwe-store__service-description ">'. ( self::lang_pl() ? $product->prod_desc_short_pl : $product->prod_desc_short_en ) .'</div>
                                                        </div>
                                                        <div class="pwe-store__btn-container">
                                                            <span class="pwe-store__more-button" data-featured="'. $product->prod_slug .'">'. ( self::lang_pl() ? 'WIĘCEJ' : 'MORE' ) .'</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';
                                  
                                        }
                                    }
                                }

                            $output .= '
                            </div>
                            <div class="pwe-store__featured-details">
                                <div class="pwe-store__featured-text">
                                    <div class="pwe-store__featured-mobile-image">
                                        <img
                                            src="'. ( self::lang_pl() ? $package->packs_img_pl : (!empty($package->packs_img_en) ? $package->packs_img_en : $package->packs_img_pl)) .'" 
                                            alt="'. ( self::lang_pl() ? $package->packs_title_short_pl : $package->packs_title_short_en ) .'"
                                        > 
                                    </div>
                                    <h3 class="pwe-store__service-name">'. ( self::lang_pl() ? $package->packs_name_pl : $package->packs_name_en ) .'</h3>
                                    <span class="pwe-store__service-name-mailing">'. ( self::lang_pl() ? $package->packs_name_pl : $package->packs_name_en ) .'</span>
                                    <div class="pwe-store__featured-text">
                                        '. ( self::lang_pl() ? $package->packs_desc_pl : $package->packs_desc_en ) .' 
                                    </div>
                                </div>
                                <div class="pwe-store__featured-footer">
                                    <div class="pwe-store__featured-price">';

                                        $package_products_slug = $package->packs_data;
                                        $total_price = 0;
                                        $products = explode(' ', $package_products_slug);
                                    
                                        foreach ($products as $product_slug_with_quantity) {
                                            // Separating the product into slug and quantity
                                            list($product_slug, $quantity) = explode('*', $product_slug_with_quantity);
                                            // If quantity is not specified, set default to 1
                                            $quantity = isset($quantity) ? (int)$quantity : 1;
                                           
                                            foreach ($pwe_store_data as $product) {
                                                if ($product->prod_slug === $product_slug) {   
                                                    $product_price = self::price($product, $store_options, $pwe_meta_data, $category, $current_domain, $num_only = true);
                                                    $total_price += $product_price * $quantity;
                                                    break;
                                                }
                                            }
                                        }

                                        if ($package->packs_discount != null) {
                                            $discount = $total_price * ($package->packs_discount / 100);
                                            $discount_price = $total_price - $discount;
                                            $saving_price = self::roundPrice($total_price) - self::roundPrice($discount_price);
                                            $discount_price = number_format(self::roundPrice($discount_price), 0, ',', ' ');  
                                        }
                                        $total_price = number_format(self::roundPrice($total_price), 0, ',', ' ');        

                                        if (!empty($discount_price)) {
                                            $output .= '
                                            <div class="pwe-store__featured-price-wrapper">
                                                <p class="pwe-store__discount-price">'. $discount_price . (self::lang_pl() ? " zł netto" : " € net") .'</p>
                                                <p class="pwe-store__regular-price" style="color: #777;">
                                                    <span>Cena bez pakietu:</span>
                                                    <span style="text-decoration: line-through;">'. $total_price . (self::lang_pl() ? " zł netto" : " € net") .'</span>
                                                </p>
                                                <p class="pwe-store__saving-price" style="color: #777;">
                                                    <span>Oszczędzasz:</span>
                                                    <span>'. $saving_price . (self::lang_pl() ? " zł netto" : " € net") .'</span>
                                                </p>
                                            </div>';
                                        } else {
                                            $output .= '<p class="pwe-store__regular-price">'. $total_price . (self::lang_pl() ? " zł netto" : " € net") .'</p>';
                                        } 
                                        

                                    $output .= '
                                    </div>
                                    <span class="pwe-store__featured-price-info">'. ( self::lang_pl() ? '* Do ceny netto należy doliczyć podatek VAT 23%.' : '* VAT 23% should be added to the net price.' ) .'</span>
                                    <div class="pwe-store__featured-buttons">
                                        <a href="#" class="pwe-store__contact-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'KONTAKT' : 'CONTACT' ) .'</a>
                                        <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
            }
            
        $output .= '
        </div>'; 
    }

$output .= '
</div>';

return $output;