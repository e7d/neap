<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Console;

/**
 * ConsoleStyle adds differents styles to the console
 *
 * It enables the user the usage of colors, backgrounds and text modifiers to decorate console output.
 */
class ConsoleStyle
{
    /**
     * @var array
     */
    private static $styles = array(
        '{black}' => '{e}[0;30m',
        '{red}' => '{e}[0;31m',
        '{green}' => '{e}[0;32m',
        '{yellow}' => '{e}[0;33m',
        '{blue}' => '{e}[0;34m',
        '{purple}' => '{e}[0;35m',
        '{cyan}' => '{e}[0;36m',
        '{white}' => '{e}[0;37m',
        '{bold,black}' => '{e}[1;30m',
        '{bold,red}' => '{e}[1;31m',
        '{bold,green}' => '{e}[1;32m',
        '{bold,yellow}' => '{e}[1;33m',
        '{bold,blue}' => '{e}[1;34m',
        '{bold,purple}' => '{e}[1;35m',
        '{bold,cyan}' => '{e}[1;36m',
        '{bold,white}' => '{e}[1;37m',
        '{bg,black}' => '{e}[40m',
        '{bg,red}' => '{e}[41m',
        '{bg,green}' => '{e}[42m',
        '{bg,yellow}' => '{e}[43m',
        '{bg,blue}' => '{e}[44m',
        '{bg,purple}' => '{e}[45m',
        '{bg,cyan}' => '{e}[46m',
        '{bg,white}' => '{e}[47m',
        '{/}' => '{e}[0m'
    );

    /**
     * Build a formatted console text using tags from $styles
     *
     * @param string $text
     *
     * @return string
     */
    public static function build(string $text)
    {
        $text = str_replace(array_keys(self::$styles), array_values(self::$styles), $text);
        $text = str_replace('{e}', chr(27), $text);

        return $text;
    }
}
