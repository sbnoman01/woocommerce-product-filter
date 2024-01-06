<?php

class Class_ShortCode{
    public function __construct(){
    }
    
    public function wc_product_slider( $atts) {

        $vars = shortcode_atts( array(
            'type' => 'doors'
        ), $atts );

        $path = plugin_dir_path(__DIR__) . 'public/partials/wc-product-slider-display.php';
        
        if( file_exists($path) ){
            require $path;
            return wc_proudct_slider_display($vars);
        }
    }
    public function wc_product_filter($atts) {

        $vars = shortcode_atts( array(
            'type' => 'doors'
        ), $atts );

        $path = plugin_dir_path(__DIR__) . 'public/partials/wc-product-filter-display.php';
        
        if( file_exists($path) ){
            require $path;
            return wc_proudct_filter_display($vars);
        }
    }
}