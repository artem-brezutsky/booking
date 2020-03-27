<?php

return [

    /*
    |--------------------------------------------------------------------------
    | LDAP Enabled
    |--------------------------------------------------------------------------
    |
    | Whether or not LDAP authorization should be used.
    |
    */

    'enabled' => env('LDAP_ENABLED', false),

    /*
    |--------------------------------------------------------------------------
    | LDAP Only
    |--------------------------------------------------------------------------
    |
    | Whether or not only LDAP authorization should be used. If LDAP authorization
    | is disabled then this option does nothing.
    |
    */

    'ldap_only' => env('LDAP_ONLY', true),

    /*
    |--------------------------------------------------------------------------
    | LDAP Host
    |--------------------------------------------------------------------------
    |
    | Host your LDAP is available on.
    |
    */

    'host' => env('LDAP_HOST', 'localhost'),

    /*
    |--------------------------------------------------------------------------
    | LDAP Port
    |--------------------------------------------------------------------------
    |
    | LDAP port to use. Port 389 is used by default.
    |
    */

    'port' => env('LDAP_PORT', 389),

    /*
    |--------------------------------------------------------------------------
    | LDAP Protocol Version
    |--------------------------------------------------------------------------
    |
    | Major version number for LDAP protocol version to use.
    |
    */

    'protocol_version' => env('LDAP_PROTOCOL_VERSION', 3),

    /*
    |--------------------------------------------------------------------------
    | LDAP Reader DN
    |--------------------------------------------------------------------------
    |
    | LDAP distinguished name of reader account.
    |
    */

    'reader_dn' => env('LDAP_READER_DN', ''),

    /*
    |--------------------------------------------------------------------------
    | LDAP Reader Password
    |--------------------------------------------------------------------------
    |
    | LDAP password of reader account.
    |
    */

    'reader_password' => env('LDAP_READER_PASSWORD', ''),

    /*
    |--------------------------------------------------------------------------
    | LDAP Users Group DN.
    |--------------------------------------------------------------------------
    |
    | Users group's distinguished name.
    |
    */

    'users_group_dn' => env('LDAP_USERS_GROUP_DN', ''),

    /*
    |--------------------------------------------------------------------------
    | LDAP Login Field
    |--------------------------------------------------------------------------
    |
    | Login field to auth with in user's record.
    |
    */

    'login_field' => env('LDAP_LOGIN_FIELD', ''),

    /*
    |--------------------------------------------------------------------------
    | LDAP Filter
    |--------------------------------------------------------------------------
    |
    | Filter to use when searching for user. :uid will be replaced with user
    | login.
    |
    */

    'filter' => env('LDAP_FILTER', ''),

    /*
    |--------------------------------------------------------------------------
    | LDAP Import Map.
    |--------------------------------------------------------------------------
    |
    | Map of fields to import from LDAP user entity to DB one.
    |
    */

    'import_map' => env('LDAP_IMPORT_MAP'),

];
