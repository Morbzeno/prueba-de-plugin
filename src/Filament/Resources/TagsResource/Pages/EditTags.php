<?php

namespace Morbzeno\PruebaDePlugin\Filament\Resources\TagsResource\Pages;

use Morbzeno\PruebaDePlugin\Filament\Resources\TagsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTags extends EditRecord
{
    protected static string $resource = TagsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
