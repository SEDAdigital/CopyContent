<?php

require_once __DIR__ . '/../../../config.core.php';
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';
/**
 * @var modX $modx
 */
$corePath = $modx->getOption(
    'copycontent.core_path',
    null,
    $modx->getOption('core_path') . 'components/copycontent/'
);
$modx->lexicon->load('copycontent:default');
$modx->request->handleRequest([
    'processors_path' => "{$corePath}processors/",
    'location' => '',
]);
