<?php

namespace Morbzeno\PruebaDePlugin\Filament\Resources\BlogsResource\Pages;

use Morbzeno\PruebaDePlugin\Filament\Resources\BlogsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBlogs extends CreateRecord
{
    protected static string $resource = BlogsResource::class;
}
