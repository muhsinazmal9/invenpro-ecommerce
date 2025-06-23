<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Smothing extends Command
{
    protected $signature = 'smothing:clean';

    protected $description = 'Replaces Blade {{ \'string\' }} with plain string in views';

    public function handle()
    {
        $directory = resource_path('views');
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

        foreach ($iterator as $file) {
            if ($file->isFile() && in_array($file->getExtension(), ['php', 'blade'])) {
                $content = file_get_contents($file->getRealPath());

                // Replace {{ 'string' }} or {{ "string" }} with string
                $newContent = preg_replace_callback(
                    "/\{\{\s*(['\"])(.*?)\\1\s*\}\}/",
                    function ($matches) {
                        return $matches[2]; // Only the inner content
                    },
                    $content
                );

                // Save only if content changed
                if ($content !== $newContent) {
                    file_put_contents($file->getRealPath(), $newContent);
                    $this->info("Updated: " . $file->getRealPath());
                }
            }
        }

        $this->info('Smothing done.');
        return 0;
    }
}
