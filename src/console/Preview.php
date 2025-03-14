<?php

namespace Core\console;

class Preview
{
    protected static $colors = [
        'black'   => '30',
        'red'     => '31',
        'green'   => '32',
        'yellow'  => '33',
        'blue'    => '34',
        'magenta' => '35',
        'cyan'    => '36',
        'white'   => '37',
        'bright_black' => '90',
        'bright_red'   => '91',
        'bright_green' => '92',
        'bright_yellow' => '93',
        'bright_blue' => '94',
        'bright_magenta' => '95',
        'bright_cyan' => '96',
        'bright_white' => '97'
    ];


    public static function render($value, string $color='cyan'){
        if (array_key_exists($color, self::$colors)) {
            $code =self::$colors[$color];
        } else {
            $code = '36';
        }

        echo "\033[1;{$code}m";
        print_r($value);
        echo "\033[0m\n";
    }
}