<?php

namespace App\View\Components\Dashboard;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class NotificationsMenu extends Component
{

    public $notifications;
    public $NotificationsCount;
    /**
     * Create a new component instance.
     */
    public function __construct($count = 6)
    {
        $user = Auth::user();
        $this->notifications = $user->notifications()->take($count)->get();
        $this->NotificationsCount = $user->unreadnotifications()->count();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.notifications-menu');
    }
}
