<?php

namespace App\Jobs;

use App\Models\Song;
use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class SongEnqueue extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $path;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $path)
    {
        $this->path = $path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $cmd = "/usr/bin/mpg123 " . $this->path;
        
        shell_exec ($cmd);
    }
}
