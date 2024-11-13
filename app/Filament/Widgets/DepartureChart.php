<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

use App\Models\Departure;

class DepartureChart extends ChartWidget
{
    protected static ?string $heading = 'Salidas Programadas por Meses';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $fechaActual = Carbon::now();

        $records = Departure::whereYear('start_at', $fechaActual->year)
            ->selectRaw('MONTH(start_at) as month, COUNT(*) AS totalreg')
            ->groupBy('month')
            ->get();

        $data = array_fill(0, 12, 0);

        foreach ($records as $record) {
            $data[$record->month - 1] = $record->totalreg;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Salidas Programadas por Mes',
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
