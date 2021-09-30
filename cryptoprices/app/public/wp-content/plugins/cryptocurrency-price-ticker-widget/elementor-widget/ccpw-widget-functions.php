<?php
function ccpw_widget_get_coin_data($fiat_currency,$coin_id){
    $coins = array();
   
    $cache = get_transient('ccpw_data_'.$coin_id.$fiat_currency);

    // Avoid updating database if cache exist and same API is requested
    if (false != $cache ) {
        $coin_data = get_transient('ccpw_data_'.$coin_id.$fiat_currency);
        return $coin_data;
    }
    $api_url = 'https://api.coingecko.com/api/v3/coins/markets?vs_currency='.$fiat_currency.'&ids='.$coin_id.'&order=market_cap_desc&per_page=1&page=1&sparkline=false&price_change_percentage=1h%2C24h%2C7d%2C30d';
    $request = wp_remote_get($api_url, array('timeout' => 120, 'sslverify' => false));
    if (is_wp_error($request)) {
        return false; // Bail early
    }
    $body = wp_remote_retrieve_body($request);
    $coin_info = json_decode($body);
    $coin = $coin_info[0];
    $response = array();
    
    $coin_data = array();
    
    $response['coin_id'] = $coin->id;
    $response['rank'] = $coin->market_cap_rank;
    $response['name'] = $coin->name;
    $response['symbol'] = strtoupper($coin->symbol);
    $response['price'] = ccpw_set_default_if_empty($coin->current_price, 0.00);
    $response['percent_change_24h'] = ccpw_set_default_if_empty($coin->price_change_percentage_24h, 0);
    $response['market_cap'] = ccpw_set_default_if_empty($coin->market_cap, 0);
    $response['total_volume'] = ccpw_set_default_if_empty($coin->total_volume);
    $response['circulating_supply'] = ccpw_set_default_if_empty($coin->circulating_supply);
    $response['logo'] = $coin->image;
    $response['high_24h'] = ccpw_set_default_if_empty($coin->high_24h);
    $response['low_24h'] = ccpw_set_default_if_empty($coin->low_24h);
    $response['price_change_percentage_1h'] = ccpw_set_default_if_empty($coin->price_change_percentage_1h_in_currency);
    $response['price_change_percentage_24h'] = ccpw_set_default_if_empty($coin->price_change_percentage_24h_in_currency);
    $response['price_change_percentage_30d'] = ccpw_set_default_if_empty($coin->price_change_percentage_30d_in_currency);
    $response['price_change_percentage_7d'] = ccpw_set_default_if_empty($coin->price_change_percentage_7d_in_currency);
 

    $coin_data[] = $response;
    set_transient('ccpw_data_'.$coin_id.$fiat_currency, $coin_data, 5 * MINUTE_IN_SECONDS);

  return  $coin_data;
   
}

function ccpw_changes_up_down($value){
  $change_class = "up"; 
  $change_sign = '<i class="ccpw_icon-up" aria-hidden="true"></i>';
  $change_sign_minus = "-";
  $changes_html = '';
  if (strpos($value, $change_sign_minus) !== false) {                   

    $change_sign = '<i class="ccpw_icon-down" aria-hidden="true"></i>';
    $change_class = "down";
   
  }
  $changes_html = '<span class="changes ' . $change_class . '">'.$change_sign. $value.'</span>';
  return $changes_html;
}