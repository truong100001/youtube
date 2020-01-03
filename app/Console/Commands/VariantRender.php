<?php

namespace App\Console\Commands;

use App\Http\Controllers\VariantVideoController;
use Illuminate\Console\Command;

class VariantRender extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rendervariant';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Render video variant apk';

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
    public function handle(VariantVideoController $controller)
    {
        $controller->RenderAuto();
    }
}
