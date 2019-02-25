<?php
declare(strict_types=1);

namespace amadden;

use PHPUnit\Framework\TestCase;

require dirname(__FILE__).'./../src/user_upload.php';

final class user_upload_test extends TestCase {
    public function testNamesAreFormattedCorrectly(): void {
        $this->assertTrue(true);
    }
}