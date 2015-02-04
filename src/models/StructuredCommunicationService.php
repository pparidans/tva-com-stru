<?php

namespace models;

class StructuredCommunicationService {

    public function parse_vat($str) {
        $company_number = trim($str);

        preg_match("/^(BE)?[\.,\-\s]?(0)?[\.,\-\s]?([0-9]{2,3})[\.,\-\s]?([0-9]{3})[\.,\-\s]?([0-9]{3})$/", $company_number, $company_number_parts);
        return intval($company_number_parts[3] . $company_number_parts[4] . $company_number_parts[5]);
    }

    public function format_vat_communication($vat_number, $separator = "/") {
        $check_digit = ($vat_number % 97);
    
        $com_stru = "0".$vat_number.str_pad($check_digit, 2, "0", STR_PAD_LEFT);
        return preg_replace('/^([0-9]{3})([0-9]{4})([0-9]{5})$/', '$1'.$separator.'$2'.$separator.'$3', $com_stru);
    }

    public function convert_vat($str) {
        $vat_number = $this->parse_vat($str);
        $com_stru = $this->format_vat_communication($vat_number);
        return $com_stru;
    }
}
