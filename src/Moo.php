<?php
/**
 * The Local Facade for the 'wpmoo-starter' plugin.
 *
 * @package WPMooStarter
 */

namespace WPMooStarter;

use WPMoo\Facade;

if (!class_exists('WPMooStarter\Moo')) {
    /**
     * @method static \WPMoo\Page\Builders\PageBuilder page(string $id, string $title)
     * @method static \WPMoo\Layout\Layout tabs(string $id)
     * @method static \WPMoo\Field\Field input(string $id)
     * @method static \WPMoo\Field\Field textarea(string $id)
     * @method static \WPMoo\Field\Field toggle(string $id)
     */
    class Moo extends Facade { // Extend the new Facade class
        // APP_ID and __callStatic are now handled by the parent Facade class
    }
}
