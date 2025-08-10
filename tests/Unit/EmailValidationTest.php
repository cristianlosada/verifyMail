<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class EmailValidationTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_service_validates_mx(): void
    {
        $svc = new \App\Services\EmailValidationService();
        $ok  = $svc->validate('user@gmail.com');
        $bad = $svc->validate('user@dominio-que-no-existe-xyz-123.io');

        $this->assertTrue($ok['is_valid']);
        $this->assertFalse($bad['is_valid']);
    }
}