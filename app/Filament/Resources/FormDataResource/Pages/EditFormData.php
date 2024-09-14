<?php

namespace App\Filament\Resources\FormDataResource\Pages;

use App\Filament\Resources\FormDataResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFormData extends EditRecord
{
    protected static string $resource = FormDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
