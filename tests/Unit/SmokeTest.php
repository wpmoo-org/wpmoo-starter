<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class SmokeTest extends TestCase
{
    public function testAutoloadsStarterNamespace(): void
    {
        $this->assertTrue(class_exists(\WPMooStarter\Pages\Settings\Settings::class));
    }
}

