<!DOCTYPE html>
<html>
<head>
    <title>Asignación de Grupo</title>
</head>
<body>
    <h1>Hola, {{ $profesorName }}</h1>
    <p>Se le ha asignado un nuevo grupo.</p>
    <p><strong>Clave del Grupo:</strong> {{ $grupoClave }}</p>
    <p><strong>Materia:</strong> {{ $materiaNombre }}</p>
    <p><strong>Periodo:</strong> {{ $periodo }}</p>
    <p><strong>Hora de Inicio:</strong> {{ $horaInicio }}</p>
    <p><strong>Hora de Fin:</strong> {{ $horaFin }}</p>
    <p><strong>Días:</strong> {{ $dias }}</p>
</body>
</html>