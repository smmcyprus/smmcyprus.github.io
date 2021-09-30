<?php
class Coinmotion_Widget_Currency_Conversor extends WP_Widget {

	const CURRENCIES = ['btcEur', 'ltcEur', 'ethEur', 'xrpEur', 'xlmEur'];
	const CURRENCIES_DISPLAY = ['BTC', 'LTC', 'ETH', 'XRP', 'XLM'];
	
 	public function __construct() {
 		$options = array(
 			'classname' => 'coinmotion_widget_currency_conversor',
 			'description' => __( 'Sidebar widget to display currency conversor.', 'coinmotion' )
 		);
 		$widget_title = __( 'Coinmotion: Currency/Crypto Conversor', 'coinmotion' );
 		parent::__construct(
 			'coinmotion_widget_currency_conversor', $widget_title, $options
 		);
 	}

 	// Contenido del widget
 	public function widget( $args, $instance ) {
 		$params = coinmotion_get_widget_currency_conversor_data();
 		$curren = new CoinmotionGetCurrencies();
 		$actual_currency = coinmotion_get_widget_data();
 		
 		$actual_curr_value = floatval($curren->getCotization($actual_currency['default_currency']));
 		echo $args['before_widget'];

 		//Título del widget por defecto
 		if ( ! empty( $instance[ 'title' ] ) ) {
 		  echo $args[ 'before_title' ] . apply_filters( 'widget_title', $instance[ 'title' ] ) . $args[ 'after_title' ];
 		}
 		
 		if ( ! empty( $instance[ 'background_color' ] ) ) {
 		  $params['background_color'] = $instance[ 'background_color' ];
 		}
 		if ( ! empty( $instance[ 'text_color' ] ) ) {
 		  $params['text_color'] = $instance[ 'text_color' ];
 		}
 		if ( ! empty( $instance[ 'show_button' ] ) ) {
 		  $params['show_button'] = $instance[ 'show_button' ];
 		}

 		$comm = new CoinmotionComm();
 		$data = json_decode($comm->getRates(), true);

 		//Contenido
 		
 		$select = "";
 		for ($i = 0; $i < count(Coinmotion_Widget_Currency_Conversor::CURRENCIES); $i++){
			 $curr = Coinmotion_Widget_Currency_Conversor::CURRENCIES[$i];
			 $curr_display = Coinmotion_Widget_Currency_Conversor::CURRENCIES_DISPLAY[$i];
 			//echo "var ".$curr."=".$data[$curr]['buy'].";";
 			if ($i === 0)
 				$select .= "<option selected value='".($data[$curr]['buy']*$actual_curr_value)."'>".strtoupper($curr_display)."</value>";
 			else
 				$select .= "<option value='".($data[$curr]['buy']*$actual_curr_value)."'>".strtoupper($curr_display)."</value>";
		}
		$rand = rand();
		echo "<script>";
 		echo "jQuery(document).ready(function(){
 			jQuery('#coinmotion_conv_input".$rand."').on('change paste keyup', function(){
				input = jQuery('#coinmotion_conv_input".$rand."').val();
				
				if ((input === '') || (input === undefined))
					input = 1;
 				jQuery('#coinmotion_conv_output".$rand."').val(					 
 					(Number.parseFloat( input ) / 
 					Number.parseFloat( jQuery('#coinmotion_change_currency".$rand."').val() )).toFixed(4)
 				);
 			});

 			jQuery('#coinmotion_conv_output".$rand."').on('change paste keyup', function(){
				input = jQuery('#coinmotion_conv_output".$rand."').val();
				
				if ((input === '') || (input === undefined))
					input = 1;
 				jQuery('#coinmotion_conv_input".$rand."').val(					 
 					(Number.parseFloat( input ) *
 					Number.parseFloat( jQuery('#coinmotion_change_currency".$rand."').val() )).toFixed(4)
 				);
 			});

 			jQuery('.select-selected".$rand."').bind('DOMSubtreeModified', function(){
				input = jQuery('#coinmotion_conv_input".$rand."').val();
				
				if ((input === '') || (input === undefined))
					input = 1;
 				jQuery('#coinmotion_conv_output".$rand."').val(					
 					(Number.parseFloat( input ) /
 					Number.parseFloat( jQuery('#coinmotion_change_currency".$rand."').val() )).toFixed(4)
 				);
 			});
 		})";
 		echo "</script>";

		echo "<style>#coinmotion_conversor".$rand." {
            display: table;
            table-layout: fixed;        
            width:100%;
            padding: 10px;
            background-color: ".$params['background_color'].";
            color: ".$params['text_color']."
		}
		#coinmotion_conversor".$rand." input{
            background-color: ".$params['background_color'].";
            color: ".$params['text_color'].";
            border-top: 0;
            border-right: 0;
            border-left: 0;
            box-shadow: 0px;
            font-size: 14px;
            width: 100%;
        }
        #coinmotion_conversor".$rand." td, th{
            border: 0px;
            background-color: ".$params['background_color'].";
        }
        div.coinmotion_conversor_line".$rand." {
            display: table-cell;
		}
		input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
			-webkit-appearance: none;
			margin: 0;
		}

		input[type=number] {
			-moz-appearance: textfield;
		}</style>";

		echo "<style>";
		echo " .custom-select".$rand." {
		  position: relative;
		  font-family: Arial;
		}
		
		.custom-select".$rand." select {
		  display: none;
		}
		
		.select-selected".$rand." {
			background-color: ".$params['background_color'].";
            color: ".$params['text_color'].";
			text-align: center;
		}

		.select-selected".$rand.":after {
		  position: absolute;
		  content: '';
		  top: 17px;
		  right: 0px;
		  width: 0;
		  height: 0;
		  border: 6px solid transparent;
		  border-color: ".$params['text_color']." transparent transparent transparent;
		}
		
		.select-selected".$rand.".select-arrow-active".$rand.":after {
		  border-color: transparent transparent ".$params['text_color']." transparent;
		  top: 7px;
		}
		
		.select-items".$rand." div,.select-selected".$rand." {
		  color: ".$params['text_color'].";
		  padding: 8px 16px;
		  border: 1px solid transparent;
		  /*border-color: transparent transparent rgba(0, 0, 0, 0.1) transparent;*/
		  cursor: pointer;
		  font-size: 13px;
		}
		
		.select-items".$rand." {
		  position: absolute;
		  background-color: ".$params['background_color'].";
		  top: 100%;
		  left: 0;
		  right: 0;
		  z-index: 99;
		}
		
		.select-hide".$rand." {
		  display: none;
		}
		
		.select-items".$rand." div:hover, .same-as-selected".$rand." {
		  background-color: rgba(0, 0, 0, 0.1);
		} ";

		echo "</style>";
		
		echo "<div id='coinmotion_conversor".$rand."'><table width='100%'>";
			echo "<tr>";
				echo "<td style=' background-color: ".$params['background_color'].";' width='85%'><input placeholder='".($actual_curr_value*$data[Coinmotion_Widget_Currency_Conversor::CURRENCIES[0]]['buy'])."' type='number' step='any' id='coinmotion_conv_input".$rand."' name='coinmotion_conv_input".$rand."' value='".($actual_curr_value*$data[Coinmotion_Widget_Currency_Conversor::CURRENCIES[0]]['buy'])."' /></td>";
				echo "<td width='50%' style='text-align: center; color: ".$params['text_color']."; vertical-align: middle;'>".$actual_currency['default_currency']."</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td style=' background-color: ".$params['background_color'].";' width='15%'><input type='number' step='any' id='coinmotion_conv_output".$rand."' name='coinmotion_conv_output".$rand."' placeholder='1' value='1' /></td>";
				echo "<td width='50%'><div class='custom-select".$rand."'><select id='coinmotion_change_currency".$rand."'>".$select."</select></div></td>";
			echo "</tr>";
		echo "</table></div>";
		echo '<script>';
		echo 'var x, i, j, selElmnt, a, b, c;
		x = document.getElementsByClassName("custom-select'.$rand.'");
		for (i = 0; i < x.length; i++) {
		  selElmnt = x[i].getElementsByTagName("select")[0];
		  a = document.createElement("DIV");
		  a.setAttribute("class", "select-selected'.$rand.'");
		  a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
		  x[i].appendChild(a);
		  b = document.createElement("DIV");
		  b.setAttribute("class", "select-items'.$rand.' select-hide'.$rand.'");
		  for (j = 0; j < selElmnt.length; j++) {
			c = document.createElement("DIV");
			c.innerHTML = selElmnt.options[j].innerHTML;
			c.addEventListener("click", function(e) {
				var y, i, k, s, h;
				s = this.parentNode.parentNode.getElementsByTagName("select")[0];
				h = this.parentNode.previousSibling;
				for (i = 0; i < s.length; i++) {
				  if (s.options[i].innerHTML == this.innerHTML) {
					s.selectedIndex = i;
					h.innerHTML = this.innerHTML;
					y = this.parentNode.getElementsByClassName("same-as-selected'.$rand.'");
					for (k = 0; k < y.length; k++) {
					  y[k].removeAttribute("class");
					}
					this.setAttribute("class", "same-as-selected'.$rand.'");
					break;
				  }
				}
				h.click();
			});
			b.appendChild(c);
		  }
		  x[i].appendChild(b);
		  a.addEventListener("click", function(e) {
			e.stopPropagation();
			closeAllSelect(this);
			this.nextSibling.classList.toggle("select-hide'.$rand.'");
			this.classList.toggle("select-arrow-active");
		  });
		}
		
		function closeAllSelect(elmnt) {
		  var x, y, i, arrNo = [];
		  x = document.getElementsByClassName("select-items'.$rand.'");
		  y = document.getElementsByClassName("select-selected'.$rand.'");
		  for (i = 0; i < y.length; i++) {
			if (elmnt == y[i]) {
			  arrNo.push(i)
			} else {
			  y[i].classList.remove("select-arrow-active'.$rand.'");
			}
		  }
		  for (i = 0; i < x.length; i++) {
			if (arrNo.indexOf(i)) {
			  x[i].classList.add("select-hide'.$rand.'");
			}
		  }
		}
		
		document.addEventListener("click", closeAllSelect); ';
		echo '</script>';
		$button = new Coinmotion_Affiliate_Button();
		echo $button->generateCMLink('currency_crypto_conversor');
		if ($params['show_button'] === 'true'){			
 			echo $button->generateButton();	
 		}
 		
		echo $args[ 'after_widget' ];
 	}

 	//Formulario widget
	public function form( $instance ) {
		$defaults = coinmotion_get_widget_currency_conversor_data();

	  	if ( ! empty( $instance[ 'title' ] ) )
	  		$defaults['title'] =  $instance[ 'title' ];

	  	if ( ! empty( $instance[ 'background_color' ] ) )
	  		$defaults['background_color'] = $instance[ 'background_color' ];

	  	if ( ! empty( $instance[ 'text_color' ] ) )
	  		$defaults['text_color'] = $instance[ 'text_color' ];

	  	if ( ! empty( $instance[ 'show_button' ] ) )
	  		$defaults['show_button'] = $instance[ 'show_button' ];

	  	$widget_title = __( 'Currency/Crypto Conversor Title', 'coinmotion' );
	  	?>
	  	<!-- Estructura formulario-->
	  	<table style="margin-top: 10px;">
	  		<tr>
	  			<td>	  				
	  				<label for="<?= $this->get_field_id( 'title' ) ?>">
						<strong><?= __('Widget Title', 'coinmotion') ?></strong>
					</label> 
			 			
					<input 
					  class="coinmotion_widefat_coin2" 
					  id="<?= $this->get_field_id( 'title' ) ?>" 
					  name="<?= $this->get_field_name( 'title' ) ?>" 
					  type="text" 
					  value="<?= $defaults['title']; ?>">
	  			</td>
	  		</tr>
	  	</table>	
	  	<fieldset style="margin-top: 20px;">
	  		<legend><strong><?= __( 'Design Options', 'coinmotion' ) ?></strong></legend>
	  		<table>
	  		<tr>
	  			<td>
	  				<label for="<?= $this->get_field_id( 'text_color' ) ?>">
						<?= __('Text<br/>Color', 'coinmotion') ?>
					</label> 
			 			
					<input 
					  class="coinmotion_widefat_coin2" 
					  id="<?= $this->get_field_id( 'text_color' ) ?>" 
					  name="<?= $this->get_field_name( 'text_color' ) ?>" 
					  type="color" 
					  value="<?= $defaults['text_color'] ?>"
					  style="height: 30px; width: 45px; display: table;">
	  			</td>
	  			<td>
	  				<label for="<?= $this->get_field_id( 'background_color' ) ?>">
						<?= __('Background<br/>Color', 'coinmotion') ?>
					</label> 
			 			
					<input 
					  class="coinmotion_widefat_coin2" 
					  id="<?= $this->get_field_id( 'background_color' ) ?>" 
					  name="<?= $this->get_field_name( 'background_color' ) ?>" 
					  type="color" 
					  value="<?= $defaults['background_color'] ?>"
					  style="height: 30px; width: 45px; display: table;">
	  			</td>
	  		</tr>
	  		<tr>
	  			<td colspan="2">
	  				<label for="<?= $this->get_field_id( 'show_button' ) ?>">
						<?= __('Show<br/>Coinmotion Button', 'coinmotion') ?>
					</label> 
			 			<?php
			 			$checkbox = "";
			 			if ($defaults['show_button'] === 'true'){
			 				$checkbox = " checked ";
			 			} 
			 			?>
					<input 
					  class="coinmotion_widefat_coin2" 
					  id="<?= $this->get_field_id( 'show_button' ) ?>" 
					  name="<?= $this->get_field_name( 'show_button' ) ?>" 
					  type="checkbox" 
					  value="show_button"
					  <?= $checkbox ?>>
	  			</td>
	  			<td>	  				
	  			</td>
	  		</tr>
	  	</table>
	  	</fieldset>  	
	  	<?php
 	}
 	
 	function update( $new_instance, $old_instance ) {
 		$instance = $old_instance;
 		$instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
 		$instance[ 'background_color' ] = strip_tags( $new_instance[ 'background_color' ] );
 		$instance[ 'text_color' ] = strip_tags( $new_instance[ 'text_color' ] );
 		$instance[ 'show_button' ] = strip_tags( $new_instance[ 'show_button' ] );
 		if ($new_instance['show_button'] === 'show_button')
 			$instance[ 'show_button' ] = 'true';
 		else
 			$instance[ 'show_button' ] = 'false';
 		return $instance;
 	}
}
?>