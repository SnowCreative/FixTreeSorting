<?php

$events = array();

$events['OnDocFormSave']= $modx->newObject('modPluginEvent');
$events['OnDocFormSave']->fromArray(array(
    'event' => 'OnDocFormSave',
    'priority' => 0,
    'propertyset' => 0,
),'',true,true);

$events['OnDocFormDelete']= $modx->newObject('modPluginEvent');
$events['OnDocFormDelete']->fromArray(array(
    'event' => 'OnDocFormDelete',
    'priority' => 0,
    'propertyset' => 0,
),'',true,true);

$events['OnResourceSort']= $modx->newObject('modPluginEvent');
$events['OnResourceSort']->fromArray(array(
    'event' => 'OnResourceSort',
    'priority' => 0,
    'propertyset' => 0,
),'',true,true);

return $events;
