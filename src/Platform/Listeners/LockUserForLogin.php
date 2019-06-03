<?php

declare(strict_types=1);

namespace Orchid\Platform\Listeners;

use Illuminate\Http\Request;
use Illuminate\Cookie\CookieJar;
use Illuminate\Auth\Events\Login;

class LockUserForLogin
{
    /**
     * @var \Illuminate\Cookie\CookieJar
     */
    private $cookie;

    /**
     * LogSuccessfulLogin constructor.
     *
     * @param \Illuminate\Cookie\CookieJar $cookieJar
     */
    public function __construct(CookieJar $cookieJar)
    {
        $this->cookie = $cookieJar;
    }

    /**
     * Handle the event.
     *
     * @param Login $event
     *
     * @return void
     */
    public function handle(Login $event)
    {
        if (! $event->remember) {
            return;
        }

        $user = $this->cookie->forever('lockUser', $event->user->id);

        $this->cookie->queue($user);
    }
}
