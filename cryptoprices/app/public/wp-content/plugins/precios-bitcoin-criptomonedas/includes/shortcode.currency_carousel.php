<?php

function coinmotion_create_box($currency, $color, $data, $text_color, $percent, $actual_currency, $background_color, $rand){
    
    return "<div style='padding-bottom: 0.3rem;'>
            <table style='border: 0px;'>
            <tr>
                <td style='border: 0; padding: 5px; margin:0; background-color: ".$background_color." !important'>
                <img id='coinmotion_img_crypto_side".$rand."' style='' src='".plugin_dir_url( __FILE__ ).'../public/imgs/'.strtolower($currency).".svg' />
                </td>
                <td style='border: 0; padding: 5px; margin:0; background-color: ".$background_color." !important;'>
                <img id='coinmotion_img_crypto_top".$rand."' style='' src='".plugin_dir_url( __FILE__ ).'../public/imgs/'.strtolower($currency).".svg' />
                     
                </td>
                <td style='border: 0; padding: 0px 0px 0px 0px; margin:0; background-color: ".$background_color." !important; text-align: left;'>
                    <span id='coinmotion_data".$rand."' style='font-size: 0.8rem; color: ".$color."; font-weight: bold;'><span style='color: ".$text_color."'
                    >".$data." ".strtoupper($actual_currency['default_currency'])."</span></span></span><br/><span style='font-size: 12px; font-weight: bold; color: ".$color."'>".$percent."</span>
                </td>
            </tr>
            
            </table>
    </div>
    <style>
    #coinmotion_img_crypto_side".$rand."{
        margin-top: -5px;
        width: 2.5rem;
        height: auto;
    }

    #coinmotion_img_crypto_top".$rand."{
        display: none;
        margin-top: -5px;
        width: 36px;
        height: 36px;
    }

    #coinmotion_data_crypto_top".$rand."{
        display: none;
    }

    @media (max-width: 480px) {
      #coinmotion_img_crypto_side".$rand."{
        display: none;
      }
      #coinmotion_img_crypto_top".$rand."{
        display: block;
      }
      #coinmotion_data_crypto_top".$rand."{
        display: block;
      }
      #coinmotion_data_crypto_side".$rand."{
        display: none;
      }
      #coinmotion_data".$rand."{
        display: block;
      }
    }
    </style>";
}

/**
 * Configuracion: title, background, orientation y text_color
 * 
 * 
 */
