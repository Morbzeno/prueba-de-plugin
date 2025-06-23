<?php

namespace Morbzeno\PruebaDePlugin\Filament\Resources\BlogsResource\Pages;

use Morbzeno\PruebaDePlugin\Filament\Resources\BlogsResource;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

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
