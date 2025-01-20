<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Carbon\Carbon;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

use App\Models\Programming;

class DepartureChart extends ChartWidget
{
    use HasWidgetShield;

    protected static ?string $heading = 'Total Cursos Programados. Modalidad: TF';
    protected static bool $isLazy = true;
    protected static string $color = 'info';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $fechaActual = Carbon::now();

        /* $records = Departure::whereYear('start_at', $fechaActual->year)
            ->selectRaw('MONTH(start_at) as month, COUNT(*) AS totalreg')
            ->groupBy('month')
            ->get(); */

        $records = Programming::whereYear('start_date', $fechaActual->year)
            ->selectRaw('MONTH(start_date) as month, COUNT(*) AS totalreg')
            ->where('modality','TF')
            ->groupBy('month')
            ->get();

        $data = array_fill(0, 12, 0);

        foreach ($records as $record) {
            $data[$record->month - 1] = $record->totalreg;
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
