<?php

namespace App\Console\Commands;

use App\Http\Controllers\ObbRenderController;
use Illuminate\Console\Command;

class renderobb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'renderobb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Render video obb';

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
    public function handle(ObbRenderController $obbRenderController)
    {
        $obbRenderController->Render();
    }
}
