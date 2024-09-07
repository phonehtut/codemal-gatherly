<?php

namespace App\Filament\Resources\FormDataResource\Pages;

use App\Filament\Resources\FormDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFormData extends ListRecords
{
    protected static string $resource = FormDataResource::class;

//    protected function getHeaderActions(): array
//    {
//        return [
//            Actions\CreateAction::make(),
//        ];
//    }
}
