<?php
namespace WPMooStarter\CLI;

use WPMoo\CLI\Console;

/**
 * Example CLI command shipped with the starter plugin.
 */
class HelloCommand {

	/**
	 * Emit a friendly greeting to verify CLI wiring.
	 *
	 * @return void
	 */
	public static function run() {
		Console::info( 'Hello from WPMoo Starter Plugin 👋' );
	}
}
