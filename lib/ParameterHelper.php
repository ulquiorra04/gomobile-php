<?php

namespace Gomobile\SDK\HLP;

class ParameterHelper {

	const AMOUNT = "user_amount";
	const DATE = "date";
	const AGENT = "user_agent";
	const PHONE = "phoneNumber";

	public static function prepareParameters ($data) {
		if(!is_array($data))
			return [];
		$parameters = [];
		if(array_key_exists(AMOUNT, $data))
			$parameters[AMOUNT] = $data[AMOUNT];
		if(array_key_exists(DATE, $data))
			$parameters[DATE] = $data[DATE];
		if(array_key_exists(AGENT, $data))
			$parameters[AGENT] = $data[AGENT];

		return $parameters;
	}
}