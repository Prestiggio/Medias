<?php

namespace Ry\Medias\Console\Commands;

use Illuminate\Console\Command;
use Ry\Medias\Models\PullEndpoint;

class Pull extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rymedias:pull';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $endpoints = PullEndpoint::all();
        foreach($endpoints as $endpoint) {
            $this->line("export LFTP_PASSWORD='".$endpoint->nsetup['password']."'");
            $commands = $endpoint->nsetup['commands'];
            foreach($endpoint->files as $file) {
                foreach($commands as $command) {
                    $command = str_replace(":filename", $file->filename, $command);
                    $command = str_replace(":id", $file->id, $command);
                    $this->line($command);
                }
            }
        }
    }
}
