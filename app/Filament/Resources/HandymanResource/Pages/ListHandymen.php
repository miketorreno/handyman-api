<?php

namespace App\Filament\Resources\HandymanResource\Pages;

use App\Filament\Resources\HandymanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHandymen extends ListRecords
{
    protected static string $resource = HandymanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
