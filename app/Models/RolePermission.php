<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class RolePermission extends Model
{
    use HasFactory;

    protected $table = 'role_permissions';

    protected $fillable = [
        'role',
        'Product_Set',
        'Profile_Set',
        'System_Users_Set',
        'Permissions_Set',
    ];

    public function users()
    {
    return $this->hasMany(User::class, 'role_id');
    }
}