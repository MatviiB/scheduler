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
<section class="section">
    <div class="container">
        <div class="is-pulled-left">
            <h1 class="title">
                Scheduled Tasks
            </h1>
            <p class="subtitle is-pulled-left">
                @if(config('scheduler.enabled'))
                    Status: Enabled
                @else
                    Status: Disabled
                @endif
            </p>
        </div>
        <a href="{{ route(config('scheduler.url') . '.create') }}" class="button is-primary is-pulled-right">Create new</a>
    </div>
    <br>
    <br>
</section>
@if(config('scheduler.enabled'))
    <section>
        <div class="container">
            <table class="table is-striped is-fullwidth">
                <thead>
                <tr>
                    <th>Command (parameters)</th>
                    <th>Description</th>
                    <th>Is active</th>
                    <th>Interval</th>
                    <th>Last/Next execution</th>
                    <th><div class="is-pulled-right">Actions</div></th>
                </tr>
                </thead>
                <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->command }} {{ $task->default_parameters }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->is_active }}</td>
                        <td>{{ $task->interval }}</td>
                        <td>{{ $task->last_execution ?? '-------' }}<br>{{ $task->next_execution }}</td>
                        <td>
                            <div class="buttons has-addons is-right">
                                <a class="button is-small" href="{{ route(config('scheduler.url') . '.edit', $task) }}">Edit</a>
                                @if($task->default_parameters)
                                    <a class="button is-primary is-small" onclick="send('{{ $task->id }}')">Run</a>
                                @elseif($task->arguments or $task->options)
                                    <a class="button is-primary is-small" onclick="submit('{{ $task->id }}')">Run</a>
                                @else
                                    <a class="button is-primary is-small" onclick="send('{{ $task->id }}')">Run</a>
                                @endif

                                @if($task->is_active)
                                    <a href="{{ route(config('scheduler.url') . '.toggle', $task) }}"
                                       class="button is-warning is-small">Disable</a>
                                @else
                                    <a href="{{ route(config('scheduler.url') . '.toggle', $task) }}"
                                       class="button is-success is-small">Enable</a>
                                @endif
                                <form action="{{ route(config('scheduler.url') . '.delete') }}" method="POST">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="task" value="{{ $task->id }}">
                                    <button type="submit" class="button is-danger is-small" onclick="if(!confirm('Are you sure?')) {return false}">X</button>
                                </form>
                            </div>

                            @if(!$task->default_parameters)
                                <form id="form-{{ $task->id }}">
                                    @if($task->arguments)
                                        @foreach(explode(',', $task->arguments) as $argument)
                                            <p class="help">Argument: {{ $argument }}</p>
                                            <input type="text" name="{{ $argument }}" class="input is-small" placeholder="argument value">
                                        @endforeach
                                    @endif
                                    @if($task->options)
                                        @foreach(explode(',', $task->options) as $option)
                                            <p class="help">Option: {{ $option }}</p>
                                            <input type="text" name="{{ $option }}" class="input is-small" placeholder="option value">
                                        @endforeach
                                    @endif
                                </form>
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
    var params = '';

    function submit(id) {
        for (var i = 0; i < document.getElementById('form-' + id).elements.length; i++) {
            if (document.getElementById('form-' + id).elements[i].value) {
                if (params !== '') {
                    params += '&';
                }
                params += document.getElementById('form-' + id).elements[i].name + '=' + document.getElementById('form-' + id).elements[i].value;
            }
        }

        send(id);
    }

    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    async function send(id) {
        if (confirm('Command will start immediately!')) {
            var xmlHttp = new XMLHttpRequest();
            xmlHttp.open("GET", "scheduler/run/" + id + "?" + params);
            xmlHttp.send(null);
            await sleep(1000);
            location.reload(true);
        } else {
            params = '';
            return false;
        }

    }
</script>
</body>
</html>