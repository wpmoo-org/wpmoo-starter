<?php
namespace WPMooStarter\CLI;

use WPMoo\CLI\Console;

class HelloCommand
{
    public static function run()
    {
        Console::info("Hello from WPMoo Starter Plugin 👋");
    }
}
