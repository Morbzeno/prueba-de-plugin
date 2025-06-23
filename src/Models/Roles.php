<?php

namespace Morbzeno\PruebaDePlugin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Roles extends Role
{
    use HasFactory;

    protected $fillable = [
        'name',
        'guard_name'
    ];

    // public function permissions()
    // {
    //     return $this->belongsToMany(\Spatie\Permission\Models\Permission::class, 'rol_has_permissions');
    // }
}
