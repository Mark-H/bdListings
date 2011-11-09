<?php
/* @var modX $modx
 * @var array $scriptProperties
 * @var bdlImage $object
 */

$id = (int)$modx->getOption('id',$scriptProperties,null);

if ($id > 0) {
    $object = $modx->getObject('bdlImage',$id);
    if (!($object instanceof bdlImage))
        return $modx->error->failure($modx->lexicon('bdlistings.error.object_nf'));
} else {
    $object = $modx->newObject('bdlImage');
}

$d = $scriptProperties;
$d['primary'] = ($d['primary'] == 'on') ? true : false;

if (!empty($d['image']['name'])) {
    $response = $object->handleUpload($d['image'],$d['listing']);
    if (is_string($response)) $object->set('image',$response);
    else return $modx->error->failure($response['error']);
}
unset ($d['image']);

$object->fromArray($d);

$result = $object->save();

if (!$result) {
    return $modx->error->failure($modx->lexicon('bdlistings.error.save'));
}

return $modx->error->success();

?>