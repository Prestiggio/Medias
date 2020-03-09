<?php

namespace Ry\Medias\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Ry\Medias\Models\PullFile;

class FileStatusChange extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rymedias:status {status} {file_id} {path?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the status of pulled or pushed file';

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
        $stdin = fopen('php://stdin', 'r');
        $content = '';
        while (!feof($stdin)) {
            $content .= fread($stdin, 1024);
        }
        fclose($stdin);
        $file = PullFile::find($this->argument('file_id'));
        if($file) {
            $file_setup = $file->nsetup;
            $time = Carbon::now()->format('Y-m-d H:i:s');
            $file_setup['status'][$time] = $content!='' ? $content : $this->argument('status');
            $file_setup['path'][$time] = $this->argument('path');
            $file->nsetup = $file_setup;
            $file->save();
        }
    }
}
