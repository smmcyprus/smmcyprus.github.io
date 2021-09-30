<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;

class CCPW__Widget extends \Elementor\Widget_Base {

	public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
		wp_register_style( 'ccpw-card', CCPWF_URL  . 'elementor-widget/assets/css/ccpw-card.css', array());
		wp_register_style( 'ccpw-label', CCPWF_URL  . 'elementor-widget/assets/css/ccpw-label.css', array());	
		wp_register_style( 'ccpw-common-styles', CCPWF_URL  . 'elementor-widget/assets/css/ccpw-common-styles.css', array());		
        wp_register_style( 'ccpw-icons-style', CCPWF_URL  . 'assets/css/ccpw-icons.css', array());	        		
	}
 
	 

    public function get_script_depends() {        
        return [];
    }
 
    public function get_style_depends() {	
		if (\Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode()) {
			return ['ccpw-card','ccpw-label','ccpw-icons-style','ccpw-common-styles'];
		}	
		$settings = $this->get_settings_for_display();
		$widget_type = $settings['ccpw_widget_type'];
		$styles = ['ccpw-icons-style','ccpw-common-styles'];

		if($widget_type == 'label'){
			array_push($styles, 'ccpw-label');
		}
		else{
			array_push($styles, 'ccpw-card');
		}
		return $styles;
    }
	
	public function get_name() {
		return 'cryptocurrency-widget-addon';
	}

	public function get_title() {
		return __( 'Cryptocurrency Widget', 'ccpw' );
	}

	public function get_icon() {
		return 'eicon-price-table ccpw-icon';
	}

	public function get_categories() {
		return [ 'ccpw' ];
	}

	protected function _register_controls() {

        $currencies_arr = array(
            'USD' => 'USD',
            'GBP' => 'GBP',
            'EUR' => 'EUR',
            'INR' => 'INR',
            'JPY' => 'JPY',
            'CNY' => 'CNY',
            'ILS' => 'ILS',
            'KRW' => 'KRW',
            'RUB' => 'RUB',
            'DKK' => 'DKK',
            'PLN' => 'PLN',
            'AUD' => 'AUD',
            'BRL' => 'BRL',
            'MXN' => 'MXN',
            'SEK' => 'SEK',
            'CAD' => 'CAD',
            'HKD' => 'HKD',
            'MYR' => 'MYR',
            'SGD' => 'SGD',
            'CHF' => 'CHF',
            'HUF' => 'HUF',
            'NOK' => 'NOK',
            'THB' => 'THB',
            'CLP' => 'CLP',
            'IDR' => 'IDR',
            'NZD' => 'NZD',
            'TRY' => 'TRY',
            'PHP' => 'PHP',
            'TWD' => 'TWD',
            'CZK' => 'CZK',
            'PKR' => 'PKR',
            'ZAR' => 'ZAR',
        );

		$this->start_controls_section(
			'ccpw_general_section',
			[
				'label' => __( 'General Settings', 'ccpw' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'ccpw_widget_type',
			[
				'label' => __( 'Widget Type', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options'=>[
					'card'=>'Card',
					'label'=>'Label',
				], 
                'default' => 'card', 
			]
		);
        
        $this->add_control(
			'ccpw_select_coins',
			[
				'label' => __( 'Select Coins', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => false,
				'options' => ccpw_get_all_coin_ids(),   
                'default' => 'bitcoin', 
			]
		);
	
        $this->add_control(
			'ccpw_fiat_currency',
			[
				'label' => __( 'Select Fiat Currency', 'ccpw' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => false,
				'default' => 'USD',
				'options' => $currencies_arr,
			]
		);    

        $this->add_control(
			'ccpw_number_formating',
			[
				'label' => __( 'Number Formating', 'ccpw' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'ccpw' ),
				'label_off' => __( 'Off', 'ccpw' ),
				'return_value' => 'on',
				'default' => 'on',
			]
		);
		
        $this->add_control(
			'ccpw_display_coin_symbol',
			[
				'label' => __( 'Coin Symbol', 'ccpw' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'ccpw' ),
				'label_off' => __( 'Hide', 'ccpw' ),
				'return_value' => 'yes',
				'default' => 'yes',
                'condition'   => [
					'ccpw_widget_type' => 'card',	
				]
			]
		); 

		$this->add_control(
			'ccpw_display_high_low',
			[
				'label' => __( 'High/Low', 'ccpw' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'ccpw' ),
				'label_off' => __( 'Hide', 'ccpw' ),
				'return_value' => 'yes',
				'default' => 'yes',
                'condition'   => [
					'ccpw_widget_type' => 'card',	
				]
			]
		); 

        $this->add_control(
			'ccpw_display_1h_changes',
			[
				'label' => __( '1H change', 'ccpw' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'ccpw' ),
				'label_off' => __( 'Hide', 'ccpw' ),
				'return_value' => 'yes',
				'default' => 'yes',
                'condition'   => [
					'ccpw_widget_type' => 'card',	
				]
			]
		); 

        $this->add_control(
			'ccpw_display_24h_changes',
			[
				'label' => __( '24 Hours changes', 'ccpw' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'ccpw' ),
				'label_off' => __( 'Hide', 'ccpw' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);	
		
		$this->add_control(
			'ccpw_display_7d_changes',
			[
				'label' => __( '7 Days changes', 'ccpw' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'ccpw' ),
				'label_off' => __( 'Hide', 'ccpw' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition'   => [
					'ccpw_widget_type' => 'card',	
				]
			]
		);

		$this->add_control(
			'ccpw_display_30d_changes',
			[
				'label' => __( '30 days changes', 'ccpw' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'ccpw' ),
				'label_off' => __( 'Hide', 'ccpw' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition'   => [
					'ccpw_widget_type' => 'card',	
				]
			]
		);

        $this->add_control(
			'ccpw_display_rank',
			[
				'label' => __( 'Rank', 'ccpw' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'ccpw' ),
				'label_off' => __( 'Hide', 'ccpw' ),
				'return_value' => 'yes',
				'default' => 'yes',
                'condition'   => [
					'ccpw_widget_type' => 'card',	
				]
			]
		);   

        $this->add_control(
			'ccpw_display_marketcap',
			[
				'label' => __( 'Market Cap', 'ccpw' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'ccpw' ),
				'label_off' => __( 'Hide', 'ccpw' ),
				'return_value' => 'yes',
				'default' => 'yes',
                'condition'   => [
					'ccpw_widget_type' => 'card',	
				]
			]
		); 

       



		$this->end_controls_section();


		$this->start_controls_section(
			'ccpw_Basic_styles_section',
			[
				'label' => __( 'Color Settings', 'ccpw' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'ccpw_bg_color',
				[
					'label' => __( 'Background Color', 'ccpw' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ccpw-bg' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'ccpw_primary_color',
				[
					'label' => __( 'Primary Color', 'ccpw' ),
					'type' => Controls_Manager::COLOR,					
					 'selectors' => [
						'{{WRAPPER}} .ccpw-wrapper .ccpw-primary' => 'color: {{VALUE}}',
					], 
				]
			);

            $this->add_control(
				'ccpw_secondary_color',
				[
					'label' => __( 'Secondary Color', 'ccpw' ),
					'type' => Controls_Manager::COLOR,					
					 'selectors' => [
                        '{{WRAPPER}} .ccpw-secondary' => 'color: {{VALUE}}',
					],
				]
			);

            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'box_shadow',
                    'label' => __( 'Box Shadow', 'plugin-domain' ),
                    'selector' => '{{WRAPPER}} .ccpw-wrapper',
                ]
            );

		$this->end_controls_section();
		

	}

	// for frontend
	protected function render() {

		$settings = $this->get_settings_for_display();       
        
        $selected_coin = $settings['ccpw_select_coins'];
        $fiat_currency = $settings['ccpw_fiat_currency'];
		$display_high_low = $settings['ccpw_display_high_low'];
		$display_1h_changes = $settings['ccpw_display_1h_changes'];
        $display_24h_changes = $settings['ccpw_display_24h_changes'];
		$display_7d_changes = $settings['ccpw_display_7d_changes'];
		$display_30d_changes = $settings['ccpw_display_30d_changes'];		
        $number_formating = $settings['ccpw_number_formating']; 

        $display_rank = $settings['ccpw_display_rank']; 
        $display_marketcap = $settings['ccpw_display_marketcap']; 
        $coin_symbol_visibility = $settings['ccpw_display_coin_symbol'];  
        
        // Layout Settings
        $widget_type = $settings['ccpw_widget_type']; 

	    // fetch data from api	      
	    if($selected_coin!=null){			
			$selected_coin = ccpw_widget_get_coin_data($fiat_currency,$selected_coin);	        
	        $coin = $selected_coin[0];
	        $coin_name = $coin['name'];
	        $coin_id = $coin['coin_id'];

	        if( ccpw_get_coin_logo($coin_id, $size = 32)==false){
	            $apiLogo=$coin['logo'];
	            $coin_logo_html ='<img  alt="'.esc_attr($coin_name).'" src="'.esc_url($apiLogo).'">';
	        }else{
	          $coin_logo_html = ccpw_get_coin_logo($coin_id, $size = 32);
	        }


	        $currency_symbol = ccpw_currency_symbol($fiat_currency);
	        $coin_price = $coin['price'];
	        $market_cap = $coin['market_cap'];
	        $volume = $coin['total_volume'];
	        $supply = $coin['circulating_supply'];
	          
	        $rank = $coin['rank']; $symbol = $coin['symbol'];
	        $change_24_h = number_format($coin['percent_change_24h'],2,'.','').'%'; 

	        $final_price =  $coin_price;
			 
			$change_1h = number_format($coin['price_change_percentage_1h'],2,'.','').'%';
			$change_24h = number_format($coin['price_change_percentage_24h'],2,'.','').'%';
			$change_30d = number_format($coin['price_change_percentage_30d'],2,'.','').'%';
			$change_7d = number_format($coin['price_change_percentage_7d'],2,'.','').'%';

	        if ($number_formating == 'on') {
	            $coin_price = ccpw_widget_format_coin_value($coin_price);
	            $volume = ccpw_widget_format_coin_value($volume);
	            $market_cap = ccpw_widget_format_coin_value($market_cap);
	            $supply = ccpw_widget_format_coin_value($supply);
				$high_24h = ccpw_widget_format_coin_value($coin['high_24h']); 
			    $low_24h =  ccpw_widget_format_coin_value($coin['low_24h']);
	        } else {
	            $coin_price = ccpw_value_format_number($coin_price);
	            $volume = ccpw_value_format_number($volume);
	            $market_cap = ccpw_value_format_number($market_cap);
	            $supply = ccpw_value_format_number($supply);     
				$high_24h = ccpw_value_format_number($coin['high_24h']); 
			    $low_24h =  ccpw_value_format_number($coin['low_24h']);               
	        }
	          

	        $price =  $currency_symbol.$coin_price;
	        $market_cap = $currency_symbol.$market_cap;
	        $volume = $currency_symbol.$volume;
	        $supply = $supply.' '.$symbol;
			$high_24h = $currency_symbol.$high_24h;
			$low_24h = $currency_symbol.$low_24h;

	        require CCPWF_DIR . 'elementor-widget/layouts/ccpw-'.$widget_type.'.php';	          

	    }else{
	        return  $error = __('You have not selected any currencies to display', 'ccpw');
	    }
         		
	}

	// for live editor
 	protected function _content_template() {	
		
	} 

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new CCPW__Widget() );

