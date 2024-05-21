<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Grupo;
use App\Models\Materia;
use App\Models\User;

class GroupAssigned extends Mailable
{
    use Queueable, SerializesModels;

    public $profesor;
    public $grupo;
    public $materia;

    public function __construct(User $profesor, Grupo $grupo, Materia $materia)
    {
        $this->profesor = $profesor;
        $this->grupo = $grupo;
        $this->materia = $materia;
    }

    public function build()
    {
        return $this->view('emails.group_assigned')
                    ->with([
                        'profesorName' => $this->profesor->name,
                        'grupoClave' => $this->grupo->clave,
                        'materiaNombre' => $this->materia->nombre,
                        'grupoPeriodo' => $this->grupo->periodo,
                    ]);
    }
}