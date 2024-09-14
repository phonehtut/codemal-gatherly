<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\EventResource;
use App\Models\Event;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    public function fetchEvents(array $fetchInfo): array
    {
        return Event::query()
            ->where('start_date', '>=', $fetchInfo['start'])
            ->where('end_date', '<=', $fetchInfo['end'])
            ->get()
            ->map(
                fn (Event $event) => [
                    'title' => $event->id,
                    'start' => $event->start_date,
                    'end' => $event->end_date,
                    'url' => EventResource::getUrl(name: 'view', parameters: ['record' => $event]),
                    'shouldOpenUrlInNewTab' => true
                ]
            )
            ->all();
    }

    public Model | string | null $model = Event::class;

    public function getFormSchema(): array
    {
        return [
            TextInput::make('title'),

            Grid::make()
                ->schema([
                    DatePicker::make('start_date'),

                    DatePicker::make('end_date'),
                ]),
        ];
    }
}
