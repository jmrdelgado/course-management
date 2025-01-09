<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

use App\Models\Programming;

class CourseProgrammingOverview extends BaseWidget
{
    use HasWidgetShield;
    
    protected ?string $heading = 'Cursos Modalidad TF';
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('PROGRAMADOS', Programming::query()->where('modality', 'TF')->count())->description('Total cursos comunicados')->descriptionIcon('heroicon-o-check-badge')->color('success'),
            Stat::make('INCIDENTADOS', Programming::query()->where('incident', 1)->where('modality', 'TF')->count())->description('Total cursos incidentados')->descriptionIcon('heroicon-o-exclamation-triangle')->color('warning'),
            Stat::make('ANULADOS', Programming::query()->where('canceled', 1)->where('modality', 'TF')->count())->description('Total cursos anulados')->descriptionIcon('heroicon-s-no-symbol')->color('danger'),
        ];
    }
}