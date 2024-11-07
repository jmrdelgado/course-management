<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

use App\Models\Programming;

class CourseProgrammingOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('CURSOS PROGRAMADOS', Programming::all()->count())->description('Total cursos comunicados')->color('success'),
            Stat::make('CURSOS INCIDENTADOS', Programming::query()->where('incident', 1)->count())->description('Total cursos incidentados')->color('warning'),
            Stat::make('CURSOS ANCLADOS', Programming::query()->where('canceled', 1)->count())->description('Total cursos anulados')->color('danger'),
        ];
    }
}