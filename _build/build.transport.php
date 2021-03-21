<?php
$tstart = explode(' ', microtime());
$tstart = $tstart[1] + $tstart[0];
set_time_limit(0);

/* define package names */
define('PKG_NAME','FixTreeSorting');
define('PKG_NAME_LOWER',strtolower(PKG_NAME));
define('PKG_VERSION','1.0');
define('PKG_RELEASE','pl');

$root = dirname(dirname(__FILE__)).'/';
$sources= array (
	'root' => $root,
	'build' => $root .'_build/',
	'resolvers' => $root . '_build/resolvers/',
	'data' => $root . '_build/data/',
	'elements' => $root.'core/components/'.PKG_NAME_LOWER.'/elements/',
	'source_core' => $root.'core/components/fixtreesorting',
	'docs' => $root.'core/components/fixtreesorting/docs/',
);
unset($root);

/* override with your own defines here (see build.config.sample.php) */
require_once $sources['build'] . 'build.config.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';

$modx= new modX();
$modx->initialize('mgr');
echo ''; /* used for nice formatting of log messages */
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget('ECHO');

$modx->loadClass('transport.modPackageBuilder','',false, true);
$builder = new modPackageBuilder($modx);
$builder->createPackage(PKG_NAME_LOWER,PKG_VERSION,PKG_RELEASE);
$builder->registerNamespace(PKG_NAME_LOWER,false,true,'{core_path}components/'.PKG_NAME_LOWER.'/');

$category= $modx->newObject('modCategory');
$category->set('id',1);
$category->set('category',PKG_NAME);

/* create category vehicle */
$attr = array(
	xPDOTransport::UNIQUE_KEY => 'category',
	xPDOTransport::PRESERVE_KEYS => false,
	xPDOTransport::UPDATE_OBJECT => true,
	xPDOTransport::RELATED_OBJECTS => true,
	xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
		'Snippets' => array(
			xPDOTransport::PRESERVE_KEYS => false,
			xPDOTransport::UPDATE_OBJECT => true,
			xPDOTransport::UNIQUE_KEY => 'name',
		),
	),
);
$vehicle = $builder->createVehicle($category,$attr);
$builder->putVehicle($vehicle);






$modx->log(modX::LOG_LEVEL_INFO,'Adding file resolvers to category...');
$vehicle->resolve('file',array(
	'source' => $sources['source_assets'],
	'target' => "return MODX_ASSETS_PATH . 'components/';",
));
$vehicle->resolve('file',array(
	'source' => $sources['source_core'],
	'target' => "return MODX_CORE_PATH . 'components/';",
));


$modx->log(modX::LOG_LEVEL_INFO,'Adding package attributes and setup options...');
$builder->setPackageAttributes(array(
	'license' => file_get_contents($sources['docs'] . 'license.txt'),
	'readme' => file_get_contents($sources['docs'] . 'readme.txt'),
	'changelog' => file_get_contents($sources['docs'] . 'changelog.txt'),
	'setup-options' => array(
		'source' => $sources['build'].'setup.options.php',
	),
));

/* zip up package */
$modx->log(modX::LOG_LEVEL_INFO,'Packing up transport package zip...');
$builder->pack();

$tend= explode(" ", microtime());
$tend= $tend[1] + $tend[0];
$totalTime= sprintf("%2.4f s",($tend - $tstart));
$modx->log(modX::LOG_LEVEL_INFO,"\n<br />Package Built.<br />\nExecution time: {$totalTime}\n");


session_write_close();
exit ();
