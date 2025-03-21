<?php

namespace App\Lib;

use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;

class Logger
{
    public static function log(mixed $content, string $filename = 'console'):void
    {
        if($filename === 'console')
        {
            echo self::format_content($content);
            return;
        }

        $log_dir = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.$_ENV['LOG_DIR'];
        $filename = $log_dir.DIRECTORY_SEPARATOR.$filename;

        $filesystem = new Filesystem();

        $filesystem->appendToFile($filename, self::format_content($content));             
    }

    private static function format_content($content)
    {
        return "[".(date('Y-m-d H:i:s'))."] $content\n";
    }
}