<?php

$corePath = $modx->getOption('bdlistings.core_path',null,$modx->getOption('core_path').'components/bdlistings/');
$modx->getService('bdlistings','bdListings',$corePath.'model/');

$listing = $modx->newObject('bdlListing');
$listing->set('createdon',date('Y-m-d H:i:s',time()));

$d = $hook->getValues();
$d['publisheduntil'] = date('Y-m-d H:i:s',strtotime($d['publisheduntil']));
$d['active'] = false;
$d['featured'] = false;

$listing->fromArray($d);

if (!$listing->get('latitude') && !$listing->get('longitude')) {
    $listing->getLatLong();
}

$result = $listing->save();
return $result;

?>
