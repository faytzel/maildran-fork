<?php

declare(strict_types=1);

namespace App\Listeners\Queue;

use Illuminate\Queue\Events\Looping;
use DB;

class ClearPreviousQueueJobFailedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Looping  $event
     * @return void
     */
    public function handle(Looping $event) : void
    {
        // rollback any transactions that were left open by a previously failed job
        while (DB::transactionLevel() > 0) {
            DB::rollBack();
        }
    }
}
