<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Finder\Finder;

class Smothing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:smothing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Replaces app.php translation keys with actual values in PHP and Blade files.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $translationFile = base_path('resources/lang/en/auth.php');

        if (!file_exists($translationFile)) {
            $this->error("Translation file not found at: $translationFile");
            return 1;
        }

        $translations = include $translationFile;

        // Flatten nested translation array if necessary
        $flatten = function ($array, $prefix = '') use (&$flatten) {
            $result = [];
            foreach ($array as $key => $value) {
                $newKey = $prefix . $key;
                if (is_array($value)) {
                    $result += $flatten($value, $newKey . '.');
                } else {
                    $result[$newKey] = $value;
                }
            }
            return $result;
        };

        $translations = $flatten($translations);

        $finder = new Finder();
        $finder->files()
            ->in(base_path())
            ->exclude(['vendor', 'node_modules', 'storage'])
            ->ignoreDotFiles(true)
            ->ignoreVCS(true)
            ->name(['*.php', '*.blade.php']);

        foreach ($translations as $key => $value) {
            $escapedKey = preg_quote("auth.$key", '/');
            $regex = '/(__|trans|@lang)\(\s*[\'"]' . $escapedKey . '[\'"]\s*\)/';
            $replacement = "'$value'";

            foreach ($finder as $file) {
                $filePath = $file->getRealPath();
                $content = file_get_contents($filePath);

                $newContent = preg_replace($regex, $replacement, $content, -1, $count);

                if ($count > 0) {
                    file_put_contents($filePath, $newContent);
                    $this->info("Replaced $count instances of 'app.$key' in {$filePath}");
                }
            }
        }

        $this->info("Replacement complete.");
        return 0;
    }
}
