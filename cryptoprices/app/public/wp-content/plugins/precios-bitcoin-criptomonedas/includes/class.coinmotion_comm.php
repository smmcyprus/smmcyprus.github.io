<?php
class CoinmotionComm {
	/*
	*	CONSTANTS
	*/
	const COINMOTION_API_URL = 'https://api.coinmotion.com/v2';
	const COINMOTION_API_RATES = CoinmotionComm::COINMOTION_API_URL . '/rates';
	const COINMOTION_API_CURRENCIES = CoinmotionComm::COINMOTION_API_URL . '/get_currencies';
	const COINMOTION_API_RATE_HISTORY = CoinmotionComm::COINMOTION_API_URL . '/rate_history';
	const COINMOTION_API_ALLOWED_COUNTRIES = CoinmotionComm::COINMOTION_API_URL . '/get_allowed_countries';
	const COINMOTION_API_LANGUAGES = CoinmotionComm::COINMOTION_API_URL . '/get_available_languages';

	public function getRates(){
		$response = CoinmotionComm::callToAPI(CoinmotionComm::COINMOTION_API_RATES);
		return $response;
	}

	public function getCurrencies($type = 'buy'){ // buy, sell, balance, cryptos, interest
		$params = [$type];
		$response = CoinmotionComm::callToAPI(CoinmotionComm::COINMOTION_API_CURRENCIES, $params);
		return $response;
	}

	public function getRateHistory($currency = 'btc', $time_period= 'day', $type = 'price'){ // currencyCode, timePeriod = [hour, day, week, year, month, 3_months], type = [price, interest]
		$params = [strtolower($currency), 'eur', strtolower($time_period), strtolower($type)];
		$response = CoinmotionComm::callToAPI(CoinmotionComm::COINMOTION_API_RATE_HISTORY, $params);
		return $response;
	}

	public function getAllowedCountries(){
		$response = CoinmotionComm::callToAPI(CoinmotionComm::COINMOTION_API_ALLOWED_COUNTRIES);
		return $response;
	}

	public function getAvailableLangs(){
		$response = CoinmotionComm::callToAPI(CoinmotionComm::COINMOTION_API_ALLOWED_COUNTRIES);
		return $response;
	}

