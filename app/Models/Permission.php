<?php

// app/Models/Permission.php
namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use CreatedUpdatedBy;

    // Custom properties and methods
    protected $guard_name = 'web'; // Default guard
    protected $description;
}