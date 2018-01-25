<?php

namespace MatviiB\Scheduler\Console\Commands;

use Schema;

use MatviiB\Scheduler\Monitor;

use Illuminate\Console\Command;

class Show extends Command
{
    use Monitor;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduler:show';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monitor scheduled commands in application';

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
        if (config('scheduler.enabled') && Schema::hasTable(config('scheduler.table'))) {
            $this->info('Scheduler is enabled.');
            $this->info('You see scheduled tasks list configured with Scheduler.');
            $this->table($this->head, $this->database());
        } else {
            $this->info('Scheduler is disabled.');
            $this->info('You see standard tasks list.');
            $this->table($this->head, $this->standard());
        }
    }
}