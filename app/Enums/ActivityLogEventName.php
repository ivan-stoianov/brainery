<?php

namespace App\Enums;

enum ActivityLogEventName: string
{
    case ADMIN_AUTH_LOGIN = "admin.auth.login";
    case ADMIN_AUTH_LOGOUT = "admin.auth.logout";

    case USER_ADMIN_CREATED = "users.admin.created";
    case USER_ADMIN_UPDATED = "users.admin.updated";
    case USER_ADMIN_ENABLED = "users.admin.enabled";
    case USER_ADMIN_DISABLED = "users.admin.disabled";

    case ADMIN_SETTINGS_UPDATED = "admin.settings.updated";
}
