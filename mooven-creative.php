<?php
/*
* plugin Name: Mooven Creative
* Description: Plugin de desenvolvimento Mooven Creative
* Version: 1.0
* Author: Mooven Creative
*
*/

use Source\Classes\Mooven_Product_Meta_Box;
use Source\Classes\Mooven_Receiver_Meta_Box;
use Source\Classes\Mooven_Split;
use Source\Classes\Mooven_Subscription;

if (!defined('ABSPATH')) {
    exit;
}

define('MOOVEN_PLUGIN_FILE', untrailingslashit(__FILE__));
define('MOOVEN_PLUGIN_PATH', untrailingslashit(plugin_dir_path(__FILE__)));
define('MOOVEN_PLUGIN_URL', untrailingslashit(plugin_dir_url(__FILE__)));

/**
 * Autoload
 */
require_once(plugin_dir_path(MOOVEN_PLUGIN_FILE) . '/vendor/autoload.php');

/**
 * Carregar Classes que montam o painel
 */
require_once(plugin_dir_path(MOOVEN_PLUGIN_FILE) . '/source/classes/Mooven_Sections.php');
require_once(plugin_dir_path(MOOVEN_PLUGIN_FILE) . '/source/classes/Mooven_Fields.php');
require_once(plugin_dir_path(MOOVEN_PLUGIN_FILE) . '/source/classes/Mooven_Dashboard.php');

//Carregando Funções
require_once(plugin_dir_path(MOOVEN_PLUGIN_FILE) . '/includes/mooven-functions.php');

//Carregnado Shortcodes
require_once(plugin_dir_path(MOOVEN_PLUGIN_FILE) . '/includes/mooven-shortcodes.php');

//Carregando Scripts
require_once(plugin_dir_path(MOOVEN_PLUGIN_FILE) . '/includes/mooven-scripts.php');

//Carregando CPTS
require_once(plugin_dir_path(MOOVEN_PLUGIN_FILE) . '/includes/mooven-cpts.php');

//Carregando Templates
require_once(plugin_dir_path(MOOVEN_PLUGIN_FILE) . '/includes/mooven-templates.php');

/**
 * Campos personalizados
 */
new Mooven_Receiver_Meta_Box;
new Mooven_Product_Meta_Box;


/**
 * Montando Dashboard
 */
Mooven_Dashboard::getInstance();
Mooven_Sections::getInstance();
Mooven_Fields::getInstance();


/**
 * Módulo - Assinatura e scripts
 */
$Subscription = new Mooven_Subscription;

add_action('wp_enqueue_scripts', array($Subscription, 'subscriber_scripts'), 100);
add_action('wp_ajax_nopriv_pagarme_subscriber',  array($Subscription, 'pagarme_subscriber'));
add_action('wp_ajax_pagarme_subscriber',  array($Subscription, 'pagarme_subscriber'));

/**
 * Módulo - Split de pagamento
 */
 $Split = new Mooven_Split;

add_filter('wc_pagarme_transaction_data', array($Split, 'pagarme_split'), 10, 2);
