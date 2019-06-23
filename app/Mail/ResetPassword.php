<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\URL;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $resettingUrl = env('RESET_PASSWORD').'?token='.$this->user->token;
        $logoUrl = URL::to('/api/logo');
        return $this->view('resetPassword')
            ->with([
                'resettingUrl' => $resettingUrl,
                'logoUrl' => $logoUrl
            ]);
    }
}
