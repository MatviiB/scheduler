<p><img src="https://scrutinizer-ci.com/g/MatviiB/scheduler/badges/build.png?b=master" alt="build passed">
<a href="https://styleci.io/repos/118903237"><img src="https://styleci.io/repos/118903237/shield?branch=master" alt="StyleCI"></a>
<!-- <a href="https://scrutinizer-ci.com/g/MatviiB/scheduler" title="Code Quality"><img src="https://scrutinizer-ci.com/g/MatviiB/scheduler/badges/quality-score.png?b=master"> -->
<a href="https://packagist.org/packages/matviib/scheduler"><img src="https://poser.pugx.org/matviib/scheduler/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/matviib/scheduler"><img src="https://poser.pugx.org/matviib/scheduler/license.svg" alt="License"></a></p>

## [DEMO](https://matviib.com/scheduler/demo)

# Installation

## First steps
Add Provider for Laravel < 5.5
```
MatviiB\Scheduler\SchedulerServiceProvider::class,
```
Publish config and CronTasksList class files:
```
php artisan vendor:publish
```
and choose "Provider: MatviiB\Scheduler\SchedulerServiceProvider" if requested.

Files that must be published:
```
config/scheduler.php
app/Console/CronTasksList.php
```

Create database table:
```sh
 php artisan migrate
 ```
## Let's finish setup
###### Move your commands from `App\Console\Kernel` schedule() function to new file: `CronTasksList.php` trait.

Add next line to schedule() function instead of list of commands:

```php
<?php
 
namespace App\Console;
 
use MatviiB\Scheduler\Console\Kernel as SchedulerKernel;
 
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
 
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ..
        ..
    ];
 
    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // make changes just here
        // cut your commands from here
        // and write next line
        with(new SchedulerKernel())->schedule($schedule);
    }
```
Paste your commands to `app/Console/CronTasksList.php` trait:
```php
<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;

/**
 * Trait CronTasksList
 *
 * To use: uncomment all lines and copy your commands list
 * from app/Console/Kernel.php schedule() to tasks() function.
 *
 * @package App\Console
 */
trait CronTasksList
{
    public function tasks(Schedule $schedule)
    {
        // paste your commands here
        $schedule->command('example:command')->yearly()->withoutOverlapping();
    }
}
```

If everything done for now you can run next command, it will show your current commands list
```
php artisan scheduler:show
```

And you will see something like this
```
Scheduler is disabled.
You see standard tasks list.
+-----------------+------------------------------+-----------+-------------+-----+----------+
| command         | description                  | is_active | expression  | w_o | interval |
+-----------------+------------------------------+-----------+-------------+-----+----------+
| command:name    | Description for command:name | 1         | 0 * * * * * | 1   | 1 hour   |
| example:command | Command description          | 1         | * * * * * * | 1   | 1 minute |
+-----------------+------------------------------+-----------+-------------+-----+----------+

```

To use Scheduler you need to copy commands to schedulers table.
 
Note: every `scheduler:create` execution will soft delete old tasks and create fresh commands data.
```
php artisan scheduler:create
```

To use Scheduler you need enable it by adding to your `.env` next line:
 ```sh
SCHEDULER_ENABLED=true
```

Let's check status and scheduled tasks:
```
php artisan scheduler:show
```

And you will see something like this:
```
Scheduler is enabled.
You see scheduled tasks list configured with Scheduler.
+-----------------+------------------------------+-----------+-------------+-----+----------+
| command         | description                  | is_active | expression  | w_o | interval |
+-----------------+------------------------------+-----------+-------------+-----+----------+
| command:name    | Description for command:name | 1         | 0 * * * * * | 1   | 1 hour   |
| example:command | Command description          | 1         | * * * * * * | 1   | 1 minute |
+-----------------+------------------------------+-----------+-------------+-----+----------+
```
# Usage
You can manage your scheduled task on page `/scheduler` by default.

Also you are free to configure it yourself in `config/scheduler.php`.

After creating operation you will have your scheduled tasks list and it will ready to work but with scheduler you have some more powerfull things.

1. You can create different tasks for same command with different parameters and run it separately.

On the next screenshot you can see the same scheduled task for generate report with argument user equal 1 and option --client=2 for first task and argument user equal 3 and option --client=4 for next one.
![laravel scheduler](https://gitlab.com/MatviiB/assets/raw/master/y3Sxuz5dTEWmZS4pLsBuIQ.png)

This is how the creating task page looks like:
![laravel scheduler](https://gitlab.com/MatviiB/assets/raw/master/CzMUlry8Qcq3pr8WvZ-Opw.png)

2. Next powerfull thing - You can run your tasks from UI imediately with different arguments and options.

Next screenshot shows how it works:
![laravel scheduler](https://gitlab.com/MatviiB/assets/raw/master/dDiOSy3hSxKAOASqiFxFIA.png)

## License

Scheduler for Laravel is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
