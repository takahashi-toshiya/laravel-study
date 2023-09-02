<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;

class RegisteredListener
{
    private $mailer;
    private $eloquent;

    /**
     * Create the event listener.
     */
    public function __construct(Mailer $mailer, User $eloquent)
    {
        $this->mailer = $mailer;
        $this->eloquent = $eloquent;
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        $user = $this->eloquent->findOrFail($event->user->getAuthIdentifier());
        $this->mailer->raw('会員登録完了しました', function ($message) use ($user){
            $message->subject('会員登録メール')->to($user->email);
        });
    }
}
