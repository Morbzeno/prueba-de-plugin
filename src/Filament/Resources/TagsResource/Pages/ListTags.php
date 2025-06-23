<?php

namespace Morbzeno\PruebaDePlugin\Filament\Resources\TagsResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Morbzeno\PruebaDePlugin\Filament\Resources\TagsResource;

class ListTags extends ListRecords
{
    protected static string $resource = TagsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
