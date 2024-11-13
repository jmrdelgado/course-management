<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

use App\Models\Programming;

class DepartureDatesOverview extends BaseWidget
{
    protected static ?int $sort = 2;
    
    protected function getStats(): array
    {
        $fechaActual = Carbon::now();
        $records = Programming::whereYear('start_date', $fechaActual->year)->whereMonth('start_date', $fechaActual->month)
            ->selectRaw('start_date, COUNT(*) AS totalreg')
            ->groupBy('start_date')->orderBy('start_date')->get();

        $paneles = [];

        foreach ($records as $value) {
            $paneles [] = Stat::make('SALIDA DEL ' . Carbon::parse($value->start_date)->format('d-m-Y'), $value->totalreg)->description('Total de Cursos Previstos')->color('success');
        }

        return $paneles;
    }
}
