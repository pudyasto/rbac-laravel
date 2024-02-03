<?php

namespace App\Console\Commands;

use App\CustomClass\Rbac;
use Illuminate\Console\Command;

class GenRoleModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generaye role module akses';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Rbac::generateRoleModule();
    }
}
