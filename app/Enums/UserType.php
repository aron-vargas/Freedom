<?php

namespace App\Enums;

enum UserType: string
{
    case User = 'user';
    case System = 'system';
}