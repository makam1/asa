<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'barawa_db' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'passer' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '7K|(_HXqc%PLn&nzI>G01~R,>=tRHhz~IB n*lQ%&M{w5|@v%v@`.gQIc+_,*:f3' );
define( 'SECURE_AUTH_KEY',  '}]D|RZ3@n`:N[jM>IH3v*L&_m9 $znCb,6y)pFX80sz^zwXBuL~$S@i*;=WFJ/wF' );
define( 'LOGGED_IN_KEY',    'cF|Px:/Lx)L>j,if}w2~HMKuI6{AUjx6rgLHsoI<]1Ac<X-U&_Iq^KSbc8I{iTK0' );
define( 'NONCE_KEY',        '5jvxZuy+yszb-dd:dm0(;Sup&:@3rgVy,M]uF!]/:-_1Fyq]Z8c%73H>sTZ&0l&h' );
define( 'AUTH_SALT',        'Zlx>}?+MZO3yh+[3Rg:|!~|i<1P5>=&|141<B1ev*^({^>4#L-V{o~d A+Mu]!30' );
define( 'SECURE_AUTH_SALT', 'eXfmo= !4sMa[8T.X(*)0]@Ia`j=$,vfQk_,Y/`=XU1))PkqR~V%#HTj~(eurVp*' );
define( 'LOGGED_IN_SALT',   'cWTw#lPb[ZJBy:qG?cqKd+{}-5~a;e{z=Ib!M/|eo]ARS6(>48d^NB*,6]8,6>Pz' );
define( 'NONCE_SALT',       '**00<@aFk@TkWweK**I=G>WnDPW-]6Th?w J- kPt:fa|<Gx+y+bj,Qtcf8n&Hi`' );



/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}
/*Augmenter la taille memoire*/
define('WP_MEMORY_LIMIT', '96M');

/*Desactiver et/ou limiter les revisions*/
define('WP_POST_REVISIONS', false);


/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
