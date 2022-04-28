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
define('DB_NAME', 'ci99361_vape');

/** Имя пользователя MySQL */
define('DB_USER', 'ci99361_vape');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', 'qwerty123');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'TBDp@Z9m+(a[+F0@K3+w*vqm@tA}soASb~e}d1Pp}B]?O<|P8ZSZYb[|6GkX4Nl,');
define('SECURE_AUTH_KEY',  'm%,[Ok>X.$1TDU7);zp|0j8Q5D&QJcbZP!fi$p(pE[g9$^ps)eS*b%}bBY,}N7fH');
define('LOGGED_IN_KEY',    'r.~f+EqYQvbV@TW`2~p5_+Fi[LmE1jey[B47#*H<7adAY^883h7QUvub6eG>B:@6');
define('NONCE_KEY',        ',a2>e=2a1qjLBXbdUC<-amtSX}A4Q<4([ipEb*.*`8!jG%_5&x 4ND=HjC+Zf`XO');
define('AUTH_SALT',        'TJELR=zQ%Of!/}`hdp&piJxZ-6*N`|d#;h!(y]#7p@fh5*b,X?#Gu> 126t4V#bh');
define('SECURE_AUTH_SALT', 'SR-4`c~Il9-8iek=i~@F`mk I_$.=*[Xr`) 8}5TcobLpl`.7]f%rTDHF}_j+=$S');
define('LOGGED_IN_SALT',   '2MJI|MKOPFL>Ty<OB)|6wd,#4}gx+?xM(.czao{,=C}T~qyq@W5$+HOHWSdK2r9}');
define('NONCE_SALT',       '3(zqpcD5Jc9DMmb]=MTFY^lU{g2ePsMw#vhDBG{v6o2JVvHIm/DOR`TaCc#tHHOe');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_liquid_';

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

define('WPCF7_AUTOP', false); // Disable autop
//define ('WPCF7_LOAD_JS', false); // Added to disable JS loading
define ('WPCF7_LOAD_CSS', false); // Added to disable CSS loading

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
