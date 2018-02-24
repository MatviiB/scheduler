<?php

namespace MatviiB\Scheduler\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use MatviiB\Scheduler\Monitor;
use MatviiB\Scheduler\Scheduler;

class Create extends Command
{
    use Monitor;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduler:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create scheduled tasks in database from standard applications tasks';

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
        if (config('scheduler.enabled')) {
            $this->error('Please disable scheduler in your .env file first');
            exit;
        }

        if (!Schema::hasTable(config('scheduler.table'))) {
            $this->error('Table for scheduled tasks does not exist.');
            $this->error("Run 'php artisan migrate'.");
            exit;
        }

        Scheduler::get()->each(function ($task) {
            $task->delete();
        });

        $commands = $this->standard();

        foreach ($commands as $command) {
            $task = new Scheduler();
            $task->command = $command['command'];
            $task->is_active = $command['is_active'];
            $task->expression = $command['expression'];
            $task->description = $command['description'];
            $task->without_overlapping = $command['w_o'];
            $task->save();
        }

        $this->info('Tasks successfully created.');
    }
}
