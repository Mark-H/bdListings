<?php
/* @var modX $modx
 * @var fiHook $hook
 * @var bdlListing $listing
 **/
$corePath = $modx->getOption('bdlistings.core_path',null,$modx->getOption('core_path').'components/bdlistings/');
$modx->getService('bdlistings','bdListings',$corePath.'model/');

$listing = $modx->newObject('bdlListing');
$listing->set('createdon',date('Y-m-d H:i:s',time()));

$d = $hook->getValues();
if ((int)$d['duration'] > 0) {
    $duration = (int)$d['duration'];
    $expires = time() + $duration;
    if ($expires > time()) $d['publisheduntil'] = $expires;
}
if (is_numeric($d['publisheduntil']))
    $d['publisheduntil'] = date('Y-m-d H:i:s',$d['publisheduntil']);
else if (!empty($d['publisheduntil']))
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
