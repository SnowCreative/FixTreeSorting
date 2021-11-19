<?php

// fix sorting of resources with same parent to keep menuindexes in
// numerical order without gaps
// fires on OnDocFormSave, OnDocFormDelete, and OnResourceSort


if($modx->event->name == 'OnResourceSort') {
	// if sorted by drag and drop, we just need to find out what parent to use,
	// so get the id of the first modified node
  $resource = $modx->getObject('modDocument',$modifiedNodes[0]->id);
}

$thisparentid = $resource->get('parent');
$thiscontext = $resource->get('context_key');
if(is_numeric($thisparentid) && !empty($thiscontext)) {
  $c = $modx->newQuery('modResource');
  $c->select(array('id','menuindex'));
	// include context in the search so that if this manager is multi-context
	// and the parent is 0, only the resources in this context will get sorted
  $c->where(array('parent'=>$thisparentid,'deleted'=>'0','context_key'=>$thiscontext));
  $c->sortby('menuindex','ASC');
  $docs = $modx->getCollection('modResource',$c);
	$newindex = 0;
	if(!empty($docs)){
		foreach ($docs as $doc) {
		  $thisdoc = $modx->getObject('modResource',array('id'=>$doc->id));
			$thisdoc->set('menuindex',$newindex);
			$thisdoc->save();
			$newindex++;
		}
	}
}
