<?php
// app/Models/Role.php
namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $fillable = ['name', 'guard_name', 'id_empresa'];

    public function empresa()
{
    return $this->belongsTo(Empresa::class, 'id_empresa');
}

}

