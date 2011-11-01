<?php

$data = $modx->getOption('data',$scriptProperties,'{}');

$data = $modx->fromJSON($data);
if (!is_array($data)) {
    return $modx->error->failure($modx->lexicon('bdlistings.error.invalid'));
}
$errors = array();
$sortRoot = 1;
foreach ($data as $idRoot => $rootLevel) {
    $catRoot = $modx->getObject('bdlCategory',(int)$idRoot);
    $catRoot->set('sortorder',$sortRoot);
    $catRoot->set('parent',0);
    $catRoot->save();
    $sortSub = 1;
    foreach ($rootLevel['children'] as $idChild => $childLevel) {
        $catSub = $modx->getObject('bdlCategory',(int)$idChild);
        $catSub->set('sortorder',$sortSub);
        $catSub->set('parent',$idRoot);
        $catSub->save();
        $sortSub++;

        if (!empty($childLevel['children'])) {
            foreach ($childLevel['children'] as $idChildChild => $childChildLevel)
                $errors[] = $modx->lexicon('bdlistings.error.toodeep',array('id' => $idChildChild));
        }
    }
    $sortRoot++;
}

if (count($errors) > 0) {
    $e = implode(", \n",$errors);
    return $modx->error->failure($modx->lexicon('bdlistings.error.sortinvalid',array('errors' => $e)));
}

return $modx->error->success();
