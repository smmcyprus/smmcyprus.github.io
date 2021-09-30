<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

echo '<div class="ccpw-wrapper ccpw-price-label ccpw-bg">
    <ul class="lbl-wrapper">
        <li id="'.$coin_id.'">
            <div class="coin-container">
                <span class="ccpw_icon">';
                echo  $coin_logo_html;
                echo '</span>
                <span class="name ccpw-primary">'.$coin_name.'</span>
                <span class="price ccpw-secondary">'.$price.'</span>';
                if($display_24h_changes == 'yes'){
                    echo ccpw_changes_up_down($change_24_h); 
                }
            echo '</div>
        </li>
   </ul>
</div>';