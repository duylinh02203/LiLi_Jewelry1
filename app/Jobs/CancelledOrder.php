<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class CancelledOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $orderWithItems;
    public function __construct($orderWithItems)
    {
        $this->orderWithItems = $orderWithItems;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::send('cms.checkout.email_cancelled_order', [
            'order' => $this->orderWithItems,
        ], function ($message) {
            $message->from(config('mail.from.address'), config('mail.from.name'))
                ->to($this->orderWithItems->email)
                ->subject(__('Đơn hàng của bạn đã được hủy'));
        });
    }
}
