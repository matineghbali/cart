<?php

namespace App\Listeners;

use App\Jobs\CreatedProductJob;
use App\Events\CreateProductEvent;
use App\Mail\CreatedProductMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CreateProductEvent $event): void
    {
        $product = $event->product;
        $user = User::role('admin')->first();
        if ($user) {
            Mail::to($user->email)->send(new CreatedProductMail($product));
        }

//        CreatedProductJob::dispatch($product);
    }
}
