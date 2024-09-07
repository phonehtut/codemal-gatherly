<?php

namespace App\Filament\Resources\FormDataResource\Pages;

use App\Filament\Resources\FormDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFormData extends ViewRecord
{
    protected static string $resource = FormDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
