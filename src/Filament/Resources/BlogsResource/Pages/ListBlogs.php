<?php

namespace Morbzeno\PruebaDePlugin\Filament\Resources\BlogsResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Morbzeno\PruebaDePlugin\Filament\Resources\BlogsResource;

class ListBlogs extends ListRecords
{
    protected static string $resource = BlogsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
