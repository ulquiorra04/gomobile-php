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
		if(array_key_exists(self::AMOUNT, $data))
			$parameters[self::AMOUNT] = $data[self::AMOUNT];
		if(array_key_exists(self::DATE, $data))
			$parameters[self::DATE] = $data[self::DATE];
		if(array_key_exists(self::AGENT, $data))
			$parameters[self::AGENT] = $data[self::AGENT];

		return $parameters;
	}
}