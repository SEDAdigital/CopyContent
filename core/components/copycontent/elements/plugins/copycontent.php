<?php
/**
 * CopyContent
 * A plugin to load "copy content" assets
 *
 * @var modX $modx
 * @var array $scriptProperties
 *
 * @var modPlugin $this
 *
 * @see modPlugin::process()
 *
 * @event onDocFormRender
 *
 * @version   1.0.0
 * @copyright 2019 SEDA.digital GmbH & Co. KG
 */

if ($modx->getOption('mode', $scriptProperties) === modSystemEvent::MODE_NEW) {
    // We don't want the widget when creating new resources
    return;
}
$modx->controller->addLexiconTopic('copycontent:default');
// Let's load the required JS file
$assets = $modx->getOption(
    'copycontent.assets_url',
    null,
    $modx->getOption('assets_url') . 'components/copycontent/'
);

$modx->controller->addHtml(<<<HTML
<script>
Ext.ns('CopyContent');
CopyContent.config = {
    connector: '{$assets}connector.php'
}
</script>
HTML
);
$modx->controller->addJavascript("{$assets}/js/copycontent.js");

return;
