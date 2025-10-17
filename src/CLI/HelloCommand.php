<?php
namespace WPMooStarter\CLI;

use WPMoo\Core\Console;

class HelloCommand
{
    public static function run()
    {
        Console::info("Hello from WPMoo Starter Plugin 👋");
    }
}
