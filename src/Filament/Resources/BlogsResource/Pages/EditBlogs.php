<?php

namespace Morbzeno\PruebaDePlugin\Filament\Resources\BlogsResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Morbzeno\PruebaDePlugin\Filament\Resources\BlogsResource;

class EditBlogs extends EditRecord
{
    protected static string $resource = BlogsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
