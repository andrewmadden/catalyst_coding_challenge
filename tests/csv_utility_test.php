<?php
declare(strict_types=1);

namespace amadden;

use PHPUnit\Framework\TestCase;

final class csv_utility_test extends TestCase {

    public function testCSVHeaderTransformsIntoArray(): void {
        $input = "name, surname, email";
        $output = ["name","surname","email"];
        $this->assertEquals($output, csv_utility::transformCSVHeaderIntoArray($input));
    }

    public function testCSVInputTransformsIntoAssocArray(): void {
        $inputHeaders = ["name","surname","email"];
        // The input includes spaces and tabs that should be trimmed for the output
        $input = "andrew,   john,        andrew@john.com ";
        $output = [
            "name"=>"andrew", 
            "surname"=>"john",
            "email"=>"andrew@john.com"
        ];
        $this->assertEquals($output, csv_utility::transformCSVRowIntoAssocArray($inputHeaders, $input));
    }

}