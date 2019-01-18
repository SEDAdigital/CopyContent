<?php
/**
 * @var modX $modx
 */

$events = [];

$events['onDocFormRender'] = $modx
    ->newObject('modPluginEvent')
    ->fromArray([
        'event' => 'onDocFormRender',
    ], '', true, true)
;

return $events;
