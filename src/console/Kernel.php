<?php

namespace MatviiB\Scheduler\Console;

use Schema;

use App\Console\CronTasksList;

use Carbon\Carbon;
use MatviiB\Scheduler\Scheduler;

use Illuminate\Console\Scheduling\Schedule;

class Kernel
{
    use CronTasksList;

    /**
     * Define the application's command schedule with Scheduler service
     *
     * @param \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    public function schedule(Schedule $schedule)
    {
        if (config('scheduler.enabled') && Schema::hasTable(config('scheduler.table'))) {
            $this->database($schedule);
        } else {
            $this->standard($schedule);
        }
    }

    /**
     * Standard command schedule. used when service is disabled
     *
     * @param Schedule $schedule
     * @return void
     */
    private function standard(Schedule $schedule)
    {
        $this->tasks($schedule);
    }

    /**
     * Schedule command with service. Used when service is enabled
     *
     * @param Schedule $schedule
     * @return void
     */
    private function database(Schedule $schedule)
    {
        $tasks = Scheduler::where('is_active', 1)->get();

        foreach ($tasks as $task) {
            if ($task->without_overlapping) {
                $schedule->command($task->command)
                    ->cron($task->expression)
                    ->withoutOverlapping()
                    ->before(function () use ($task) {
                        $task->last_execution = Carbon::now();
                        $task->save();
                    });
            } else {
                $schedule->command($task->command)
                    ->cron($task->expression)
                    ->before(function () use ($task) {
                        $task->last_execution = Carbon::now();
                        $task->save();
                    });
            }
        }
    }
}