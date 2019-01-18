<?php
/**
 * @var modX $modx
 * @var array $sources
 */

/** @var modPlugin[] $plugins */
$plugins = [];
$i = 0;

$plugins[$i] = $modx->newObject('modPlugin');
$plugins[$i]->fromArray([
    'name' => 'CopyContent',
    'description' => 'Copy your resource content to another resource.',
    'plugincode' => getPHPContent($sources['source_core'] . '/elements/plugins/copycontent.php'),
], '', true, true);


$events = $sources['data'] . 'events/copycontent.php';
if (file_exists($events)) {
    $vents = include $events;
    $modx->log(modX::LOG_LEVEL_INFO, 'Adding '. count($vents). ' system events to the plugin');
    $plugins[$i]->addMany($vents);
}

return $plugins;
