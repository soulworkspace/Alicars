<?php

namespace App\Livewire;

use Livewire\Component;

class NotificationBell extends Component
{
    public $unreadCount = 0;
    public $notifications = [];
    public $showDropdown = false;
    
    public function mount()
    {
        $this->refreshNotifications();
    }
    
    public function refreshNotifications()
    {
        if (auth()->check()) {
            $this->unreadCount = auth()->user()->unreadNotifications()->count();
            $this->notifications = auth()->user()
                ->notifications()
                ->take(5)
                ->get()
                ->toArray();
        }
    }
    
    public function markAsRead($notificationId)
    {
        if (auth()->check()) {
            $notification = auth()->user()->notifications()->find($notificationId);
            if ($notification) {
                $notification->markAsRead();
                $this->refreshNotifications();
            }
        }
    }
    
    public function markAllAsRead()
    {
        if (auth()->check()) {
            auth()->user()->unreadNotifications->markAsRead();
            $this->refreshNotifications();
        }
    }
    
    public function toggleDropdown()
    {
        $this->showDropdown = !$this->showDropdown;
    }
    
    public function render()
    {
        return view('livewire.notification-bell');
    }
}
