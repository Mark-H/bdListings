<?php
/* @var modX $modx
 * @var array $scriptProperties
 */

$corePath = $modx->getOption('bdlistings.core_path',null,$modx->getOption('core_path').'components/bdlistings/');
$modx->getService('bdlistings','bdListings',$corePath.'model/');

$defaults = include $corePath.'elements/snippets/bdCategories.properties.php';

$p = array_merge($defaults,$scriptProperties);

$c = $modx->newQuery('bdlCategory');

if ($p['parent'] > 0) {
    $c->where(array('parent' => $p['parent']));
} else {
    $c->where(array('parent' => 0));
}

$c->limit($p['limit'],$p['start']);
$c->sortby($p['sortby'],$p['sortdir']);

$results = array();
$collection = $modx->getCollection('bdlCategory',$c);
/* @var bdlCategory $category
 * @var bdlCategory $sub
 **/
foreach ($collection as $category) {
    $ta = $category->toArray();
    if ($p['includeSub']) {
        $subs = $category->getMany('SubCategories');
        $subResults = array();
        foreach ($subs as $sub) {
            $sub = $sub->toArray();
            $subResults[] = $modx->bdlistings->getChunk($p['tplSub'],$sub);
        }
        if (!empty($subResults)) {
            $subResults = implode($p['subSeparator'],$subResults);
            $ta['subcategories'] = $modx->bdlistings->getChunk($p['tplInner'],array('subcategories' => $subResults));
        } else {
            $ta['subcategories'] = '';
        }
    } else {
        $ta['subcategories'] = '';
    }
    $results[] = $modx->bdlistings->getChunk($p['tplCategory'],$ta);
}

$results = implode($p['categorySeparator'],$results);
$results = $modx->bdlistings->getChunk($p['tplOuter'],array('categories' => $results));

return $results;