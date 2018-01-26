<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Scheduler</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css">
</head>
<body>
<section class="section">
    <div class="container">
        <h1 class="title">
            Create new task
        </h1>
        <p class="subtitle">
            @if(env('SCHEDULER_ENABLED'))
                Status: Enabled
            @else
                Status: Disabled
            @endif
        </p>
    </div>
</section>
@if(env('SCHEDULER_ENABLED'))
    <section>
        <div class="container">
            <div class="columns">
                <div class="column">

                    <form method="POST" action="{{ route(config('scheduler.url') . '.store') }}">

                    <div class="field">
                        <label class="label">Command Name</label>
                        <div class="control">
                            <input class="input" name="command" type="text" placeholder="command:name">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Description</label>
                        <div class="control">
                            <input class="input" name="description" type="text">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Expression</label>
                        <div class="control">
                            <div class="select">
                                <select  name="expression">
                                    <option value="* * * * * *">Every minute</option>
                                    <option value="*/5 * * * * *">Every 5 minutes</option>
                                    <option value="*/10 * * * * *">Every 10 minutes</option>
                                    <option value="*/15 * * * * *">Every 15 minutes</option>
                                    <option value="*/30 * * * * *">Every 30 minutes</option>
                                    <option value="0 * * * * *">Every hour</option>
                                    <option value="0 0 * * * *">One per day</option>
                                    <option value="0 0 * * 0 *">One per week</option>
                                    <option value="0 0 1 * * *">One per month</option>
                                    <option value="0 0 1 1-12/3 * *">One per 2 months</option>
                                    <option value="0 0 1 1 * *">One per year</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <label class="checkbox">
                                <input type="checkbox" name="is_active">
                                Is active
                            </label>
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <label class="checkbox">
                                <input type="checkbox" name="without_overlapping">
                                Without overlapping
                            </label>
                        </div>
                    </div>

                    <div class="field is-grouped">
                        <div class="control">
                            <button class="button is-link">Submit</button>
                        </div>
                        <div class="control">
                            <button class="button is-text">Cancel</button>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="column"></div>
            </div>
        </div>
    </section>
@endif
</body>
</html>