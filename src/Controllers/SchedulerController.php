<?php

namespace MatviiB\Scheduler\Controllers;

use Carbon\Carbon;

use MatviiB\Scheduler\Monitor;
use MatviiB\Scheduler\Scheduler;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SchedulerController extends Controller
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
     * @param $request
     * @return void
     */
    public function run($task, Request $request)
    {
        $task = Scheduler::find($task);
        $task->last_execution = Carbon::now();
        $task->save();

        $params = ($task->default_params) ? $task->default_params : $request->all();

        Artisan::call($task->command, $params);
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
        $task->default_parameters = $request->input('default_parameters');
        $task->arguments = $request->input('arguments');
        $task->options = $request->input('options');
        $task->description = $request->input('description') ?? $request->input('command');
        $task->expression = $request->input('expression');
        $task->is_active = ($request->has('is_active')) ? true : false;
        $task->without_overlapping = ($request->has('without_overlapping')) ? true : false;
        $task->save();

        return redirect()->route(config('scheduler.url') . '.index');
    }

    /**
     * Edit task
     *
     * @param $task
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($task)
    {
        return view('scheduler::edit', ['task' => Scheduler::find($task)]);
    }

    /**
     * Update task
     *
     * @param $task
     * @param Request $request
     * @return mixed
     */
    public function update($task, Request $request)
    {
        $task = Scheduler::find($task);
        $task->command = $request->input('command');
        $task->default_parameters = $request->input('default_parameters');
        $task->arguments = $request->input('arguments');
        $task->options = $request->input('options');
        $task->description = $request->input('description') ?? $request->input('command');
        $task->expression = $request->input('expression');
        $task->is_active = $request->input('is_active') ? true : false;
        $task->without_overlapping = $request->input('without_overlapping') ? true : false;
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