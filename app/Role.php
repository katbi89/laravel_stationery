<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * The permissions that belong to role.
     */
    public function permissions()
    {
        return $this->belongsToMany('App\Permission', 'role_permissions')->using('App\RolePermission');
    }
}
