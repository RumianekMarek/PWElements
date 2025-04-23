<?php

$output .= '
<div class="pwe-store__sections pwe-store__cards">';

    foreach ($categories as $category) {
        $output .= '
        <!-- Card section <------------------------------------------------------------------------------------------>
        <div id="'. str_replace("-", "", $category) .'Section" category="'. $category .'" class="pwe-store__'. $category .'-section pwe-store__section"> 
            <div class="pwe-store__services-cards">';

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
                                .pwe-store__service-card-'. $product->prod_slug .'.sold-out .pwe-store__service-image:before {
                                    content: "'. (self::lang_pl() ? 'WYPRZEDANE' : 'SOLD OUT') .'";
                                }
                            </style>';
                        } else if (!empty($status)) {
                            $output .= '
                            <style>
                                .pwe-store__service-card-'. $product->prod_slug .'.status .pwe-store__service-image:before {
                                    content: "'. $status_text .'";
                                }
                            </style>';
                        } else if (!empty($product->prod_image_text_pl) && !empty($product->prod_image_text_en)) {
                            $status = "status";
                            $output .= '
                            <style>
                                .pwe-store__service-card-'. $product->prod_slug .'.status .pwe-store__service-image:before {
                                    content: "'. (self::lang_pl() ? $product->prod_image_text_pl : $product->prod_image_text_en) .'";
                                }
                            </style>';
                        }
                        $output .= '
                        <!-- Card item -->
                        <div class="pwe-store__service-card pwe-store__service-card-'. $product->prod_slug .' pwe-store__service '. $sold_out . ' ' . $status .'" category="'. $category .'" data-slug="'. $product->prod_slug .'">
                            <a class="pwe-store__service-card-wrapper" href="#" data-featured="'. $product->prod_slug .'">
                                <div class="pwe-store__service-image">
                                    <img
                                        src="https://cap.warsawexpo.eu/public/uploads/shop/'. ( self::lang_pl() ? $product->prod_image_pl : (!empty($product->prod_image_en) ? $product->prod_image_en : $product->prod_image_pl)) .'" 
                                        alt="'. ( self::lang_pl() ? $product->prod_title_short_pl : $product->prod_title_short_en ) .'"
                                    >
                                </div>
                                <div class="pwe-store__service-content">
                                    <h4 class="pwe-store__service-name pwe-store__service-name-mailing">'. ( self::lang_pl() ? $product->prod_title_short_pl : $product->prod_title_short_en ) .'</h4>
                                    <div class="pwe-store__service-description">'. ( self::lang_pl() ? $product->prod_desc_short_pl : $product->prod_desc_short_en ) .'</div>
                                    <div class="pwe-store__service-footer">
                                        <div class="pwe-store__price">'. self::price($product, $store_options, $pwe_meta_data, $category, $current_domain) .'</div>
                                    </div>
                                </div>
                            </a>
                            <div class="pwe-store__btn-container">
                                <a href="#" class="pwe-store__more-button" data-featured="'. $product->prod_slug .'">'. (self::lang_pl() ? 'WIĘCEJ' : 'MORE') .'</a>
                                <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. (self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW') .'</a>
                            </div>
                        </div>';
                    }
                }   

            $output .= '
            </div>';

        $output .= '
        </div>';
    }

    foreach ($packages_categories as $category) {
        $output .= '
        <!-- Card section <------------------------------------------------------------------------------------------>
        <div id="'. str_replace("-", "", $category) .'PackagesSection" category="'. $category .'-packages" class="pwe-store__'. $category .'-packages-section pwe-store__section"> 
            <div class="pwe-store__services-cards">';

                foreach ($pwe_store_packages_data as $package) {
                    if ($category == $package->packs_category && (self::lang_pl() ? !empty($package->packs_name_pl) : !empty($package->packs_name_en))) {
                        $output .= '
                        <!-- Card item -->
                        <div class="pwe-store__service-card pwe-store__service-card-'. $package->packs_slug .' pwe-store__service" category="'. $category .'-packages" data-slug="'. $product->prod_slug .'">
                            <a class="pwe-store__service-card-wrapper" href="#" data-featured="'. $package->packs_slug .'">
                                <div class="pwe-store__service-image">
                                    <img
                                        src="'. ( self::lang_pl() ? $package->packs_img_pl : (!empty($package->packs_img_en) ? $package->packs_img_en : $package->packs_img_pl)) .'" 
                                        alt="'. ( self::lang_pl() ? $package->packs_title_short_pl : $package->packs_title_short_en ) .'"
                                    >
                                </div>
                                <div class="pwe-store__service-content">
                                    <h4 class="pwe-store__service-name pwe-store__service-name-mailing">'. ( self::lang_pl() ? $package->packs_name_pl : $package->packs_name_en ) .'</h4>
                                    <div class="pwe-store__service-description">'. ( self::lang_pl() ? $package->packs_short_desc_pl : $package->packs_short_desc_en ) .'</div>
                                    <div class="pwe-store__service-footer">
                                        <div class="pwe-store__price">';
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
                                                $discount_price = number_format(self::roundPrice($discount_price), 0, ',', ' ');
                                            }
                                            $total_price = number_format(self::roundPrice($total_price), 0, ',', ' ');        
    
                                            if (!empty($discount_price)) {
                                                $output .= '<stan class="pwe-store__discount-price">'. $discount_price . (self::lang_pl() ? " zł netto" : " € net") .'</stan>';
                                            }
                                            $output .= '<stan class="pwe-store__regular-price '. (!empty($discount_price) ? 'unactive' : '') .'">'. $total_price . (self::lang_pl() ? " zł netto" : " € net") .'</stan>';
                                        $output .= '
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="pwe-store__btn-container">
                                <a href="#" class="pwe-store__more-button" data-featured="'. $package->packs_slug .'">'. (self::lang_pl() ? 'WIĘCEJ' : 'MORE') .'</a>
                                <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. (self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW') .'</a>
                            </div>
                        </div>';
                    }
                }

            $output .= '
            </div>';

        $output .= '
        </div>';
    }

    if (empty($categories)) {
        $output .= '
        <div style="margin-top: 36px; text-align: center; font-size: 24px; font-weight: 600;">'. 
            (self::lang_pl() ? "Przepraszamy, produkty tymczasowo niedostępne" : "Sorry, products temporarily unavailable") .'
        </div>';
    }

$output .= '
</div>';

return $output;