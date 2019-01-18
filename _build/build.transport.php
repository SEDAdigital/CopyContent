<?php
/**
 * Build the transport package
 */
$tstart = microtime(true);
set_time_limit(0);

$root = dirname(__DIR__) . '/';

function getPHPContent(string $file) : string
{
    $o = file_get_contents($file);
    $o = str_replace(['<?php', '?>'], '', $o);
    $o = trim($o);

    return $o;
}

// Define package names
define('PKG_NAME', 'CopyContent');
define('PKG_NAME_LOWER', strtolower(PKG_NAME));
$version = explode('-', trim(file_get_contents($root . 'VERSION')));
define('PKG_VERSION', $version[0]);
define('PKG_RELEASE', $version[1]);

// Define build paths
$sources = [
    'root' => $root,
    'build' => $root . '_build/',
    'data' => $root . '_build/data/',

    'source_assets' => $root . 'assets/components/' . PKG_NAME_LOWER,
    'source_core' => $root . 'core/components/' . PKG_NAME_LOWER,

    'build_dir' => $root . '_build/_packages/'
];
unset($root);

require_once $sources['build'] . 'build.config.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';

// Instantiate modX
$modx = new modX();
$modx->initialize('mgr');
if (!XPDO_CLI_MODE) {
    echo '<pre>';
}
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget('ECHO');

$modx->loadClass('transport.modPackageBuilder', '', false, true);
$builder = new modPackageBuilder($modx);
if (isset($sources['build_dir']) && !empty($sources['build_dir'])) {
    $exists = true;
    if (!file_exists($sources['build_dir'])) {
        $exists = mkdir($sources['build_dir'], 0777, true);
    }
    if ($exists) {
        $builder->directory = $sources['build_dir'];
    }
}
$builder->createPackage(PKG_NAME_LOWER, PKG_VERSION, PKG_RELEASE);
$builder->registerNamespace(PKG_NAME_LOWER, false, true, '{core_path}components/' . PKG_NAME_LOWER . '/');

// Create category
/** @var $category modCategory */
$category = $modx->newObject('modCategory');
$category->set('id', 1);
$category->set('category', PKG_NAME);

// Add plugin
$modx->log(modX::LOG_LEVEL_INFO, 'Packaging in plugins...');
$plugins = include $sources['data'] . 'plugins.php';
if (empty($plugins)) {
    $modx->log(modX::LOG_LEVEL_ERROR, 'Could not package in plugins.');
}
$category->addMany($plugins);

// Create category vehicle
$attr = [
    xPDOTransport::UNIQUE_KEY => 'category',
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::RELATED_OBJECTS => true,
    xPDOTransport::RELATED_OBJECT_ATTRIBUTES => [
        'Plugins' => [
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'name',
            xPDOTransport::RELATED_OBJECTS => true,
            xPDOTransport::RELATED_OBJECT_ATTRIBUTES => [
                'PluginEvents' => [
                    xPDOTransport::PRESERVE_KEYS => true,
                    xPDOTransport::UPDATE_OBJECT => false,
                    xPDOTransport::UNIQUE_KEY => ['pluginid', 'event'],
                ],
            ],
        ],
    ],
];
$vehicle = $builder->createVehicle($category, $attr);

$modx->log(modX::LOG_LEVEL_INFO, 'Adding file resolvers to category...');
$vehicle->resolve('file', [
    'source' => $sources['source_assets'],
    'target' => "return MODX_ASSETS_PATH . 'components/';",
]);
$vehicle->resolve('file', [
    'source' => $sources['source_core'],
    'target' => "return MODX_CORE_PATH . 'components/';",
]);
$builder->putVehicle($vehicle);

// Now pack in the license file, readme and setup options
$modx->log(modX::LOG_LEVEL_INFO, 'Adding package attributes and setup options...');
$builder->setPackageAttributes([
    'license' => file_get_contents($sources['root'] . 'LICENSE'),
    'readme' => file_get_contents($sources['root'] . 'README.md'),
    'changelog' => file_get_contents($sources['root'] . 'CHANGELOG.md'),
    'requires' => [
        'php' => '=>7.0.0',
    ],
]);

// Zip up package
$modx->log(modX::LOG_LEVEL_INFO, 'Packing up transport package zip...');
$builder->pack();

$tend = microtime(true);
$totalTime = sprintf('%2.4f s', $tend - $tstart);
$modx->log(modX::LOG_LEVEL_INFO, "\n\nPackage Built. \nExecution time: {$totalTime}\n");
if (!XPDO_CLI_MODE) {
    echo '</pre>';
}
exit();
