<?php
class CoinmotionGetCurrencies{
	/*
	*   CONSTANTS  
	*/

	const CURRENCIES_API_URL = 'https://api.exchangeratesapi.io/latest';
	const OPTION_KEY = "coinmotion_currencies";

	public function getCurrencies(){
		$actual_option = get_option(CoinmotionGetCurrencies::OPTION_KEY, false);

		if (!$actual_option || $actual_option === "1"){			
			$data = CoinmotionGetCurrencies::callToAPI();			
			$data['rates']['EUR'] = 1;
			ksort($data['rates']);
			update_option(CoinmotionGetCurrencies::OPTION_KEY, $data);
		}
		else{			
			if ($actual_option['date'] !== date('Y-m-d')){
				$data = CoinmotionGetCurrencies::callToAPI();
				$data['rates']['EUR'] = 1;
				ksort($data['rates']);
				update_option(CoinmotionGetCurrencies::OPTION_KEY, $data);
			}
		}
	}

	public function getCotization($currency){
		
		$currencies = get_option(CoinmotionGetCurrencies::OPTION_KEY);
		if (($currencies === false) || (intval($currencies) === 1)){
			$this->getCurrencies();
			$currencies = get_option(CoinmotionGetCurrencies::OPTION_KEY);
		}
		return $currencies['rates'][$currency];
	}

	public function callToAPI(){
		$remote = curl_init(CoinmotionGetCurrencies::CURRENCIES_API_URL);
		curl_setopt($remote, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($remote);

		if ($response === false) {
		    $info = curl_getinfo($remote);
		    curl_close($remote);
		    die('error occured during curl exec. Additioanl info: ' . var_export($info));
		}
		curl_close($remote);
		$decoded = json_decode($response, true);
		if (isset($decoded->success) && $decoded->success == false)
		    die('error occured parsing rates: ' . $decoded->message);
		return $decoded;
	}
}

?>