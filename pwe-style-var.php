<?php

class PWEStyleVar extends PWECommonFunctions {

    public function pwe_enqueue_style_var() {
        echo $this->pwe_style_var();
    }

    public function pwe_style_var() {
        $accent_color = self::pwe_color("accent");
        $accent_darker_color = self::adjustBrightness($accent_color, -20);
        $main2_color = self::pwe_color("main2");
        $main2_darker_color = self::adjustBrightness($main2_color, -20);

        $style = '
        <style>
            :root {
                --accent-color: ' . $accent_color . ';
                --accent_darker_color: ' . $accent_darker_color . ';
                --main2-color: ' . $main2_color . ';
                --main2_darker_color: ' . $main2_darker_color . ';
            }
        </style>';

        return $style;
    }
}

$pwe_style_var = new PWEStyleVar();