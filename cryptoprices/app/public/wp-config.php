<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'tmgXQcB2J+r+8RgEU4LEvrCXAqD0CWOOBVxPQFOpWII6EOcz6tWfJn2dFZIUqLTlrVX9J7/dARMsgk9zjp62qw==');
define('SECURE_AUTH_KEY',  'GxJeygvvvX9r76k+VTe11S9NR2aDm2hGHlvXLz05G7ELPxjOMMaLoxcp17VkMAkQPobFqK9IECL09zs24E1Nig==');
define('LOGGED_IN_KEY',    'Su/BVL4nUQzS/4NGQevLQHLnPVXSDO7Dr1h/+8oYyVTuwmgpbZRvabsYL+SCrsg7se0Hbn0SJNAZLSAoQRNiBg==');
define('NONCE_KEY',        'ESnghYIDeiT7CAHxGei6ZKzm1UJWOxsuwMdUOK5Eh+i+qhsqwEphWM3Vd9n2v5y++lxgOKkF8My+gjKBEd6UiA==');
define('AUTH_SALT',        '8P5q4zXGh5fqfGpRmbxVIj6g3FZTOsyIEqMzPD/mJs902jfTXd9y1HGV0mY1khCSn6m/yafN6py2L5numpRtYQ==');
define('SECURE_AUTH_SALT', '9K8hqEdb+taUlQemOV42w5RqUHQ5t04whMg+hxL71KIbQwpWWZb+lM2d2+K2AdL14ujGZY4kXrYNQVXefcLRIw==');
define('LOGGED_IN_SALT',   'YXOgSUR6d5RQB7I1jmOkP+7EoBqmcKEEgucbFNCAevx6UF3qCZoMXh3tB/Y6ExgYq0miRpSZqja5iKSo2Qw8/A==');
define('NONCE_SALT',       'SUJasqDzk3/yDg5WgHszHb28bgvFVVA3wjTEEj8zZz1AMJW7vU+BNrE9wTEy1POtJkx+ctgwI8f9MSUPVJbH1Q==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
