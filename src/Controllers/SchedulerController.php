<?php

namespace MatviiB\Scheduler\Controllers;

use Carbon\Carbon;

use MatviiB\Scheduler\Monitor;
use MatviiB\Scheduler\Scheduler;

use Illuminate\Support\Facades\Artisan;

class SchedulerController
{
    use Monitor;

    /**
     * Service index page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $tasks = Scheduler::get();

        foreach ($tasks as $task) {
            $task->interval = $this->interval($task->expression);
            $task->next_execution = $this->next($task->expression);
        }

        return view('scheduler::index', compact('tasks'));
    }

    /**
     * Toggle status for task
     *
     * @param $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggle($task)
    {
        $task = Scheduler::find($task);
        $task->is_active = !$task->is_active;
        $task->save();

        return redirect()->route(config('scheduler.url') . '.index');
    }

    /**
     * Run requested task manually
     *
     * @param $task
     * @return void
     */
    public function run($task)
    {
        $task = Scheduler::find($task);
        $task->last_execution = Carbon::now();
        $task->save();

        Artisan::call($task->command);
    }
}