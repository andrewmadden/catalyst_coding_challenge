<?php
declare(strict_types=1);

namespace amadden;

use PHPUnit\Framework\TestCase;

final class userUploadTest extends TestCase {
    public function testCalcAddition(): void {
        $calc = new Calculator();
        $this->assertEquals(5, $calc->addTwoNumbers(2.0, 3.0));
    }

    public function testUnitUploadIsConnected(): void {
        $useruploader = new user_upload();
        $this->assertTrue($useruploader->exists());
    }
}