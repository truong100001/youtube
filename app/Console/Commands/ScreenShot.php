<?php

namespace App\Console\Commands;

use App\Http\Controllers\ScreenShotController;
use Illuminate\Console\Command;

class ScreenShot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'screenshot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    public function handle(ScreenShotController $screenShot)
    {
        $screenShot->ScreenShot();
    }
}
