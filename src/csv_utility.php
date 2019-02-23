<?php
declare(strict_types=1);

namespace amadden;

class csv_utility {

    public static function transformCSVHeaderIntoArray(string $input): array {
        $headerNames = explode(",", $input);
        // loop may modify elements of original array
        foreach($headerNames as &$header) {
            $header = trim($header);
        }
        return $headerNames;
    }

    public static function transformCSVRowIntoAssocArray(array $inputHeaders, string $input): array {
        $values = explode(",", $input);
        forEach($values as &$value) {
            $value = trim($value);
        }

        // TODO: need to check that both arrays are the same size, otherwise throw error

        return array_combine($inputHeaders, $values);
    }
}