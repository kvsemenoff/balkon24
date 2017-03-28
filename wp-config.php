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
define('DB_NAME', 'balkon');

/** Имя пользователя MySQL */
define('DB_USER', 'root');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         '<G.5z=gnf.,26E%V&@3P;O$?N/+4R)%Pp|7p~E+{?[u0RUa9U?cF9(aD#Ry1ux Q');
define('SECURE_AUTH_KEY',  'j7ucVv>#.l2at7lw9voo(LW)`)$I)2}JTStOA3l~9WOc-0?1bWpzx5lH]|/QOEM!');
define('LOGGED_IN_KEY',    '8t:7N`_3k5s <(Z7ZHLCV+)0+H9{nSK`eEl+q4~j!hG_1]@=$l6+sm__z4CIIeV}');
define('NONCE_KEY',        '-KvU-Y^i@S`=< ![8Wa*0-*9j-5Gq@a7-JFl^mF|=>z*bo-yqR[N;<Ce6m+|pL %');
define('AUTH_SALT',        'Of{g+CQ-+1L|SfTSM6IAe.B=E:p+ioMW+u5Y$8A1L|+XQ-~BTez=2Tc&w/^|ez+P');
define('SECURE_AUTH_SALT', 'ZD1B1wr.0Xo*ik;VAq[]c,<m(lguRb.#AKd7~|QC8|#.jQ)w0Gvt|:eh.y;2Vg$|');
define('LOGGED_IN_SALT',   ')scU{Hk>vQF opS)CB9|nMUko&*IcjlLHk*%uw|HZyL=LKO~Jg-cEBJF{;0DfIm-');
define('NONCE_SALT',       'S,/N %Z73-!(u#qa~W%KoLDIc9g*|&MGNv)307#&R+4b# QU, Uh(qBhT`$:U`F(');

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
