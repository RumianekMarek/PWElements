<?php  

$max_visitors = max($map_number_visitors, $map_number_visitors_previous);
$map_number_visitors_percentage = ($map_number_visitors / $max_visitors) * 100;
$map_number_visitors_previous_percentage = ($map_number_visitors_previous / $max_visitors) * 100;

$max_exhibitors = max($map_number_exhibitors, $map_number_exhibitors_previous);
$map_number_exhibitors_percentage = ($map_number_exhibitors / $max_exhibitors) * 100;
$map_number_exhibitors_previous_percentage = ($map_number_exhibitors_previous / $max_exhibitors) * 100;

$max_exhibition_space = max($map_exhibition_space, $map_exhibition_space_previous);
$map_exhibition_space_percentage = ($map_exhibition_space / $max_exhibition_space) * 100;
$map_exhibition_space_previous_percentage = ($map_exhibition_space_previous / $max_exhibition_space) * 100;

$output .= '
<div id="pweMap" class="pwe-map">
    <div class="pwe-map__wrapper">

        <div class="pwe-map__title-section">
            <h2 class="pwe-map__title">'. $map_custom_title .'</h2>
            <p class="pwe-map__subtitle">Liczby, które mówią same za siebie</p>
        </div>

        <div class="pwe-map__stats-section">
            <div class="pwe-map__stats-diagram">
                <div class="pwe-map__stats-diagram-container">
                    <!-- Years -->
                    <div class="pwe-map__stats-diagram-years-container">
                        <div class="pwe-map__stats-diagram-year">
                            <div class="pwe-map__stats-diagram-year-box"></div>
                            <span>'. $map_year_previous .'</span>
                        </div>
                        <div class="pwe-map__stats-diagram-year">
                            <div class="pwe-map__stats-diagram-year-box"></div>
                            <span>'. $map_year .'</span>
                        </div>
                    </div>

                    <!-- Bars -->
                    <div class="pwe-map__stats-diagram-bars-container"> 
                        <!-- Bar 1 -->
                        <div class="pwe-map__stats-diagram-bars">
                            <div class="pwe-map__stats-diagram-bars-wrapper">
                                <div class="pwe-map__stats-diagram-bar">
                                    <div class="pwe-map__stats-diagram-bar-item" data-count="'. $map_number_visitors_previous_percentage .'">
                                        <div class="pwe-map__stats-diagram-bar-number"><span class="countup" data-count="'. $map_number_visitors_previous .'">0</span></div>
                                    </div>
                                </div>
                                <div class="pwe-map__stats-diagram-bar">
                                    <div class="pwe-map__stats-diagram-bar-item" data-count="'. $map_number_visitors_percentage .'">
                                        <div class="pwe-map__stats-diagram-bar-number"><span class="countup" data-count="'. $map_number_visitors .'">0</span></div>
                                    </div>
                                </div>
                            </div>
                            <p class="pwe-map__stats-diagram-bars-label">Odwiedzający</p>
                        </div>

                        <!-- Bar 2 -->
                        <div class="pwe-map__stats-diagram-bars">
                            <div class="pwe-map__stats-diagram-bars-wrapper">
                                <div class="pwe-map__stats-diagram-bar">
                                    <div class="pwe-map__stats-diagram-bar-item" data-count="'. $map_number_exhibitors_previous_percentage .'">
                                        <div class="pwe-map__stats-diagram-bar-number"><span class="countup" data-count="'. $map_number_exhibitors_previous .'">0</span></div>
                                    </div>
                                </div>
                                <div class="pwe-map__stats-diagram-bar">
                                    <div class="pwe-map__stats-diagram-bar-item" data-count="'. $map_number_exhibitors_percentage .'">
                                        <div class="pwe-map__stats-diagram-bar-number"><span class="countup" data-count="'. $map_number_exhibitors .'">0</span></div>
                                    </div>
                                </div>
                            </div>
                            <p class="pwe-map__stats-diagram-bars-label">Wystawcy</p>
                        </div>

                        <!-- Bar 3 -->
                        <div class="pwe-map__stats-diagram-bars">
                            <div class="pwe-map__stats-diagram-bars-wrapper">
                                <div class="pwe-map__stats-diagram-bar">
                                    <div class="pwe-map__stats-diagram-bar-item" data-count="'. $map_exhibition_space_previous_percentage .'">
                                        <div class="pwe-map__stats-diagram-bar-number"><span class="countup" data-count="'. $map_exhibition_space_previous .'">0</span> m<sup>2</sup></div>
                                    </div>
                                </div>
                                <div class="pwe-map__stats-diagram-bar">
                                    <div class="pwe-map__stats-diagram-bar-item" data-count="'. $map_exhibition_space_percentage .'">
                                        <div class="pwe-map__stats-diagram-bar-number"><span class="countup" data-count="'. $map_exhibition_space .'">0</span> m<sup>2</sup></div>
                                    </div>
                                </div>
                            </div>
                            <p class="pwe-map__stats-diagram-bars-label">Powierzchnia</p>
                        </div>
                    </div>
                </div>

                <!-- Countries -->
                <div class="pwe-map__stats-diagram-countries-container">
                    <div class="pwe-map__stats-diagram-countries pwe-map__stats-number-box">
                        <h2><span class="countup" data-count="'. $map_number_countries .'">0</span></h2>
                        <p>krajów</p>
                    </div>
                </div>
            </div>
            
            <div class="pwe-map__stats-number-container">
                <div class="pwe-map__stats-number-box">
                    <h2><span class="countup" data-count="'. $map_number_visitors .'">0</span></h2>
                    <div class="pwe-map__stats-number-box-text">
                        <span>+</span>
                        <p>odwiedzających</p>
                    </div>
                </div>
                
                <div class="pwe-map__stats-number-box">
                    <h2><span class="countup" data-count="'. $map_number_exhibitors .'">0</span></h2>
                    <div class="pwe-map__stats-number-box-text">
                        <span>+</span>
                        <p>wystawców</p>
                    </div>
                </div>
                
                <div class="pwe-map__stats-number-box">
                    <h2><span class="countup" data-count="'. $map_exhibition_space .'">0</span> m<sup>2</sup></h2>
                    <div class="pwe-map__stats-number-box-text">
                        <span>+</span>
                        <p>powierzchni wystawienniczej</p>
                    </div>
                </div>
            </div>
        </div>

        <div id="container-3d" class="pwe-map__container-3d"></div>

    </div>
</div>';