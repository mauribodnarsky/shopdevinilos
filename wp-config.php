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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'elshopdelosvinilos' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'ROOT' );

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
define( 'AUTH_KEY',         '[G+1qG{;iu}EXTd?_4S:Ga?oF(z#_e)Lx*?oVGXvq0M,+`g:wo*i;+8=U3nrxyYt' );
define( 'SECURE_AUTH_KEY',  'Q]s?fC)wQfj:5vl&lExe:t7{*ps0mI*nc095G$0fF!t7kI6C>gOJ<!hCWt*W#O0;' );
define( 'LOGGED_IN_KEY',    'e5[27Jq3$W$O&QyyAs8(}KYXzx8Z;0Z)uLret[S|)mTufZLW,%9YEf*6!@}b^KJ]' );
define( 'NONCE_KEY',        '5G0%TK!J7%+,kYeR2k$lj7MDy&QoayjU?rX~Nw0nE1G{Tj8PasJ9*Su1({%t7IZ&' );
define( 'AUTH_SALT',        'iIE&W&upN 1?gN|C9a!* cWK[!5+VtAKJDI)icyURZzpMn?^^`QK+uKVv%p;{Mm6' );
define( 'SECURE_AUTH_SALT', 'h|-v*tpocjaN_t*+-b,gt9^MCt4LL0T5M (I1%pJXKQ_f^[coLjC%nzP HDo-6?E' );
define( 'LOGGED_IN_SALT',   'zkCr;96@Y.|OiyZq|+u9+9SE:fwE_ea+DFTXkpJ[_u9sn17tVtM|b`2(&J_08f93' );
define( 'NONCE_SALT',       'wWIOxP/H[($-`+O4MZ06:~~q>j#a6<Uq2x2|VwJ@Rf`d*OdJ2OYjx7}7bSA!vC~Y' );

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

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
