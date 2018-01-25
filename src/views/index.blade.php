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
            Scheduled Tasks
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
        <table class="table is-striped is-fullwidth">
        <thead>
        <tr>
            <th>Command</th>
            <th>Description</th>
            <th>Is active</th>
            <th>Interval</th>
            <th>Last execution</th>
            <th>Next execution</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tasks as $task)
            <tr>
                <td>{{ $task->command }}</td>
                <td>{{ $task->description }}</td>
                <td>{{ $task->is_active }}</td>
                <td>{{ $task->interval }}</td>
                <td>{{ $task->last_execution }}</td>
                <td>{{ $task->next_execution }}</td>
                <td>
                    <a class="button is-primary is-small" onclick="run({{ $task->id }})">Run</a>
                    @if($task->is_active)
                        <a href="{{ route(config('scheduler.url') . '.toggle', $task) }}"
                           class="button is-danger is-small">Disable</a>
                    @else
                        <a href="{{ route(config('scheduler.url') . '.toggle', $task) }}"
                           class="button is-success is-small">Enable</a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
</section>
@endif
<script>
    async function run(id) {
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.open("GET", "{{ config('scheduler.url') }}/run/" + id, true);
        xmlHttp.send(null);
        await sleep(1000);
        location.reload(true);
    }

    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }
</script>
</body>
</html>