function coinmotion_currency_carousel_shortcode($atts = [])
{	
    //
    $rand = rand();
    $atts = array_change_key_case((array)$atts, CASE_LOWER);
    $curren = new CoinmotionGetCurrencies();
    $actual_currency = coinmotion_get_widget_data();
    $actual_curr_value = floatval($curren->getCotization($actual_currency['default_currency']));
    $coinmotion_atts = shortcode_atts(['title' => 'Coinmotion'], $atts, 'coinmotion');
    $orientation = "HORIZONTAL";
    $text_color = "black";
    $background_color = "none";
    $show_button = "off";

    if (isset($atts['text_color'])) 
        $text_color = $atts['text_color'];
    
    if (isset($atts['orientation']))
        $orientation = $atts['orientation'];

    if (isset($atts['background'])){
        $background_color = $atts['background'];
    }

    if (isset($atts['show_button'])){
        $show_button = $atts['show_button'];
    }

    if (isset($atts['cryptos'])){
        $currencies = explode(",", $atts['cryptos']);
    }
    else{
        $currencies = ['btc', 'ltc', 'eth', 'xrp', 'xlm'];
    }
    $currencies = array_map( 'strtolower', $currencies ); 
    // Get data from API
    $comm = new CoinmotionComm();
    $data = json_decode($comm->getRates());
    
    $output = "";
    $string = "";    
    $total_cryptos = count($currencies);
    if (strtoupper($orientation) === "HORIZONTAL"){
        $css_output = "<style>#coinmotion_currency_carousel".$rand." {
            display: table;
            table-layout: fixed;        
            width:".((100*$total_cryptos)/5)."%;
            height:56px;
            padding: 20px;
            background-color: ".$background_color.";
        }
        #coinmotion_currency_carousel".$rand." div {
            display: table-cell;
            height:56px;
        }</style>";
    }
    else{
        $css_output = "<style>#coinmotion_currency_carousel".$rand." {
            width: 165px;
            padding: 5px;
            background-color: ".$background_color.";
        }
        #coinmotion_currency_carousel".$rand." div{
         margin-top: 5px;
         margin-bottom: 5px;
        }</style>";
    }

    if (in_array('btc', $currencies)){
        if (floatval($data->btcEur->changeAmount) > 0){
            $color = "green";
        }
        elseif (floatval($data->btcEur->changeAmount) == 0){
            $color = "black";
        }
        else{
            $color = "red";
        }
        $string = coinmotion_create_box('BTC', $color, getFormattedData(floatval($data->btcEur->fbuy2)*$actual_curr_value), $text_color, $data->btcEur->fchangep, $actual_currency, $background_color, $rand);
    }
    
    if (in_array('ltc', $currencies)){
        if (floatval($data->ltcEur->changeAmount) > 0){
            $color = "green";
        }
        elseif (floatval($data->ltcEur->changeAmount) == 0){
            $color = "black";
        }
        else{
            $color = "red";
        }
        $string .= coinmotion_create_box('LTC', $color, getFormattedData(floatval($data->ltcEur->fbuy2)*$actual_curr_value), $text_color, $data->ltcEur->fchangep, $actual_currency, $background_color, $rand);
    }

    if (in_array('eth', $currencies)){
        if (floatval($data->ethEur->changeAmount) > 0){
            $color = "green";
        }
        elseif (floatval($data->ethEur->changeAmount) == 0){
            $color = "black";
        }
        else{
            $color = "red";
        }
        $string .= coinmotion_create_box('ETH', $color, getFormattedData(floatval($data->ethEur->fbuy2)*$actual_curr_value), $text_color, $data->ethEur->fchangep, $actual_currency, $background_color, $rand);
    }

    if (in_array('xrp', $currencies)){
        if (floatval($data->xrpEur->changeAmount) > 0){
            $color = "green";
        }
        elseif (floatval($data->xrpEur->changeAmount) == 0){
            $color = "black";
        }
        else{
            $color = "red";
        }
        $string .= coinmotion_create_box('XRP', $color, getFormattedData(floatval($data->xrpEur->fbuy2)*$actual_curr_value), $text_color, $data->xrpEur->fchangep, $actual_currency, $background_color, $rand);
    }
    
    if (in_array('xlm', $currencies)){
        if (floatval($data->xlmEur->changeAmount) > 0){
            $color = "green";
        }
        elseif (floatval($data->xlmEur->changeAmount) == 0){
            $color = "black";
        }
        else{
            $color = "red";
        }
        $string .= coinmotion_create_box('XLM', $color, getFormattedData(floatval($data->xlmEur->fbuy2)*$actual_curr_value), $text_color, $data->xlmEur->fchangep, $actual_currency, $background_color, $rand);
    }
    $button = new Coinmotion_Affiliate_Button();
    //$string .= "<div style='display: flow-root; height: auto;'>";
    if (strtoupper($orientation) === "VERTICAL"){
        $string .= "<div style='display: flow-root; height: auto;'>";
        $string .= $button->generateCMLink('currency_carousel');
        if ($show_button === "on"){
            $string .= $button->generateButton(); 
        } 
        $string .= "</div>";
    }
    else{
        $string .= "<div style='display: table-footer-group; height: auto;'>";
        if ($show_button === "on"){
            $string .= $button->generateButton(); 
        } 
        $string .= "</div>";
    }
       
    
    $output .= "<h4>".$atts['title']."</h4>";
    $output .= "<div id='coinmotion_currency_carousel".$rand."'>".$string."</div>";

    
    
    
    return $css_output.$output;
} 
?>