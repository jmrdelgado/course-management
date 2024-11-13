<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

use App\Models\Programming;

class ProgrammingCourseChart extends ChartWidget
{
    protected static ?string $heading = 'Cursos Programados Por Meses';
    protected static ?int $sort = 4;
 
    protected function getData(): array
    {
        $fechaActual = Carbon::now();
        
        $records = Programming::whereYear('start_date', $fechaActual->year)
            ->selectRaw('MONTH(start_date) as month, COUNT(*) AS totalreg')
            ->groupBy('month')
            ->get();

        $data = array_fill(0, 12, 0); // Inicializa un array con 12 ceros, uno para cada mes

        foreach ($records as $record) {
            $data[$record->month - 1] = $record->totalreg; // Asigna el total de registros al mes correspondiente
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Cursos Programados por Mes',
                    'data' => $data,
                ],
            ],
            'labels' => ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ag', 'Sep', 'Oct', 'Nov', 'Dic'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
