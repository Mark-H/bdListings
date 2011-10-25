<?php
/* @var modX $modx
 * @var array $scriptProperties
 */

$corePath = $modx->getOption('bdlistings.core_path',null,$modx->getOption('core_path').'components/bdlistings/');
$modx->getService('bdlistings','bdListings',$corePath.'model/');

$defaults = include $corePath.'elements/snippets/bdPriceGroups.properties.php';

$p = array_merge($defaults,$scriptProperties);

$c = $modx->newQuery('bdlPriceGroup');
$c->limit($p['limit'],$p['start']);
$c->sortby($p['sortby'],$p['sortdir']);

$results = array();
$collection = $modx->getCollection('bdlPriceGroup',$c);
/* @var bdlPriceGroup $target
 **/
foreach ($collection as $target) {
    $ta = $target->toArray();
    $results[] = $modx->bdlistings->getChunk($p['tplRow'],$ta);
}

$results = implode($p['rowSeparator'],$results);
$results = $modx->bdlistings->getChunk($p['tplOuter'],array('wrapper' => $results));

return $results;