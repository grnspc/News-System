<?php

namespace GrnSpc\News\Console;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Filesystem\Filesystem;


class InstallCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:install';

    /**
     * The console command description.
     *php
     * @var string
     */
    protected $description = 'Install the News System components and resources';


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {

        $this->info('Installing News System...');

        // Publish...
        $this->info('Publishing configuration...');
        if (!File::exists(config_path('news.php'))) {
            $this->callSilent('vendor:publish', ['--tag' => 'news-config']);
        } else {
            if ($this->confirm('Config file already exists. Do you want to overwrite it?', false)) {
                $this->info('Overwriting configuration file...');
                $this->callSilent('vendor:publish', ['--tag' => 'news-config', '--force' => true]);
            } else {
                $this->info('Existing configuration was not overwritten');
            }
        }

        // Install Stack...
        $this->installNewsStack();

        $this->info('Installed News System');
    }

    /**
     * Install the News stack into the application.
     *
     * @return void
     */
    protected function installNewsStack()
    {

        // NPM Packages...
        $this->updateNodePackages(function ($packages) {
            return [
                '@tailwindcss/forms' => '^0.3.1',
                '@tailwindcss/typography' => '^0.4.0',
                'alpinejs' => '^2.7.3',
                'postcss-import' => '^14.0.1',
                'tailwindcss' => '^2.0.1',
            ] + $packages;
        });

        // Directories...
        (new Filesystem)->ensureDirectoryExists(app_path('View/Components'));
        (new Filesystem)->ensureDirectoryExists(public_path('css'));
        (new Filesystem)->ensureDirectoryExists(resource_path('css'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/layouts'));

        (new Filesystem)->deleteDirectory(resource_path('sass'));

        // View Components...
        copy(__DIR__.'/../../stubs/app/View/Components/AppLayout.php', app_path('View/Components/AppLayout.php'));
        copy(__DIR__.'/../../stubs/app/View/Components/GuestLayout.php', app_path('View/Components/GuestLayout.php'));
        copy(__DIR__ . '/../../stubs/app/View/Components/FrontFeed.php', app_path('View/Components/FrontFeed.php'));


        // Layouts...
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/resources/views/layouts', resource_path('views/layouts'));

        $this->line('');
        $this->info('News system scaffolding installed successfully.');
        $this->comment('Please enjoy!');
    }

    /**
     * Update the "package.json" file.
     *
     * @param  callable  $callback
     * @param  bool  $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, $dev = true)
    {
        if (!file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );
    }



    protected function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }
}
