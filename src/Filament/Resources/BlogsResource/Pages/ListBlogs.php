<?php

namespace Morbzeno\PruebaDePlugin\Filament\Resources\BlogsResource\Pages;

use Morbzeno\PruebaDePlugin\Filament\Resources\BlogsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

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
