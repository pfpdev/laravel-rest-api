<?php

namespace App\Enums;

enum RoleSlug: string
{
    // Admin area
    case ADMIN_SUPER   = 'admin.super';
    case ADMIN_STAFF   = 'admin.staff';

    // Business area
    case BUSINESS_OWNER  = 'business.owner';
    case BUSINESS_STAFF = 'business.staff';
}
