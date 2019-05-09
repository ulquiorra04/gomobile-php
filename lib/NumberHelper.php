<?php

namespace Gomobile\HLP;

class NumberHelper {
    
    /**
     * check if the phone number in internationnal format
     * 
     * @param string $number: Phone number
     * @return bool
     */
    public static function isInternationnalNumber ($number) {
        return preg_match("/^+212[0-9]{9}$/", $number);
    }

    /**
     * Check if the phone number in nationnal format
     * 
     * @param string $number: Phone number
     * @return bool
     */
    public static function isNationnalNumber ($number) {
        return preg_match("/^0[5-6-7][0-9]{8}$/", $number);
    }

    /**
     * Convert international format to national format
     * 
     * @param string $phone : International format
     * @return string $phone : National format
     */
    public static function phoneConverter ($phone) {
        if(self::isInternationnalNumber($phone))
            return "0".ltrim($phone, "+212");
    }

    /**
     * Check if multiple phone numbers in nationnal format
     * 
     * @param array $phoneNumbers
     * @return bool
     */
    public static function isValidArrayPhoneNumbers ($phoneNumbers)
    {
        
    }
}