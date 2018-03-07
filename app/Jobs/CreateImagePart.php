<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateImagePart implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $mapPartId;
    private $depth;

    public function __construct(string $mapPartId, int $depth)
    {
        $this->mapPartId = $mapPartId;
        $this->depth = $depth;
    }

    public function handle()
    {
        $dir = resource_path('assets/images/map-parts/') . $this->mapPartId;

        $args = implode(' ', [
            escapeshellarg($dir),
            escapeshellarg($this->depth),
        ]);
        shell_exec(resource_path('cli/map-creation-tools/CreateMapPart.sh') . ' ' . $args);
        return true;
    }
}
