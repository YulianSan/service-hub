<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case SUPPORT = 'support';
    case VIEWER = 'viewer';
    case DEVELOPER = 'developer';
}
