<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
echo '<div class="ccpw-wrapper ccpw-price-card ccpw-bg">
    <div class="ccpw-inner-section">
        <div class="ccpw-title-section">
            <div class="ccpw-logo-section">
                <div class="ccpw-coin-logo">';
                    echo  $coin_logo_html;
                echo '</div>
                <div class="ccpw-coin-name ccpw-primary">
                    <span>'. $coin_name .'</span>
                </div>';

                if($coin_symbol_visibility == 'yes'){
                    echo '<div class="ccpw-coin-symbol ccpw-primary">
                        <span>'.$symbol.' / '.$fiat_currency.'</span>
                    </div>';
                }              
            echo '</div>

            <div class="ccpw-price-section">
                <div class="ccpw-coin-price">
                    <span class="ccpw-price ccpw-primary">'.$price.'</span>
                </div>';
              
                if($display_24h_changes == 'yes'){
                    echo '<div class="ccpw-price-change">
                        <span class="ccpw-change-percent">'; 
                            echo ccpw_changes_up_down($change_24_h); 
                        echo '</span>
                    </div>';
                }
            echo '</div>
        </div>

        <div class="ccpw-coin-info ccpw-secondary">';
            if($display_rank == 'yes'){
                echo '<div class="ccpw-info-item">
                    <span class="ccpw-item-label">'.__('Rank:','ccpw').'</span>
                    <span class="ccpw-item-value"># '.$rank.'</span>
                </div>';
            }
          
            if($display_1h_changes == 'yes'){
                echo '<div class="ccpw-info-item">
                   <span class="ccpw-item-label">'.__('1H change:','ccpw').'</span>
                   <span class="ccpw-item-value">'.ccpw_changes_up_down($change_1h).'</span>
                </div>';                
            }
            if($display_24h_changes == 'yes'){
                echo '<div class="ccpw-info-item">
                    <span class="ccpw-item-label">'.__('24H change:','ccpw').'</span>
                    <span class="ccpw-item-value">'.ccpw_changes_up_down($change_24h).'</span>
                </div>';                
            }
            if($display_7d_changes == 'yes'){
                echo '<div class="ccpw-info-item">
                   <span class="ccpw-item-label">'.__('7d change:','ccpw').'</span>
                   <span class="ccpw-item-value">'.ccpw_changes_up_down($change_7d).'</span>
                </div>';                
            }
            if($display_30d_changes == 'yes'){
                echo '<div class="ccpw-info-item">
                    <span class="ccpw-item-label">'.__('30d change:','ccpw').'</span>
                    <span class="ccpw-item-value">'.ccpw_changes_up_down($change_30d).'</span>
                </div>';                
            }
            if($display_marketcap == 'yes'){
                echo '<div class="ccpw-info-item">
                    <span class="ccpw-item-label">'.__('Market Cap:','ccpw').'</span>
                    <span class="ccpw-item-value">'.$market_cap.'</span>
                </div>';
            }
            if($display_high_low == 'yes'){
                echo '<div class="ccpw-info-item">
                    <span class="ccpw-item-label">'.__('24H High/Low','ccpw').'</span>
                    <span class="ccpw-item-value">'.$high_24h.'/'.$low_24h.'</span>
                </div>';
            }
               
        echo '</div>
    </div>
</div>';