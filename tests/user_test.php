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
        $user = new user("john", "smith", "andrew.madden@test.com");

        // valid emails
        $this->assertTrue((new user("j", "s", "johns@test.com"))->hasValidEmail());
        $this->assertTrue((new user("j", "s", "jonathan@test.com.au"))->hasValidEmail());
        $this->assertTrue((new user("j", "s", "jona123than@test.com"))->hasValidEmail());
        $this->assertTrue((new user("j", "s", "foo@bar.com.au.test.foo.bar"))->hasValidEmail());
        $this->assertTrue((new user("j", "s", "foo@bar@test.com"))->hasValidEmail());
        
        // invalid emails
        $this->assertFalse((new user("j", "s", "foo@bar"))->hasValidEmail());
        $this->assertFalse((new user("j", "s", "xxxx@asdf@asdf"))->hasValidEmail());
        $this->assertFalse((new user("j", "s", "@bar.com"))->hasValidEmail());
        $this->assertFalse((new user("j", "s", "foo@.com"))->hasValidEmail());
        $this->assertFalse((new user("j", "s", "foo@bar."))->hasValidEmail());

    }
}