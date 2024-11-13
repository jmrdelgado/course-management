<?php

namespace App\Filament\Resources\DepartureResource\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use App\Filament\Resources\DepartureResource;
use App\Models\Departure;

class CalendarWidget extends FullCalendarWidget
{
     /**
     * FullCalendar will call this function whenever it needs new event data.
     * This is triggered when the user clicks prev/next or switches views on the calendar.
     */
    public function fetchEvents(array $fetchInfo): array
    {
        // You can use $fetchInfo to filter events by date.
        // This method should return an array of event-like objects. See: https://github.com/saade/filament-fullcalendar/blob/3.x/#returning-events
        // You can also return an array of EventData objects. See: https://github.com/saade/filament-fullcalendar/blob/3.x/#the-eventdata-class
        return Departure::query()
            ->where('start_at', '>=', $fetchInfo['start'])
            ->where('end_at', '<=', $fetchInfo['end'])
            ->get()
            ->map(
                fn (Departure $event) => [
                    'title' => $event->title,
                    'color' => $event->color,
                    'start' => $event->start_at,
                    'end' => $event->end_at,
                    'url' => DepartureResource::getUrl(name: 'edit', parameters: ['record' => $event]),
                    'shouldOpenUrlInNewTab' => false
                ]
            )
            ->all();
    }
}
