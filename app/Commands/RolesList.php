<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Http;
use LaravelZero\Framework\Commands\Command;

class RolesList extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'roles:list {environment}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'List Roles';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    
        $environment = $this->argument('environment');

        $environmentBaseUri = getenv(strtoupper($environment));
        $environmentKey = getenv(strtoupper($environment)."_KEY");

        $response = Http::withHeaders(
            [
                'X-DreamFactory-Api-Key' => $environmentKey
            ]
        )->get($environmentBaseUri . "system/service?fields=id,name");

        $responseArray = json_decode($response->getBody()->getContents(), true);

        $headers = ["Name", "ID"];

        $this->table($headers, $responseArray['resource']);

    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
