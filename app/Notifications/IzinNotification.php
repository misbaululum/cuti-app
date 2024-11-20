<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class IzinNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private Model $model , private array $message)
    {
        $this->model = $model;
        $this->message = [
            'referensi_id' => $model->id,
            'referensi_type' => get_class($this->model),
            ...$message
        ];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toDatabase(object $notifiable): array
    {
        if (!isset($this->message['priority'])) {
            $this->message['priority'] = 1;
        }

        return $this->message;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('Ada pengajuan izin yang harus diproses dengan nomor ' . $this->model->nomor)
                    ->action('Proses Pengajuan', url("notifications/". $this->id))
                    ->line('Terimakasih!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
