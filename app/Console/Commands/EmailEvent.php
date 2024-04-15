<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class EmailEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:email-event';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send update to email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
