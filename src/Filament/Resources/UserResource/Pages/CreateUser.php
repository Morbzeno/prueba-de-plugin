<?php

namespace Morbzeno\PruebaDePlugin\Filament\Resources\UserResource\Pages;

use Morbzeno\PruebaDePlugin\Filament\Resources\UserResource;
use Filament\Actions;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Illuminate\Auth\Events\Registered;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function afterCreate(): void
    {
        $user = $this->record;
        event(new Registered($this->record));
        $url = URL::temporarySignedRoute(
            'verification.verify', 
            Carbon::now()->addMinutes(60), 
            [
                'id' => $user->id,
                'hash' => sha1($user->email),
            ]
        );
    }




}
