<?php

namespace Jdtanjuaquio\Setmeup;

use Illuminate\Console\Command;

class SetMeUpCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setmeup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A simple command to setup Laravel UI, TailwindCSS, Livewire and AlpineJS';
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // #install laravel ui
            $output = shell_exec('composer show laravel/ui');
            if(! $output) {
                $this->info('installing laravel ui');
                shell_exec('composer require laravel/ui');
                shell_exec('php artisan package:discover --ansi');
            };
            shell_exec('php artisan ui vue --auth -n');

            if(! file_exists(base_path('node_modules')) ) {
                $this->info('installing node_modules');
                exec('npm install');
            }
            exec('npm run dev');


        #install tailwind
            $outputTailwind = shell_exec('npm list | grep tailwind');
            if(! $outputTailwind) {
                $this->info('installing tailwind css');
                exec('npm install tailwindcss');
            }
            exec('npx tailwindcss init');
            $configs = [
                __DIR__. '/stub/app.css.stub' => resource_path('css/app.css'),
                __DIR__.'/stub/mix.stub' => base_path('webpack.mix.js')
            ];
            foreach($configs as $key => $config) {
                if(! file_exists(dirname($config))) {
                    mkdir(dirname($config), 0755, true);
                }
                copy( $key , $config);
            }
            exec('npm run dev');


        #install - livewire
            $outputlivewire = shell_exec('composer show livewire/livewire');
            if(! $outputlivewire ) {
                $this->info('installing livewire');
                exec('composer require livewire/livewire');
            };
            copy(__DIR__ . '/stub/app.layout.stub' , resource_path('views/layouts/app.blade.php'));



        #alpine js
            $outputalpine = shell_exec('npm list | grep alpinejs');
            if(! $outputalpine) {
                $this->info('installing alpine js');
                exec('npm install alpinejs');
            }
            $js = resource_path('js/app.js');
            if(file_exists($js)) {
                rename($js , resource_path('js/app-vue.js'));
            }
            copy(__DIR__ . '/stub/alpine.stub', $js);
            exec('npm run dev');

        $this->info("Done");
    }
}
