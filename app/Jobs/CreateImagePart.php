<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateImagePart implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $dir;
    private $depth;

    public function __construct(string $dir, int $depth)
    {
        $this->dir   = $dir;
        $this->depth = $depth;
    }

    public function handle()
    {
        $dir  = storage_path('app/' . $this->dir);
        $args = implode(' ', [
            escapeshellarg($dir),
            escapeshellarg($this->depth),
        ]);
        shell_exec(resource_path('cli/map-creation-tools/CreateMapPart.sh') . ' ' . $args);
        return true;
    }
}
