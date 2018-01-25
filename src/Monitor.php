<?php

namespace MatviiB\Scheduler;

use Carbon\Carbon;
use Cron\CronExpression;

use Illuminate\Console\Scheduling\Schedule;

trait Monitor
{
    /**
     * Head for output table in shell
     *
     * @var array
     */
    public $head = ['command', 'description', 'is_active', 'expression', 'w_o', 'interval'];

    /**
     * Monitoring standard application scheduled tasks
     *
     * @return mixed
     */
    public function standard()
    {
        $schedule = app(Schedule::class);

        return collect($schedule->events())
            ->map(function ($event) {

                $command = $this->command($event);

                return [
                    'command' => $command,
                    'description' => $this->description($command),
                    'is_active' => true,
                    'expression' => $event->expression,
                    'w_o' => ($event->withoutOverlapping) ? 1 : 0,
                    'interval' => $this->interval($event->expression),
                ];
            });
    }

    /**
     * Monitoring tasks scheduled with service
     *
     * @return mixed
     */
    public function database()
    {
        $tasks = Scheduler::select('command', 'description', 'is_active',
            'expression', 'without_overlapping as w_o')->get();

        return $tasks->each(function ($task) {
            $task->interval = $this->interval($task->expression);
            return $task;
        });
    }

    /**
     * Get interval from cron expression in "for humans" mode
     *
     * @param $expression
     * @return string
     */
    public function interval($expression)
    {
        $multiple = CronExpression::factory($expression)->getMultipleRunDates(2);
        $diff = $multiple[0]->getTimestamp() - $multiple[1]->getTimestamp();
        return Carbon::now()->addSeconds($diff)->diffForHumans(null, true);
    }

    /**
     * Get date of next command execution
     *
     * @param $expression
     * @return string
     */
    public function next($expression)
    {
        return CronExpression::factory($expression)->getNextRunDate()->format('Y-m-d H:i:s');
    }

    /**
     * Get command name
     *
     * @param $event
     * @return bool|string
     */
    private function command($event)
    {
        $command = $event->buildCommand();
        $command = substr($command, 0, strpos($command, '>'));
        $command = trim(str_replace([PHP_BINARY, 'artisan', '\'', '"'], '', $command));

        return $command;
    }

    /**
     * Get command description
     *
     * @param $command
     * @return string
     */
    private function description($command)
    {
        $className = get_class($this->getApplication()->find($command));
        $reflection = new \ReflectionClass($className);
        return (string)$reflection->getDefaultProperties()['description'];
    }
}