<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'admin_urban');

/** Имя пользователя MySQL */
define('DB_USER', 'sr_project');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', 'qwerty');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'qY?x$3l%7.D{:]fi2nKfy}(!8fjd~#?@mki1*~Qt_&=*,Z1-$R4RUWS)P9MDY-J{');
define('SECURE_AUTH_KEY',  '^l<4d3M?|^ST/e!2tSeF}ieytk(U|q&&WwdP8-$,vh`Nh/{{-oi$tv`[-7+4NF_[');
define('LOGGED_IN_KEY',    '}R^APvPR}oVH-uaKn*qEJOGK%3#SB+$l4nkp-_cyjjlPrCo1F@~olr&yfS-PS,[F');
define('NONCE_KEY',        'Q(ukb05kfxYO-170S*iyC)cZF4)bDreA?V5cbbz/.7!s)g_Qyl0PU;Gq3V3r=$<E');
define('AUTH_SALT',        'jB-U<Xi8$#*R(/e+HXc+4f{2XtRHVr|-UedvFj1$L:o0g`Z40N0jy+u[:^;lYMgx');
define('SECURE_AUTH_SALT', '+uEose<[|aVbL=]hlfO= S1ym,p1~o^w86+F2),^G8D*byB#VmWhA0 Hxp2}}|bY');
define('LOGGED_IN_SALT',   '=2a0]}{X&laZx*%dh {Um6x2+tf-+uBB8i+@Qltt$r0?JcHyB-kv,c&amz#-|.uU');
define('NONCE_SALT',       'n`9k)=emT5G*$bF`O++x(YuIi@LIx^gXtB1|6jcrVmrQaJ+K Vb13<&J&;[%g-5H');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 * 
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
