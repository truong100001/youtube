<?php

namespace App\Console\Commands;

use App\Http\Controllers\UploadVideoController;
use Illuminate\Console\Command;

class UploadVideoYoutube extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'uploadvideo';

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
    public function handle(UploadVideoController $controller)
    {
        $controller->UploadController();
    }
}
