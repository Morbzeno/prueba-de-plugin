<?php

namespace App\Filament\Pages;

use Illuminate\Contracts\Support\Htmlable;
use Filament\Pages\Dashboard as BasePage;

class Dashboard extends BasePage
{
      public function getSubheading(): string | Htmlable | null
      {
            if (auth()->user()->can('create_role')){
                  return '¡¡Bienvenido, super admin!!';

            }
            return null;
      }

      
}