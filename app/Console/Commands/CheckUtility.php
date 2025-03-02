<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckUtility extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-utility';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $mesage = "hello";
        send_notification($mesage);
    }
}
