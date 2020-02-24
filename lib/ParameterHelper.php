<?php

namespace Gomobile\SDK\HLP;

class ParameterHelper {

	const AMOUNT = "user_amount";
	const DATE = "date";
	const AGENT = "user_agent";
	const PHONE = "phoneNumber";
	const AGENCY = "agence";
	const HOUR = "heure";
	const GIFT = "cadeau";

	const VARIATION = "variation";
	const POURCENT_ENTIER = "pourcent_entier";
	const POURCENT_VIRGULE = "pourcent_virgule";

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
		if(array_key_exists(self::AGENCY, $data))
			$parameters[self::AGENCY] = $data[self::AGENCY];
		if(array_key_exists(self::HOUR, $data))
			$parameters[self::HOUR] = $data[self::HOUR];
		if(array_key_exists(self::GIFT, $data))
			$parameters[self::GIFT] = $data[self::GIFT];
		if(array_key_exists(self::VARIATION, $data))
			$parameters[self::VARIATION] = $data[self::VARIATION];
		if(array_key_exists(self::POURCENT_ENTIER, $data))
			$parameters[self::POURCENT_ENTIER] = $data[self::POURCENT_ENTIER];
		if(array_key_exists(self::POURCENT_VIRGULE, $data))
			$parameters[self::POURCENT_VIRGULE] = $data[self::POURCENT_VIRGULE];

		return $parameters;
	}
}