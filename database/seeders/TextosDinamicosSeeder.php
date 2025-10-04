<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TextoDinamico;

class TextosDinamicosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $añoActual = date('Y') + 1;

        // Texto de declaración jurada
        TextoDinamico::create([
            'clave' => 'declaracion_jurada',
            'titulo' => 'Declaración Jurada',
            'contenido' => '<strong>La solicitud de beca</strong> tiene carácter de declaración jurada y su presentación da inicio a un procedimiento de evaluación del estado de necesidad económica de la familia solicitante a fin de acceder a una beca para el año lectivo ' . $añoActual . '.',
            'seccion' => 'paso1',
            'activo' => true,
            'orden' => 1,
            'año_lectivo' => $añoActual,
        ]);

        // Texto de evaluación de beca
        TextoDinamico::create([
            'clave' => 'evaluacion_beca',
            'titulo' => 'Evaluación de Beca',
            'contenido' => 'El otorgamiento de la beca y el porcentaje de la misma será determinado por el <strong>Colegio</strong>, que tiene la atribución de evaluar y verificar la información proporcionada, así como solicitar el sustento de la misma. La evaluación es una actividad interna y reservada del Colegio, por lo que únicamente los resultados serán comunicados a los padres o tutores.',
            'seccion' => 'paso1',
            'activo' => true,
            'orden' => 2,
            'año_lectivo' => $añoActual,
        ]);
    }
}
