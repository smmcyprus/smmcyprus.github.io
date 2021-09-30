<?php
class Coinmotion_Widget_Currency_Details extends WP_Widget {

	const CURRENCIES = ['BTC', 'LTC', 'ETH', 'XRP', 'XLM'];
	var $types = ['price', 'interest'];
	
 	public function __construct() {
 		$options = array(
 			'classname' => 'coinmotion_widget_currency_details',
 			'description' => __( 'Sidebar widget to display historical data.', 'coinmotion' )
 		);
 		$widget_title = __( 'Coinmotion: Historical Data', 'coinmotion' );
 		parent::__construct(
 			'coinmotion_widget_currency_details', $widget_title, $options
 		);
 	}

 	// Contenido del widget
 	public function widget( $args, $instance ) {
 		$params = coinmotion_get_widget_currency_details_data();
 		$curren = new CoinmotionGetCurrencies();
 		$actual_currency = coinmotion_get_widget_data();
 		$actual_curr_value = floatval($curren->getCotization($actual_currency['default_currency']));
 		echo $args['before_widget'];

 		//Título del widget por defecto
 		if ( ! empty( $instance[ 'title' ] ) ) {
 		  echo $args[ 'before_title' ] . apply_filters( 'widget_title', $instance[ 'title' ] ) . $args[ 'after_title' ];
 		}
 		if ( ! empty( $instance[ 'title' ] ) ) {
 		  $params['title'] = $instance[ 'title' ];
 		}
 		if ( ! empty( $instance[ 'currency' ] ) ) {
 		  $params['currency'] = $instance[ 'currency' ];
 		}
 		if ( ! empty( $instance[ 'type' ] ) ) {
 		  $params['type'] = $instance[ 'type' ];
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
 		$data = $comm->getDetails($params['currency'], $params['type']);

		echo "<div style='background-color: ".$params['background_color']."; padding: 0px 20px 0px 20px;'>";
 		//Contenido
 		echo "<h3 style='background-color: ".$params['background_color'].";margin-bottom: 0px; color: ".$params['text_color'].";'><img style='margin-top: -5px; width: 36px; height: 36px; margin-right: 10px; vertical-align: middle;' src='".plugin_dir_url( __FILE__ ).'../public/imgs/'.strtolower($params['currency']).".svg' /><br/><strong>".getFormattedData($data['actual_price']*$actual_curr_value)." ".strtoupper($actual_currency['default_currency'])."</strong></h3>";
 		$var_day = getFormattedData(floatval($data['variation_day']));
 		$var_week = getFormattedData(floatval($data['variation_week']));
 		$var_month = getFormattedData(floatval($data['variation_month']));
 		$var_3_months = getFormattedData(floatval($data['variation_3_months']));
 		$var_year = getFormattedData(floatval($data['variation_year']));
 		echo "<table width='100%' style='margin-bottom:0px; background-color: ".$params['background_color'].";'>";
 		echo "<tr><td><p style='background-color: ".$params['background_color'].";font-size: 0.75rem; text-align: left; font-weight: lighter; color: ".$params['text_color']."; margin-bottom: 0px;'>".__('Open day', 'coinmotion').": ".getFormattedData($data['open_day']*$actual_curr_value)."</p></td></tr>";
 		echo "<tr>";
 		echo "<td style='background-color: ".$params['background_color'].";'>";
 		$color = "black";
 		if ($var_day > 0)
 			$color = "green";
 		else if ($var_day < 0)
 			$color = "red";
 		echo "<p style='font-size:1.08rem; font-weight: light; text-align: left; margin-bottom: 0px; color: ".$params['text_color'].";'>1 ".__('Day', 'coinmotion')." <span style=' color: ".$color.";'>".$var_day."%</span></p>";

 		$color = "black";
 		if ($var_week > 0)
 			$color = "green";
 		else if ($var_week < 0)
 			$color = "red";
 		echo "<p style='font-size: 1.08rem; font-weight: light; text-align: left; margin-bottom: 0px; color: ".$params['text_color'].";'>1 ".__('Week', 'coinmotion')." <span style=' color: ".$color.";'>".$var_week."%</span></p>";

 		$color = "black";
 		if ($var_month > 0)
 			$color = "green";
 		else if ($var_month < 0)
 			$color = "red";
 		echo "<p style='font-size: 1.08rem; font-weight: light; text-align: left; margin-bottom: 0px; color: ".$params['text_color'].";'>1 ".__('Month', 'coinmotion')." <span style=' color: ".$color.";'>".$var_month."%</span></p>";
 		$color = "black";
 		if ($var_3_months > 0)
 			$color = "green";
 		else if ($var_3_months < 0)
 			$color = "red";
 		echo "<p style='font-size: 1.08rem; font-weight: light; text-align: left; margin-bottom: 0px; color: ".$params['text_color'].";'>".__('3 Months', 'coinmotion')." <span style=' color: ".$color.";'>".$var_3_months."%</span></p>";

 		$color = "black";
 		if ($var_year > 0)
 			$color = "green";
 		else if ($var_year < 0)
 			$color = "red";
 		echo "<p style='font-size: 1.08rem; font-weight: light; text-align: left; margin-bottom: 0px; color: ".$params['text_color'].";'>1 ".__('Year', 'coinmotion')." <span style=' color: ".$color.";'>".$var_year."%</span></p>";
 		echo "</td>";
 		echo "</tr>";
 		echo "</table>"; 		

 		echo "<table width='100%' style='background-color: ".$params['background_color'].";'>";
 		echo "<tr><td width='33%' style='background-color: ".$params['background_color'].";'></td><td width='33%' align='center' style=' color: ".$params['text_color']."; font-weight: bold;'>".__('Low', 'coinmotion')."</td><td align='center' width='33%' style=' color: ".$params['text_color'].";font-weight: bold;'>".__('High', 'coinmotion')."</td></tr>";
 		echo "<tr><td style='background-color: ".$params['background_color']."; color: ".$params['text_color'].";font-weight: bold; font-size: 1.08rem;'>1 ".__('Day', 'coinmotion')."</td><td align='right' style='font-weight:  lighter;  color: ".$params['text_color'].";'>".getFormattedData($data['lower_day'])."</td><td align='right' style='font-weight: lighter;  color: ".$params['text_color'].";'>".getFormattedData($data['higher_day'])."</td></tr>";
 		echo "<tr><td style='background-color: ".$params['background_color']."; color: ".$params['text_color']."; font-weight: bold; font-size: 1.08rem;'>1 ".__('Week', 'coinmotion')."</td><td align='right' style='font-weight:  lighter;  color: ".$params['text_color'].";'>".getFormattedData($data['lower_week'])."</td><td align='right' style='font-weight: lighter;  color: ".$params['text_color'].";'>".getFormattedData($data['higher_week'])."</td></tr>";
 		echo "<tr><td style='background-color: ".$params['background_color']."; color: ".$params['text_color']."; font-weight: bold; font-size: 1.08rem;'>1 ".__('Month', 'coinmotion')."</td><td align='right' style='font-weight:  lighter;  color: ".$params['text_color'].";'>".getFormattedData($data['lower_month'])."</td><td align='right' style='font-weight:  lighter;  color: ".$params['text_color'].";'>".getFormattedData($data['higher_month'])."</td></tr>";
 		echo "<tr><td style='background-color: ".$params['background_color']."; color: ".$params['text_color']."; font-weight: bold; font-size: 1.08rem;'>".__('3 Months', 'coinmotion')."</td><td align='right' style='font-weight:  lighter;  color: ".$params['text_color'].";'>".getFormattedData($data['lower_3_months'])."</td><td align='right' style='font-weight:  lighter;  color: ".$params['text_color'].";'>".getFormattedData($data['higher_3_months'])."</td></tr>";
 		echo "<tr><td style='background-color: ".$params['background_color']."; color: ".$params['text_color']."; font-weight: bold; font-size: 1.08rem;'>1 ".__('Year', 'coinmotion')."</td><td align='right' style='font-weight:  lighter;  color: ".$params['text_color'].";'>".getFormattedData($data['lower_year'])."</td><td align='right' style='font-weight:  lighter;  color: ".$params['text_color'].";'>".getFormattedData($data['higher_year'])."</td></tr>";
 		echo "</table>";
 		echo "</div>";
 		$button = new Coinmotion_Affiliate_Button();
		echo $button->generateCMLink('historical_data');
		if ($params['show_button'] === 'true'){			
 			echo $button->generateButton();	
 		}
 		
 		echo $args[ 'after_widget' ];
 	}

 	//Formulario widget
	public function form( $instance ) {
		$defaults = coinmotion_get_widget_currency_details_data();
	  	if ( ! empty( $instance[ 'title' ] ) )
	  		$defaults['title'] =  $instance[ 'title' ];

	  	if ( ! empty( $instance[ 'currency' ] ) )
	  		$defaults['currency'] = $instance[ 'currency' ];

	  	if ( ! empty( $instance[ 'type' ] ) )
	  		$defaults['type'] = $instance[ 'type' ];

	  	if ( ! empty( $instance[ 'background_color' ] ) )
	  		$defaults['background_color'] = $instance[ 'background_color' ];

	  	if ( ! empty( $instance[ 'text_color' ] ) )
	  		$defaults['text_color'] = $instance[ 'text_color' ];

	  	if ( ! empty( $instance[ 'show_button' ] ) )
	  		$defaults['show_button'] = $instance[ 'show_button' ];

	  	$widget_title = __( 'Historical Data Title', 'coinmotion' );
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
	  		<legend><strong><?= __('Data Options', 'coinmotion') ?></strong></legend>
	  		<table>	  			
	  			<tr>
					<td>
						<label for="<?= $this->get_field_id( 'currency' ) ?>">
						<?= __( 'Crypto', 'coinmotion' ); ?>
						</label> 
				 			
						<select class="coinmotion_widefat_coin2" 
						  id="<?= $this->get_field_id( 'currency' ) ?>" 
						  name="<?= $this->get_field_name( 'currency' ) ?>" >
						  <?php
				          foreach (self::CURRENCIES as $c){
				          	if ($c === $defaults['currency']){
				            ?>
				            	<option value="<?= $c ?>" selected><?= $c ?></option>
				            <?php
				            }
				            else{
				            ?>
				            	<option value="<?= $c ?>"><?= $c ?></option>
				            <?php
				            }
				          }
				          ?>       
						</select>
					</td>
					<td>
						<label for="<?= $this->get_field_id( 'type' ) ?>">
						<?= __( 'Type', 'coinmotion' ); ?>
						</label> 
				 			
						<select class="coinmotion_widefat_coin2" 
						  id="<?= $this->get_field_id( 'type' ) ?>" 
						  name="<?= $this->get_field_name( 'type' ) ?>" >
						  <?php
				          foreach ($this->types as $t){
				          	if ($t === $defaults['type']){
				            ?>
				            	<option value="<?= $t ?>" selected><?= ucfirst(__(strtolower($t), 'coinmotion')) ?></option>
				            <?php
				            }
				            else{
				            ?>
				            	<option value="<?= $t ?>"><?= ucfirst(__(strtolower($t), 'coinmotion'))  ?></option>
				            <?php
				            }
				          }
				          ?>       
						</select>
					</td>
					
				</tr>
			</table>
		</fieldset>
		<fieldset style="margin-top: 20px;">
	  		<legend><strong><?= __('Design Options', 'coinmotion') ?></strong></legend>
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
				 			$checked = "";
				 			if ($defaults['show_button'] == 'true')
				 				$checked = " checked ";
				 			?>
						<input 
						  class="coinmotion_widefat_coin2" 
						  id="<?= $this->get_field_id( 'show_button' ) ?>" 
						  name="<?= $this->get_field_name( 'show_button' ) ?>" 
						  type="checkbox"
						  value='show_button' 
						  <?= $checked ?>>
					</td>
				</tr>
			</table>
		</fieldset>		  
	  	<?php
 	}
 	
 	function update( $new_instance, $old_instance ) {
 		$instance = $old_instance;
 		$instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
 		$instance[ 'type' ] = strip_tags( $new_instance[ 'type' ] );
 		$instance[ 'currency' ] = strip_tags( $new_instance[ 'currency' ] );
		$instance[ 'background_color' ] = strip_tags( $new_instance[ 'background_color' ] );
		$instance[ 'text_color' ] = strip_tags( $new_instance[ 'text_color' ] );
 		if ($new_instance[ 'show_button' ] === 'show_button')
 			$instance[ 'show_button' ] = 'true';
 		else
 			$instance[ 'show_button' ] = 'false';
 		return $instance;
 	}
}
?>