<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'yF@d&w?#ZD0+# W8q9=ELT1VE$4|nI5}g$~(=K@:ditQ<Hev*.VBs(}9Cy5O.kl1' );
define( 'SECURE_AUTH_KEY',   'VZ0Cw.Bep#={~2]TD$W/ WdYOeC)f65F/MA`[mhJ*g~q1eSj]on-r#,d959!8?vx' );
define( 'LOGGED_IN_KEY',     'tMj$JcPHxMP5 wXv0 [%;R5&eOGG!(8{Nr+$RS2WE!=-t/^M6|eqfX(+qSCW7/PT' );
define( 'NONCE_KEY',         'Sfa6*if-b13y>-@+jHMArXYw9wiWhoFO~P:`o3aaCNa,[LO/T9EwT#q?<%yYx|<A' );
define( 'AUTH_SALT',         'B+&NH(W|K,8ObR,uPe)^/1!XYMxjy_1+vd-eKXE:1}39k+[4g.g+P[:Q2?Pv+g(W' );
define( 'SECURE_AUTH_SALT',  'Fr.]Iu`ZTBhmay3maMn}]tl2 UQ<64nwUU_[e8#u<md8vgI[lGUw gK~r&9!Hj^6' );
define( 'LOGGED_IN_SALT',    '!R(7<%MW=!-[E1`kdeK}{|(hEKKb(~eJq%Jp? zh+{fQ1kgPv!$jme@e|1A[BnI8' );
define( 'NONCE_SALT',        'G [@7h,L`5xFh,M*NtT~;<-NBo(-Fjz9n6mPrwu-YVfF}R:Ca/bv,r6jD8=-7e&0' );
define( 'WP_CACHE_KEY_SALT', './}Yly|{XL5Pz+{iPH,B(*>[kOYX[RCy@2Li!g=pn8SQT+::jyM=&spgjvmO-U|n' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
