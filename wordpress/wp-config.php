<?php
/**
 * Основные параметры WordPress.
 *
 * Этот файл содержит следующие параметры: настройки MySQL, префикс таблиц,
 * секретные ключи и ABSPATH. Дополнительную информацию можно найти на странице
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Кодекса. Настройки MySQL можно узнать у хостинг-провайдера.
 *
 * Этот файл используется скриптом для создания wp-config.php в процессе установки.
 * Необязательно использовать веб-интерфейс, можно скопировать этот файл
 * с именем "wp-config.php" и заполнить значения вручную.
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'aequivph_diadell');

/** Имя пользователя MySQL */
define('DB_USER', 'aequivph_diadell');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', 'as210100');

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
define('AUTH_KEY',         's;/)Cf9>Mv5Bw(Z7{k!}q`K6Kb~;GQyAt2GNMTz>6I~+3~BaW?-mn2+5 1HUG Fw');
define('SECURE_AUTH_KEY',  'U%,$#@%4%[-xc1e~&zq3PCj|vr>F>[t>neDpbb-Yxx6@>i7weM2sGd[%>B!==j:=');
define('LOGGED_IN_KEY',    'p#P 8U{]w78)e<D4XZH+lg:BJ%{;d%_%dUY~X]-=)ACV3g{|iKJ8_VZ.ta?dvJ7-');
define('NONCE_KEY',        'ZPurX}}X4),ee*i~[:~<AvNOVzrKU9q-^ln.5?I`tN?999W-+/F^-,gw5 ~i-sHg');
define('AUTH_SALT',        'Pf{k>-3g1@`mcqi9):e`%]F{p=p>e+8Xkd6f77?dzf.n1y|`  (G0-T,?I7~j{27');
define('SECURE_AUTH_SALT', 'wz/|Xjb %R.{%|Syz4qUTF:pD!;fPHsSrn%zoR!XoU7d @+N+Fpu`EFl02rzWn]M');
define('LOGGED_IN_SALT',   'X>a|]|=rmSdiB~mkG-O)Q3h}_VhZUo%p*|P2=?cWu%7aiwVvZS.QZS*GeI`*PZm(');
define('NONCE_SALT',       'Si3ShJD8c!L4PgP_%A?qH#P)VRZt]YO[+ 9ZI-zxheHzJ5@mzQz58e[19PG@v&%2');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'dd_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
