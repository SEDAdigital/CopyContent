<?php
/**
 * @var modX $modx
 */

$events = [];

$events['onDocFormRender'] = $modx->newObject('modPluginEvent');
$events['onDocFormRender']->fromArray([
    'event' => 'onDocFormRender',
], '', true, true);

return $events;
