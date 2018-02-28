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
define('DB_NAME', 'demo4zke_dev4_makehappen');
/** MySQL database username */
define('DB_USER', 'demo4zke_dbuser');
/** MySQL database password */
define('DB_PASSWORD', 'OrAC2_!+?b=9');
/** MySQL hostname */
define('DB_HOST', 'localhost');
/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');
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
define('AUTH_KEY', 'f+*,+3J~:kFEakEVfq::l,Qbf3SKCJT><$2_Ln@xl/r:Z`yMni_NhqZytT#XuoA$');
define('SECURE_AUTH_KEY', '(5|JhaY_lFWJBe!hjK0! #8w,PRH2b>l,3@hl)<i3)PqI7<EC%o7+b+9bJYXWOH`');
define('LOGGED_IN_KEY', 'Ieovg^ABH;^Jf={y2O}.p[VBu^TbTe+]_3/<$S~&m~Gyh|us{wXme~+%HZ8u*X/a');
define('NONCE_KEY', '_,BU%LH6{{6 V7Fh>4I5+C/EmBv{Ev(e/4&SR1WpHC],Hp0Oc63oC*$Ld/#*]12Y');
define('AUTH_SALT', 'i2qHfD/;dmQ(v]PT4L5y&lb</T{6P2>%5<w[ FM*ZQBe[XQ_?~W%QwrLA4GuCKC]');
define('SECURE_AUTH_SALT', '[Zc!#5Nqf,]Ry>l# CYe)f1O:kRQd{}?LX]8?i1d_BXjB>HU2gD*!|+<_o][ikV*');
define('LOGGED_IN_SALT', '8.ZU*=l ;?szk@y8EH!`vg;kj<k,0fG%Wd!}q)pUuc+}1V#pEN[y^JM%hkIW0-V}');
define('NONCE_SALT', 'Cm%D}#GQN0fvE,YotMw@Fbx]=1THO!)GH!-Nf]Rn3;ujGYz@]}-.Xkdkf&#ODIos');
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);
define('WP_DEBUG_LOG', false);
/* That's all, stop editing! Happy blogging. */
/** Absolute path to the WordPress directory. */

if (!defined('ABSPATH'))
	{
	define('ABSPATH', dirname(__FILE__) . '/');
	}

/** Sets up WordPress vars and included files. */
require_once (ABSPATH . 'wp-settings.php');
