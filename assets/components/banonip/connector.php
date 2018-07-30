<?php
if (file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php')) {
    /** @noinspection PhpIncludeInspection */
    require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
} else {
    require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/config.core.php';
}
/** @noinspection PhpIncludeInspection */
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CONNECTORS_PATH . 'index.php';
/** @var BanOnIP $BanOnIP */
$BanOnIP = $modx->getService('BanOnIP', 'BanOnIP', MODX_CORE_PATH . 'components/banonip/model/');
$modx->lexicon->load('banonip:default');

// handle request
$corePath = $modx->getOption('banonip_core_path', null, $modx->getOption('core_path') . 'components/banonip/');
$path = $modx->getOption('processorsPath', $BanOnIP->config, $corePath . 'processors/');
$modx->getRequest();

/** @var modConnectorRequest $request */
$request = $modx->request;
$request->handleRequest([
    'processors_path' => $path,
    'location' => '',
]);