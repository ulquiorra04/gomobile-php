<?php

namespace Gomobile\SDK\HLP;

class NumberHelper {
    
    /**
     * check if the phone number in internationnal format
     * 
     * @param string $number: Phone number
     * @return bool
     */
    public static function isValidInternationalNumber ($number) {
        if(preg_match("/^\+212[0-9]{9}$/", $number))
            return true;
        return false;
    }

    /**
     * Check if the phone number in nationnal format
     * 
     * @param string $number: Phone number
     * @return bool
     */
    public static function isValidNationalNumber ($number) {
        if(preg_match("/^0[5-6-7][0-9]{8}$/", $number))
            return true;
        return false;
    }

    /**
     * Convert international format to national format
     * 
     * @param string $phone : International format
     * @return string $phone : National format
     */
    public static function phoneConverter ($phone) {
        if(self::isValidInternationalNumber($phone))
            return "0".ltrim($phone, "+212");
    }

    /**
     * Check an array of phone numbers is valid
     * 
     * @param array $phoneNumbers
     * @return bool
     */
    public static function isValidArrayPhoneNumbers ($phoneNumbers)
    {
        if(!is_array($phoneNumbers))
            return false;
        foreach ($phoneNumbers as $phone) {
            if(!self::isValidNationalNumber($phone))
                return false;
        }
        return true;
    }
}