<?php
/* @var modX $modx
 * @var array $scriptProperties
 * @var bdlListing $listing
 */

$id = (int)$modx->getOption('id',$scriptProperties,null);

if ($id > 0) {
    $listing = $modx->getObject('bdlListing',$id);
    if (!($listing instanceof bdlListing))
        return $modx->error->failure($modx->lexicon('bdlistings.error.object_nf'));
} else {
    $listing = $modx->newObject('bdlListing');
    $listing->set('createdon',date('Y-m-d H:i:s',time()));
}

$d = $scriptProperties;
$d['publisheduntil'] = date('Y-m-d H:i:s',strtotime($d['publisheduntil']));
$d['active'] = ($d['active'] == 'on') ? true : false;
$d['featured'] = ($d['featured'] == 'on') ? true : false;
$d['extended'] = ($d['extended'] == 'on') ? true : false;

$listing->fromArray($d);

if ($d['calclatlong'] == 'on') {
    $listing->getLatLong();
}

$result = $listing->save();

if (!$result) {
    return $modx->error->failure($modx->lexicon('bdlistings.error.save'));
}

return $modx->error->success();

?>
