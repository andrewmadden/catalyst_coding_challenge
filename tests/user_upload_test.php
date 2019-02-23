<?php
declare(strict_types=1);

namespace amadden;

use PHPUnit\Framework\TestCase;

require dirname(__FILE__).'./../src/user_upload.php';

final class user_upload_test extends TestCase {
    
    public function testNamesAreFormattedCorrectly(): void {
        $this->assertEquals("Jonathon", formatName("JoNAThOn"));
        $this->assertEquals("Kevin", formatName("kevin"));
        $this->assertEquals("Sam!!", formatName("SAm!!"));
    }

    public function testEmailsAreFormattedCorrectly(): void {
        $this->assertEquals("jonathon@test.com", formatEmail("JoNAThOn@Test.CoM"));
    }

    public function testEmailValidation(): void {
        // valid emails
        $this->assertTrue(isEmailValid("jonathan@test.com"));
        $this->assertTrue(isEmailValid("jonathan@test.com.au"));
        $this->assertTrue(isEmailValid("jona123than@test.com"));
        $this->assertTrue(isEmailValid("foo@bar.com.au.test.foo.bar"));
        $this->assertTrue(isEmailValid("foo@bar@test.com"));
        
        // invalid emails
        $this->assertFalse(isEmailValid("foo@bar"));
        $this->assertFalse(isEmailValid("xxxx@asdf@asdf"));
        $this->assertFalse(isEmailValid("@bar.com"));
        $this->assertFalse(isEmailValid("foo@.com"));
        $this->assertFalse(isEmailValid("foo@bar."));

    }
}