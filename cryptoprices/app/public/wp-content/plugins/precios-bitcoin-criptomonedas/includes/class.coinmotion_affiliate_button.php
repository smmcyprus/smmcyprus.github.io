<?php
class Coinmotion_Affiliate_Button{
	function generateButton(){
		$params = coinmotion_get_widget_data();
		$data_lang = explode("_", get_locale());
		$lang = $data_lang[0];
		
		if (!in_array($lang, ['es', 'en', 'fi'])){
			$lang = 'en';
		}
		$output = "<style>
			.coinmotion_button_affiliate{
				color: ".$params['register_text_color'].";
				background-color: ".$params['register_button_color'].";
				outline: 0;
				text-decoration: none;
				border-radius: 10px;
				padding: 5px 20px;
				/*text-transform: uppercase;*/
				margin: 0 auto;
			}

			a.coinmotion_button_affiliate:hover{
				background-color: ".$params['register_button_hover_color'].";
			}
		</style>";
		$url = "https://app.coinmotion.com/".$lang."/register/signup?referral_code=".$params['refcode'];
		$url = "https://app.coinmotion.com/".$lang."/register/signup?referral_code=".$params['refcode']."&utm_campaign=price_widget_".$lang."&utm_source=".$params['refcode']."&utm_medium=referral_button";
		$output .= "<div style='display: grid; height: auto;'><a class='coinmotion_button_affiliate' href='".$url."' target='_blank'>".$params['register_text']."</a></div>";
		return $output;
	}

	function generateCMLink($widget_name){
		$params = coinmotion_get_widget_data();
		$data_lang = explode("_", get_locale());
		$lang = $data_lang[0];

		if (!in_array($lang, ['es', 'en', 'fi'])){
			$lang = 'en';
		}
		$campaign = "price_widget_".$lang;
		if ($lang === 'en'){
			$lang = "";
		}
		else{
			$lang = $lang."/";
		}
		$link_url = "https://coinmotion.com/".$lang."?utm_campaign=".$campaign."&utm_source=".$params['refcode']."&utm_medium=powered_by_button";
		$output = "<p style='text-align: center; color: black; margin-bottom: 0px;'>Powered by <a href='".$link_url."' target='_blank'>Coinmotion</a></p>";
		return $output;
	}
}

?>