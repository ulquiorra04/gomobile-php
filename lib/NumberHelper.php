<?php

class NumberHelper {
    
    /**
     * check if the phone number in internationnal format
     * 
     * @param string $number: Phone number
     * @return bool
     */
    public function isInternationnalNumber ($number) {
        return preg_match("/^+212[0-9]{9}$/", $number);
    }

    /**
     * Check if the phone number in nationnal format
     * 
     * @param string $number: Phone number
     * @return bool
     */
    public function isNationnalNumber ($number) {
        return preg_match("/^0[5-6-7][0-9]{8}$/", $number);
    }
}