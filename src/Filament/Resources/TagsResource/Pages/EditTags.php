<?php

namespace Morbzeno\PruebaDePlugin\Filament\Resources\TagsResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Morbzeno\PruebaDePlugin\Filament\Resources\TagsResource;

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
