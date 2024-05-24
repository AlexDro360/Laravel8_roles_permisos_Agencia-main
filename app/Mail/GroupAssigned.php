<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Grupo;
use App\Models\Materia;
use App\Models\User;
use App\Models\Dia;  // Assuming there is a Dia model to get the names of the days

class GroupAssigned extends Mailable
{
    use Queueable, SerializesModels;

    public $profesor;
    public $grupo;
    public $materia;
    public $horaInicio;
    public $horaFin;
    public $dias;

    public function __construct(User $profesor, Grupo $grupo, Materia $materia, $horaInicio, $horaFin, $dias)
    {
        $this->profesor = $profesor;
        $this->grupo = $grupo;
        $this->materia = $materia;
        $this->horaInicio = $horaInicio;
        $this->horaFin = $horaFin;

        // Fetch the day names from the Dia model assuming $dias contains day IDs
        $dayNames = Dia::whereIn('id', $dias)->pluck('nombre')->toArray();
        $this->dias = implode(', ', $dayNames); // Convert array to string
    }

    public function build()
    {
        return $this->view('emails.group_assigned')
                    ->with([
                        'profesorName' => $this->profesor->name,
                        'grupoClave' => $this->grupo->clave,
                        'materiaNombre' => $this->materia->nombre,
                        'grupoPeriodo' => $this->grupo->periodo,
                        'horaInicio' => $this->horaInicio,
                        'horaFin' => $this->horaFin,
                        'dias' => $this->dias,
                    ]);
    }
}