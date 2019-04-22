<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Scheduler</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css">
</head>
<body style="margin-top: 50px">
<nav class="navbar is-light is-fixed-top" role="navigation" aria-label="main navigation">
    <div class="navbar-menu">
        <div class="navbar-start">
            <div class="navbar-item">
                <a class="button" href="{{ config('scheduler.nav-button.href') }}">
                    {{ config('scheduler.nav-button.text') }}
                </a>
            </div>
        </div>
    </div>
</nav>
<form method="POST" action="{{ route(config('scheduler.name') . '.update', $task) }}">
    <section class="section">
        <div class="container">
            <div class="columns">
                <div class="column">
                    <h1 class="title">
                        Edit task: {{ $task->command }}
                    </h1>
                    <p class="subtitle">
                        @if(config('scheduler.enabled'))
                            Status: Enabled
                        @else
                            Status: Disabled
                        @endif
                    </p>
                </div>
                <div class="column">
                    <div class="field is-grouped is-pulled-right">
                        <div class="control">
                            <a href="{{ route(config('scheduler.name') . ".index") }}" class="button">Cancel</a>
                        </div>
                        <div class="control">
                            <button class="button is-link">Save</button>
                        </div>
                    </div>
                </div>
                <div class="column"></div>
                <div class="column"></div>
            </div>
        </div>
    </section>
    @if(config('scheduler.enabled'))
        <section>
            <div class="container">
                <div class="columns">
                    <div class="column">


                        <input type=hidden name=_method value=PATCH>

                        <div class="columns">
                            <div class="column">
                                <div class="field">
                                    <label class="label">Command Name</label>
                                    <div class="control">
                                        <input class="input" name="command" type="text" placeholder="command:name" value="{{ $task->command }}">
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="field">
                                    <label class="label">Default parameters</label>
                                    <div class="control">
                                        <input class="input" name="default_parameters" type="text" value="{{ $task->default_parameters }}">
                                    </div>
                                    <p class="help">Example: user=1 --client=1  </p>
                                </div>
                            </div>
                        </div>

                        <article class="message is-info">
                            <div class="message-header">
                                <p>Info</p>
                            </div>
                            <div class="message-body">
                                <p>Use default parameters for scheduling with Cron OR set up arguments and options to allow manual start with different settings.</p>
                                <p>If default parameters exists, task will use them only. You can't run this task with other arguments and options.</p>
                                <p>Create another task with the same command for use with different settings.</p>
                            </div>
                        </article>

                        <div class="columns">
                            <div class="column">
                                <div class="field">
                                    <label class="label">Arguments</label>
                                    <div class="control">
                                        <input class="input" name="arguments" type="text" value="{{ $task->arguments }}">
                                    </div>
                                    <p class="help">Comma separate arguments names</p>
                                </div>
                            </div>
                            <div class="column">
                                <div class="field">
                                    <label class="label">Options</label>
                                    <div class="control">
                                        <input class="input" name="options" type="text" value="{{ $task->options }}">
                                    </div>
                                    <p class="help">Comma separate options names</p>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="field">
                            <label class="label">Description</label>
                            <div class="control">
                                <input class="input" name="description" type="text" value="{{ $task->description }}">
                            </div>
                        </div>

                        <div class="columns">
                            <div class="column">
                                <div class="field">
                                    <label class="label">Expression</label>
                                    <div class="control">
                                        <div class="select">
                                            <select  name="expression">
                                                <option value="{{ $task->expression }}">{{ config('scheduler.expressions')[$task->expression] }}</option>
                                                @foreach(config('scheduler.expressions') as $value => $desc)
                                                    <option value="{{ $value }}">{{  $desc }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="field">
                                    <div class="control">
                                        <label class="checkbox">
                                            <input type="checkbox" name="is_active" @if($task->is_active) checked @endif>Is active
                                        </label>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <label class="checkbox">
                                            <input type="checkbox" name="without_overlapping" @if($task->without_overlapping) checked @endif>Without overlapping
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="column"></div>
                </div>
            </div>
        </section>
    @endif
</form>
</body>
</html>