<?php

namespace App\Jobs;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AppDeferredStart implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $app;

    /**
     * Create a new job instance.
     *
     * @param Task $application
     */
    public function __construct(Task $application)
    {
        $this->app = $application;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $newStatus = !$this->app->active;

        if ($this->app->paid && $this->app->moderated && $this->app->accepted && !$this->app->done && $newStatus) {

            $this->app->update([
                'deferred_start' => null,
                'active' => $newStatus
            ]);

            dispatch(new SendNewTaskNotification($this->app));

        }


    }
}