	public function getDetails($currency = 'btc', $type = 'price'){
		$currency = strtolower($currency);
		$curren = new CoinmotionGetCurrencies();
		$actual_currency = coinmotion_get_widget_data(); 		
 		$actual_curr_value = floatval($curren->getCotization($actual_currency['default_currency']));
		$day_data = json_decode($this->getRateHistory($currency, 'day', $type), true);
		
		$week_data = json_decode($this->getRateHistory($currency, 'week', $type), true);
		$month_data = json_decode($this->getRateHistory($currency, 'month', $type), true);
		$three_month_data = json_decode($this->getRateHistory($currency, '3_months', $type), true);
		$year = json_decode($this->getRateHistory($currency, 'year', $type), true);

		$actual_price = $open_day = $lower_day = $higher_day = $lower_month = $higher_month = $lower_3_months = $higher_3_months = $lower_year = $higher_year = $lower_week = $higher_week = 0.0;

		$now = json_decode($this->getRates(), true);
		$actual_price = floatval($now[$currency."Eur"]['buy']);
		$open_day = $day_data[0][0]*$actual_curr_value;

		$total = count($day_data);
		$lower_day = floatval($day_data[0][0]*$actual_curr_value);
		$day_var_first_value = floatval($day_data[0][0]*$actual_curr_value);
		$day_var_last_value = floatval($day_data[$total-1][0]*$actual_curr_value);
		$variation_day = number_format((($day_var_last_value/$day_var_first_value) - 1)*100, 4);
		for ($i = 0; $i < $total; $i++){
			$actual = floatval($day_data[$i][0]*$actual_curr_value);
			if ($lower_day > $actual)
				$lower_day = $actual;
			if ($higher_day < $actual)
				$higher_day = $actual;
		}

		$total = count($week_data);
		$lower_week = floatval($week_data[0][0]*$actual_curr_value);
		$week_var_first_value = floatval($week_data[0][0]*$actual_curr_value);
		$week_var_last_value = floatval($week_data[$total-1][0]*$actual_curr_value);
		$variation_week = number_format((($week_var_last_value/$week_var_first_value) - 1)*100, 4);
		for ($i = 0; $i < $total; $i++){
			$actual = floatval($week_data[$i][0]*$actual_curr_value);
			if ($lower_week > $actual)
				$lower_week = $actual;
			if ($higher_week < $actual)
				$higher_week = $actual;
		}

		$total = count($month_data);
		$lower_month = floatval($month_data[0][0]*$actual_curr_value);
		$month_var_first_value = floatval($month_data[0][0]*$actual_curr_value);
		$month_var_last_value = floatval($month_data[$total-1][0]*$actual_curr_value);
		$variation_month = number_format((($month_var_last_value/$month_var_first_value) - 1)*100, 4);
		for ($i = 0; $i < $total; $i++){
			$actual = floatval($month_data[$i][0]*$actual_curr_value);
			if ($lower_month > $actual)
				$lower_month = $actual;
			if ($higher_month < $actual)
				$higher_month = $actual;
		}

		$total = count($three_month_data);
		$lower_3_months = floatval($three_month_data[0][0]*$actual_curr_value);
		$three_month_var_first_value = floatval($three_month_data[0][0]*$actual_curr_value);
		$three_month_var_last_value = floatval($three_month_data[$total-1][0]*$actual_curr_value);
		$variation_3_month = number_format((($three_month_var_last_value/$three_month_var_first_value) - 1)*100, 4);
		for ($i = 0; $i < $total; $i++){
			$actual = floatval($three_month_data[$i][0]*$actual_curr_value);
			if ($lower_3_months > $actual)
				$lower_3_months = $actual;
			if ($higher_3_months < $actual)
				$higher_3_months = $actual;
		}

		$total = count($year);
		$lower_year = floatval($year[0][0]*$actual_curr_value);
		$year_first_value = floatval($year[0][0]*$actual_curr_value);
		$year_last_value = floatval($year[$total-1][0]*$actual_curr_value);
		$variation_year = number_format((($year_last_value/$year_first_value) - 1)*100, 4);
		for ($i = 0; $i < $total; $i++){
			$actual = floatval($year[$i][0]*$actual_curr_value);
			if ($lower_year > $actual)
				$lower_year = $actual;
			if ($higher_year < $actual)
				$higher_year = $actual;
		}

		$result = ['actual_price' => $actual_price, 'open_day' => $open_day, 'lower_day' => $lower_day, 'higher_day' => $higher_day, 'lower_week' => $lower_week, 'higher_week' => $higher_week, 'lower_month' => $lower_month, 'higher_month' => $higher_month, 'lower_3_months' => $lower_3_months, 'higher_3_months' => $higher_3_months, 'lower_year' => $lower_year, 'higher_year' => $higher_year, 'variation_day' => $variation_day, 'variation_week' => $variation_week, 'variation_month' => $variation_month, 'variation_3_months' => $variation_3_month, 'variation_year' => $variation_year];

		return $result;
	}

	public function callToAPI($method, $params = []){
		$query_string = $method;

		if (count($params) > 0) {
			foreach ($params as $p){
				$query_string .= "/$p";
			}
		}
		$remote = curl_init($query_string);
		curl_setopt($remote, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($remote);
		if ($response === false) {
		    $info = curl_getinfo($remote);
		    curl_close($remote);
		    die('error occured during curl exec. Additioanl info: ' . var_export($info));
		}
		curl_close($remote);
		$decoded = json_decode($response);
		if (isset($decoded->success) && $decoded->success == false)
		    die('error occured: ' . $decoded->payload->message);
		return json_encode($decoded->payload);
	}
}
?>