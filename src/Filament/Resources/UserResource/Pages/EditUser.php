<?php

namespace Morbzeno\PruebaDePlugin\Filament\Resources\UserResource\Pages;

use App\Mail\SendMail;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;
use Morbzeno\PruebaDePlugin\Filament\Resources\UserResource;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];

    }

    protected function afterSave(): void
    {
        $user = $this->record;
        Mail::to($user->email)->send(new SendMail($user->name, $user->name));
    }
}
