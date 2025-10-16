<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SimpleAlert extends Notification
{
    use Queueable;

    public function __construct(
        public string $title,
        public string $body,
        public ?string $url = null
    ) {}

    // قنوات الإرسال: قاعدة بيانات فقط
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    // ما يُخزّن في جدول notifications
    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'body'  => $this->body,
            'url'   => $this->url,
        ];
    }
}
