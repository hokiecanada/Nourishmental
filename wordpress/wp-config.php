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
define('DB_NAME', 'nourishmental');

/** MySQL database username */
define('DB_USER', 'wordpress');

/** MySQL database password */
define('DB_PASSWORD', '2kB$yXLi7TaE');

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
define('AUTH_KEY',         'K3q_JDR<WgIvv%1=R}`FbsNC}g+ 7{2RQ~;zkFY]#<D^2<v)?=gD8/t;-HP!OB*r');
define('SECURE_AUTH_KEY',  '5OjfgXAP>G>[ZRv{5X@i @p1M |Ytsv_ %+zox5g uua5:sQ[gf>d+P-6wbO^|@;');
define('LOGGED_IN_KEY',    '#%<(zeZ@~ <#%|Y-4fa$7PanF=cbwVj.ugJQY0Z5J(+a/IxOaK#;2+Vo6ZFGS5=@');
define('NONCE_KEY',        '6Ube2hXjvE+xF%Q5]a<(.HD |>?DD8re?dAqzjy-:6-|( u#xis-6zgM3|WF6=hW');
define('AUTH_SALT',        'OtIpOGn=U>|b-2A:}d #iK6%0&YPn6(fl+W$}L2}{oh-5/HWlg-NZF8oz^]k-PMi');
define('SECURE_AUTH_SALT', 'S+f;0N,hHA3SErBKX*.26zRy7dnR):6ek,Y`no^|R5+;]nuk[I+iR1ZoiJ{*=nMq');
define('LOGGED_IN_SALT',   'c-TY2++lZknRz:,2YQ^2_$gVfJ9fnfb|t-eQ}a,|HCtP1azOMz$zTNJ3$dGsfotR');
define('NONCE_SALT',       'g#tFn^.siV^lk=eNyihi%K+a!Ht#Yw-U1uurQ4ZXO;RXzbCZ/.I.@aN}3}:1CCaL');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
