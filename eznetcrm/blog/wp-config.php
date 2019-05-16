<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'eZnetcrmBlog');

/** MySQL database username */
define('DB_USER', 'erp_mkb');

/** MySQL database password */
define('DB_PASSWORD', 'Isb40868)2');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'M!ON6+AF6lTM3Z5=Sp615Tn(i7J=-S*~nx(RQ~^aXb*Vr-Onc-*<|>`P%jz9c69,');
define('SECURE_AUTH_KEY',  '/?mOdME&|)T/[qdtcB;*sJ@x8{FH@lXY>HP-BucM0:|)XBgI0>R9eq9*j}PC<Q(4');
define('LOGGED_IN_KEY',    '+xZOTCj1^bdyw%K4eE/S5:]t_[-L)|Py:L~&pR~vC#J85VsX7vve)<$rR>g|}Nf]');
define('NONCE_KEY',        'n2,Tw|6Wk0iPkC#[sdUOA47bq|duwKqsp 9zMdfiMgRnejMS*tcVo+AxnLk[/Up|');
define('AUTH_SALT',        ',OW`{mUOUQ<=Bkwc!.lRZhCw`{a!F>7kYV-+9>*axZc i+3+TN|mvuzry<d>~9[E');
define('SECURE_AUTH_SALT', 'nhSamdENTalR5zWI_miCpUglZin#JONVSNpbcdb5Cu>juURg[p)|rOmu%%;XmcH]');
define('LOGGED_IN_SALT',   'l,0|bITCLrMj|9+,g*8UaWD>Q(84C.tUcoK0=d/PU65`uX /H<0,g=wIGi+dQ8p+');
define('NONCE_SALT',       '< j`<ZG-rG&R|7zcA&`(&FPiRwDq o|o*T{Es3C4+gN+zOj^8|7]=9xlu*Ld~)XL');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

define('FS_METHOD','direct');
