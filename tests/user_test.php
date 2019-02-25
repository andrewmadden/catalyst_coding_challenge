<?php
declare(strict_types=1);

namespace amadden;

use PHPUnit\Framework\TestCase;


final class user_test extends TestCase {
    
    public function testNamesAreFormattedCorrectly(): void {
        $user = new user("andrew", "madden", "andrew.madden@test.com");
        
        $this->assertEquals("Jonathon", $user->formatName("JoNAThOn"));
        $this->assertEquals("Kevin", $user->formatName("kevin"));
        $this->assertEquals("Sam!!", $user->formatName("SAm!!"));
    }

    public function testEmailsAreFormattedCorrectly(): void {
        $user = new user("andrew", "madden", "andrew.madden@test.com");

        $this->assertEquals("jonathon@test.com", $user->formatEmail("JoNAThOn@Test.CoM"));
    }

    public function testEmailValidation(): void {
        $user = new user("andrew", "madden", "andrew.madden@test.com");

        // valid emails
        $this->assertTrue($user->isEmailValid("jonathan@test.com"));
        $this->assertTrue($user->isEmailValid("jonathan@test.com.au"));
        $this->assertTrue($user->isEmailValid("jona123than@test.com"));
        $this->assertTrue($user->isEmailValid("foo@bar.com.au.test.foo.bar"));
        $this->assertTrue($user->isEmailValid("foo@bar@test.com"));
        
        // invalid emails
        $this->assertFalse($user->isEmailValid("foo@bar"));
        $this->assertFalse($user->isEmailValid("xxxx@asdf@asdf"));
        $this->assertFalse($user->isEmailValid("@bar.com"));
        $this->assertFalse($user->isEmailValid("foo@.com"));
        $this->assertFalse($user->isEmailValid("foo@bar."));

    }
}