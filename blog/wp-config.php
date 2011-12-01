<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'seductiveblog');

/** MySQL database username */
define('DB_USER', 'stBlog');

/** MySQL database password */
define('DB_PASSWORD', '3QN6v8VFw29OqB3f4T7wn');

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
define('AUTH_KEY',         'G5Uct}X8eIx3Ua3[+>2%Y,9KmdJ|wr|g3JMz75E{rDL07W, WUNUZ2n3_L`RJdHx');
define('SECURE_AUTH_KEY',  'D(p8:d)p[D*ip>OhTmS,x-R{*<HKx2 NZa8+LD||PaM(G|HsH]E#<PY5IoT6olT1');
define('LOGGED_IN_KEY',    '*Zfb`haJp$0)W27Psz|E-oh5h7xsOH71aL%Z#:d+*ZRf~2g)Fb036~KgRk`d,5;D');
define('NONCE_KEY',        '403pZA6yg|VsAnp}2UdfPkVX<.(u?~=kaQs:~#V z;|N6!<as(0e$OJzPTmpiPhd');
define('AUTH_SALT',        'Q.7B4%-#/qWkB$![o3gza-{ 6|o=D]-FcxPJ8uU#D]#h~+C| I=c/u fvUjfQErJ');
define('SECURE_AUTH_SALT', 'iiw[O( 4[cabg$%)^#a7 2cnoM[-Qyev45ni=r#HWJ11DGV)o/q}vyZ*%ABmv59~');
define('LOGGED_IN_SALT',   'nKOC}&@!C|hE 2yh7IrLiSt66W5+l[dDo^x*&?w@MA<fmp&XzZ]c}Dpw.LZscu3n');
define('NONCE_SALT',       '}|;Bsa@$x/m=OCYXygE/tLF3lT9:wrj%t4*($5(@MK; j!:vj#4l7z=%)6{|Lqxj');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'st_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

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
