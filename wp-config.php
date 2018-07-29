<?php
/**
 * A configuração de base do WordPress
 *
 * Este ficheiro define os seguintes parâmetros: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, e ABSPATH. Pode obter mais informação
 * visitando {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} no Codex. As definições de MySQL são-lhe fornecidas pelo seu serviço de alojamento.
 *
 * Este ficheiro contém as seguintes configurações:
 *
 * * Configurações de  MySQL
 * * Chaves secretas
 * * Prefixo das tabelas da base de dados
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Definições de MySQL - obtenha estes dados do seu serviço de alojamento** //
/** O nome da base de dados do WordPress */
define('DB_NAME', '-');

/** O nome do utilizador de MySQL */
define('DB_USER', '-');

/** A password do utilizador de MySQL  */
define('DB_PASSWORD', '-');

/** O nome do serviddor de  MySQL  */
define('DB_HOST', '-');

/** O "Database Charset" a usar na criação das tabelas. */
define('DB_CHARSET', 'utf8mb4');

/** O "Database Collate type". Se tem dúvidas não mude. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação.
 *
 * Mude para frases únicas e diferentes!
 * Pode gerar frases automáticamente em {@link https://api.wordpress.org/secret-key/1.1/salt/ Serviço de chaves secretas de WordPress.org}
 * Pode mudar estes valores em qualquer altura para invalidar todos os cookies existentes o que terá como resultado obrigar todos os utilizadores a voltarem a fazer login
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'FkX/%j- DVPNF4}?+n0Q?;B|PqYwnkLQ.Cg=k~^`r<m;&e[ %7T%_:Giy~wbnyl4');
define('SECURE_AUTH_KEY',  '&jh[soAEVNW]$g@@`6Tioho`%{aIs}C2<Ktb=j2)C.e8_Q*p>zKDe$:A Gu?+10@');
define('LOGGED_IN_KEY',    'Iz #A4&K(Q=x.w(~+q=lpXp8#FD1Cc|1m%U99y4z5YX|b==&AyC:3N<p ;YAr<EX');
define('NONCE_KEY',        '!-=k~=p(8YaU%Orve4vOcWp/K]oWa78RAui I]uR:Y<I{;bMrg2le$G@[V:8oL/3');
define('AUTH_SALT',        '0c*}DbRR`dvV<Eu3*1uTVCWV5NpGrhH4`ew|m7@[DEN<;K!=)w^n+M-3fmJ~`{?r');
define('SECURE_AUTH_SALT', '(/]:-/Gh?wa35y5I{>g|-#1I.sY)nvNl$^%)g7!y% .ES~I<[L$%AWgeO9gR1w4]');
define('LOGGED_IN_SALT',   'S-DB}pl3I=`Wo<RvRRK`e &APH0c3~Y#GbcPKD-Y5;+/ U#)/Eb}~bPq&]VDV;[]');
define('NONCE_SALT',       'O?sN^oVP6D_9E~U]+DMl|$T1.+aD2zq}C_DGkfI,i+T~ .-}.*3x}y#_/@x^lFw`');
define( 'JETPACK_DEV_DEBUG', true );

/**#@-*/

/**
 * Prefixo das tabelas de WordPress.
 *
 * Pode suportar múltiplas instalações numa só base de dados, ao dar a cada
 * instalação um prefixo único. Só algarismos, letras e underscores, por favor!
 */
$table_prefix  = 'wp_';

/**
 * Para developers: WordPress em modo debugging.
 *
 * Mude isto para true para mostrar avisos enquanto estiver a testar.
 * É vivamente recomendado aos autores de temas e plugins usarem WP_DEBUG
 * no seu ambiente de desenvolvimento.
 *
 * Para mais informações sobre outras constantes que pode usar para debugging,
 * visite o Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* E é tudo. Pare de editar! */

/** Caminho absoluto para a pasta do WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Define as variáveis do WordPress e ficheiros a incluir. */
require_once(ABSPATH . 'wp-settings.php');
