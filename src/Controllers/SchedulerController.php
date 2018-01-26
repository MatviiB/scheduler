<?php

namespace MatviiB\Scheduler\Controllers;

use Carbon\Carbon;

use MatviiB\Scheduler\Monitor;
use MatviiB\Scheduler\Scheduler;

use Illuminate\Http\Request;
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

    /**
     * Create a new task
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('scheduler::create');
    }

    /**
     * Store new task
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (!$request->filled('command')) {
            return redirect()->route(config('scheduler.url') . '.index');
        }

        $task = new Scheduler();
        $task->command = $request->input('command');
        $task->description = $request->input('description');
        $task->expression = $request->input('expression');
        $task->is_active = ($request->has('is_active')) ? true : false;
        $task->without_overlapping = ($request->has('without_overlapping')) ? true : false;
        $task->save();

        return redirect()->route(config('scheduler.url') . '.index');
    }

    /**
     * Delete task (soft delete)
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        Scheduler::find($request->input('task'))->delete();

        return redirect()->route(config('scheduler.url') . '.index');
    }
}