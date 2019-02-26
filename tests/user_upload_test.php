<?php
declare(strict_types=1);

namespace amadden;

use PHPUnit\Framework\TestCase;

// require dirname(__FILE__).'./../src/user_upload.php';

final class user_upload_test extends TestCase {

    public function testExistingEmailCheck(): void {
        $existingEmails = ["email"=>"foo@bar.com"];

        $this->assertTrue(in_array("foo@bar.com",$existingEmails));
        $this->assertFalse(!in_array("foo@bar.com",$existingEmails));
    }
}