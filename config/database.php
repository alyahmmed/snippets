<?php

/*
    Custom database configuration to read from ENV variable
     DATABASE_URL, for example: mysql://root@localhost:3306/db_name
 */
$db_vars = parse_url(getenv('DATABASE_URL'));
$db_driver = isset($db_vars['scheme']) &&
    $db_vars['scheme'] == 'postgres' ? 'pgsql' : 'mysql';

$db_config = [
    'host' => isset($db_vars['host']) ? $db_vars['host'] : '',
    'port' => isset($db_vars['port']) ? $db_vars['port'] : '',
    'database' => isset($db_vars['path']) ?
        ltrim($db_vars['path'],'/') : '',
    'username' => isset($db_vars['user']) ? $db_vars['user'] : '',
    'password' => isset($db_vars['pass']) ? $db_vars['pass'] : '',
];

$mysql_config = $pgsql_config = $db_config;

$mysql_config['driver'] = 'mysql';
$mysql_config['charset'] = 'utf8mb4';
$mysql_config['collation'] = 'utf8mb4_unicode_ci';
$mysql_config['prefix'] = '';
$mysql_config['strict'] = true;
$mysql_config['engine'] = null;

$pgsql_config['driver'] = 'pgsql';
$pgsql_config['charset'] = 'utf8';
$pgsql_config['prefix'] = '';
$pgsql_config['schema'] = 'public';
$pgsql_config['sslmode'] = 'prefer';

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => $db_driver,

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],

        'mysql' => $mysql_config,

        'pgsql' => $pgsql_config,

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => 'predis',

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],

    ],

];
