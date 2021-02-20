<?php

namespace App\Listeners;

use App\Events\mediaContentChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class mediaContentChangeListener
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
     * @param  mediaContentChanged  $event
     * @return void
     */
    public function handle(mediaContentChanged $event)
    {
        //
    }

}
