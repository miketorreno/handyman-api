<?php

namespace App\Filament\Resources\HandymanResource\Pages;

use App\Filament\Resources\HandymanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHandyman extends EditRecord
{
    protected static string $resource = HandymanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
