<?php

namespace App\Filament\Widgets;

use App\Models\Programming;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class CourseProgrammingPOverview extends BaseWidget
{
    use HasWidgetShield;
    
    protected ?string $heading = 'Cursos Modalidad P-M-AV';
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $incidentP = Programming::query()->where('incident', 1)->where('modality', 'P')->count();
        $incidentM = Programming::query()->where('incident', 1)->where('modality', 'M')->count();
        $incidentAV = Programming::query()->where('incident', 1)->where('modality', 'AV')->count();
        $totalincident = $incidentP + $incidentM + $incidentAV;

        $canceledP = Programming::query()->where('canceled', 1)->where('modality', 'P')->count();
        $canceledM = Programming::query()->where('canceled', 1)->where('modality', 'M')->count();
        $canceledAV = Programming::query()->where('canceled', 1)->where('modality', 'AV')->count();
        $totalcanceled = $canceledP + $canceledM + $canceledAV;

        return [
            Stat::make('PROGRAMADOS', Programming::query()->where('modality', 'P')->orWhere('modality', 'M')->orWhere('modality', 'AV')->count())->description('Total cursos comunicados')->descriptionIcon('heroicon-o-check-badge')->color('success'),
            Stat::make('INCIDENTADOS', $totalincident)->description('Total cursos incidentados')->descriptionIcon('heroicon-o-exclamation-triangle')->color('warning'),
            Stat::make('ANULADOS', $totalcanceled)->description('Total cursos anulados')->descriptionIcon('heroicon-s-no-symbol')->color('danger'),
        ];
    }
}
