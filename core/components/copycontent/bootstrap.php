<?php

declare(strict_types=1);
/**
 * @var array $namespace
 * @var \MODX\Revolution\modx $this
 * @var \MODX\Revolution\modx $modx
 *
 * @see \MODX\Revolution\modX::_initNamespaces
 */
try {
    \MODX\Revolution\modX::getLoader()->addPsr4('CopyContent', $namespace['path'] . 'src/');
}
catch (\Throwable $exception) {
    $modx->log(\xPDO\xPDO::LOG_LEVEL_ERROR, $exception->getMessage());
}
