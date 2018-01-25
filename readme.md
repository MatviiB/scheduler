### Installation

Add Provider for Laravel < 5.5
```
MatviiB\Scheduler\SchedulerServiceProvider::class,
```
Publish config:
```sh
 php artisan vendor:publish --provider=SchedulerServiceProvider --tag="config"
```
Move your commands from App\Console\Kernel schedule function and use ScheduleKernel instead
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
        // your commands list
    ];
 
    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //make changes just here
        with(new SchedulerKernel())->schedule($schedule);
    }
 
    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
```
Paste your commands to MatviiB\Scheduler\Console\Kernel class
```php
private function standard(Schedule $schedule)
    {
        // your commands list here
        $schedule->command('your:command')->hourly()->withoutOverlapping();
    }
```
Create database table:
```sh
 php artisan migrate
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
 
Note: every scheduler:create execution will truncate and create fresh commands data 
```
php artisan scheduler:create
```
To use Scheduler you need enable it by adding to your .env 
 ```sh
SCHEDULER_ENABLED=true
```
Lets check status and scheduled tasks
```
php artisan scheduler:show
```
And you will see something like this
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
You can manage your scheduled task on page /scheduler by default. But you also free to configure it yourself.