<?php

$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,20);
$sort = $modx->getOption('sort',$scriptProperties,'display');
$dir = $modx->getOption('dir',$scriptProperties,'asc');

$search = $modx->getOption('query',$scriptProperties,'');

$c = $modx->newQuery('bdlPriceGroup');

if (strlen($search) > 0) {
    $c->where(array(
                  'display:LIKE' => "%$search%",
              ));
}

$c->sortby($sort,$dir);

$total = $modx->getCount('bdlPriceGroup',$c);

$c->limit($limit,$start);

$query = $modx->getCollection('bdlPriceGroup',$c);
$results = array();

/* @var bdlCategory $r */
foreach ($query as $r) {
    $ta = $r->toArray();
    $results[] = array(
        'id' => $ta['id'],
        'display' => $ta['display'],
    );
}

$returnArray = array(
    'success' => true,
    'total' => $total,
    'results' => $results
);
return $modx->toJSON($returnArray);