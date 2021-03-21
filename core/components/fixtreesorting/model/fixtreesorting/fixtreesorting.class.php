<?php

class FixTreeSorting {
	public $modx;
	public $config = array();
	public function __construct(modX &$modx,array $config = array()) {
		$this->modx =& $modx;
		$basePath = $this->modx->getOption('fixtreesorting.core_path',$config,$this->modx->getOption('core_path').'components/fixtreesorting/');
		$assetsUrl = $this->modx->getOption('fixtreesorting.assets_url',$config,$this->modx->getOption('assets_url').'components/fixtreesorting/');
		$this->config = array_merge(array(
			'basePath' => $basePath,
			'corePath' => $basePath,
			'modelPath' => $basePath.'model/',
			'processorsPath' => $basePath.'processors/',
			'templatesPath' => $basePath.'templates/',
			'chunksPath' => $basePath.'elements/chunks/',
			'jsUrl' => $assetsUrl.'js/',
			'cssUrl' => $assetsUrl.'css/',
			'assetsUrl' => $assetsUrl,
			'connectorUrl' => $assetsUrl.'connector.php',
		),$config);
	}
}
