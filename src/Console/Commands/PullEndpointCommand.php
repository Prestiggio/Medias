<?php

namespace Ry\Medias\Console\Commands;

use Illuminate\Console\Command;
use Ry\Medias\Models\PullEndpoint;
use Carbon\Carbon;
use Ry\Medias\Models\PullFile;

class PullEndpointCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rymedias:ls {endpoint_id} {abspath?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List files from remote and insert into queue';

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
        $endpoint = PullEndpoint::find($this->argument('endpoint_id'));
        
        $stdin = fopen('php://stdin', 'r');
        $content = '';
        while (!feof($stdin)) {
            $content .= fread($stdin, 1024);
        }
        fclose($stdin);
        preg_match_all("/([^\s]+)\r?\n/", $content, $ar);
        $files = [];
        if(count($ar)>=2) {
            foreach($ar[1] as $filename) {
                if(preg_match("/^\.+$/", $filename))
                    continue;
                if(!$endpoint->files()->whereFilename($filename)->exists()) {
                    $files[] = [
                        'abspath' => $this->argument('abspath'),
                        'filename' => $filename,
                        'setup' => json_encode([
                            'ls' => Carbon::now()->format('Y-m-d H:i:s')
                        ])
                    ];
                }
            }
        }
        if(count($files)>0) {
            PullFile::unguard();
            $endpoint->files()->createMany($files);
            PullFile::reguard();
        }
    }
}
