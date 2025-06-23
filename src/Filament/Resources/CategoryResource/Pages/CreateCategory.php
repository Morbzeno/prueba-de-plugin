<?php

namespace Morbzeno\PruebaDePlugin\Filament\Resources\CategoryResource\Pages;

use Morbzeno\PruebaDePlugin\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;
}
