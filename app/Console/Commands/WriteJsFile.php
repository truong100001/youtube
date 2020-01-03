<?php

namespace App\Console\Commands;

use App\Http\Controllers\WriteJsFileController;
use Illuminate\Console\Command;

class WriteJsFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'renderauto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Render video apk';

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
    public function handle(WriteJsFileController $controller)
    {
        $controller->RenderAuto();
    }
}
