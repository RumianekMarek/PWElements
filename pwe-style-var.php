<?php

class PWEStyleVar extends PWECommonFunctions {

    public function pwe_enqueue_style_var() {
        echo $this->pwe_style_var();
    }

    public function pwe_style_var() {
        $accent_color = self::pwe_color("accent");
        $main2_color = self::pwe_color("main2");

        $style = '
        <style>
            :root {
                --accent-color: ' . $accent_color . ';
                --main2-color: ' . $main2_color . ';
            }
        </style>';

        return $style;
    }
}

$pwe_style_var = new PWEStyleVar();
