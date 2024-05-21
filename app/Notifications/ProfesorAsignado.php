<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProfesorAsignado extends Notification
{
    use Queueable;

    protected $grupo;
    protected $materia;

    /**
     * Create a new notification instance.
     *
     * @param $grupo
     * @param $materia
     */
    public function __construct($grupo, $materia)
    {
        $this->grupo = $grupo;
        $this->materia = $materia;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Nuevo Grupo Asignado')
                    ->line('Usted ha sido asignado al grupo: ' . $this->grupo->clave)
                    ->line('Materia: ' . $this->materia->nombre)
                    ->line('Periodo: ' . $this->grupo->periodo)
                    ->line('Gracias por su atención.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'grupo_id' => $this->grupo->id,
            'materia_id' => $this->materia->id,
            'grupo_clave' => $this->grupo->clave,
            'materia_nombre' => $this->materia->nombre,
            'periodo' => $this->grupo->periodo,
        ];
    }
}