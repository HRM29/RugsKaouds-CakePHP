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
define( 'DB_NAME', 'zadmin_ecommrug' );

/** MySQL database username */
define( 'DB_USER', 'ecommrug' );

/** MySQL database password */
define( 'DB_PASSWORD', 'jy2ydaty7' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',         'C MDDXG$2k4!U!7?}0On$&p*cT3DH{}I-o$]M|aGN ]neFwl0;@.>dWo2+!<yvq7' );
define( 'SECURE_AUTH_KEY',  '{]&?w1Oc.cPbAcViaWx*XbD!6f)m.L#;%(W&zRT(:;Pz`6Ya:WXW+hm>!<kmf/U7' );
define( 'LOGGED_IN_KEY',    '8pFpe+x_W^[L[=95V*R|xL<VxaLNABe*`c?l=a qLuqGApONYhO[P:q^A+kh;9)P' );
define( 'NONCE_KEY',        '#<[(e&0L^d}[rCqQDOd=;`lid#BSWl4rbihA([3sBC6)({v-}!yL7V;FWb9[MdW(' );
define( 'AUTH_SALT',        '*s.JPm=]Lcr)xnF>#FIu.X]LI&`32<3cGfa#/M*yj7}I9DT)5Zc#x# Be!+d7DPQ' );
define( 'SECURE_AUTH_SALT', '[UdyAqj,L~F:WOxvb_qE&zun@|/{Sw.~qe|(?u_+Eb}dnT6qZX@C_HK#SexdJz?y' );
define( 'LOGGED_IN_SALT',   'Xwa>1/ONIHOERDmxM<YbZN%cVn Pq=.l!w$AB*@}t=(Cd#=+y+=&]>&{R{M(XEL3' );
define( 'NONCE_SALT',       'F/;(nWYN;(F>}o^F?xTOJD&;mEZ&tM@ RuhrZK^GggD,dxK;|u0+,4LE$wxGd~yd' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'rugsnc_wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
