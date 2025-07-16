<?php

// app/Models/Role.php
namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use CreatedUpdatedBy;

    // Custom properties and methods
    protected $guard_name = 'web'; // Default guard
    protected $description;
}