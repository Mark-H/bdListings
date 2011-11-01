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

$object->fromArray($d);
if ($d['image']['name']) {
    /* New file upload */
    $uploadPath = $modx->getOption('bdlistings.uploadpath');
    if (empty($uploadPath)) $uploadPath = $modx->getOption('bdlistings.assets_path',null,$modx->getOption('assets_path')).'uploads/';

    $modx->getService('fileHandler','modFileHandler');

    $uploadDirObj = $modx->fileHandler->make($uploadPath);
    if (!$uploadDirObj->isWritable()) {
        return $modx->error->failure('Main upload dir '.$uploadPath.' is not writable.');
    }

    /* Object Directory */
    $objectDirPath = $uploadDirObj->getPath().$d['listing'];
    $objectDirObj = $modx->fileHandler->make($objectDirPath,array(),'modDirectory');
    if (!$objectDirObj->exists()) {
        if ($objectDirObj->create() !== true)
            return $modx->error->failure('Error creating object directory.');
    }
    if (!$objectDirObj->isWritable()) {
        return $modx->error->failure('Object Directory is not writable.');
    }

    $rand = rand(0,99999);
    $fileDir = $objectDirObj->getPath().'/'.$rand.'-'.$d['image']['name'];
    $fileUrl = $d['listing'].'/'.$rand.'-'.$d['image']['name'];

    if (move_uploaded_file($d['image']['tmp_name'],$fileDir)) {
        $object->set('image',$fileUrl);
    } else {
        $modx->log(MODX_LOG_LEVEL_ERROR,'Error uploading file '.$d['image']['tmp_name'].' to '.$fileDir);
        return $modx->error->failure('Error uploading file.');
    }
}

$result = $object->save();

if (!$result) {
    return $modx->error->failure($modx->lexicon('bdlistings.error.save'));
}

return $modx->error->success();

?>