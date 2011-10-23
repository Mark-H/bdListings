<?php

$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,20);
$sort = $modx->getOption('sort',$scriptProperties,'name');
$dir = $modx->getOption('dir',$scriptProperties,'asc');

$search = $modx->getOption('query',$scriptProperties,'');

$c = $modx->newQuery('bdlTarget');

if (strlen($search) > 0) {
    $c->where(array(
                  'name:LIKE' => "%$search%",
              ));
}

$c->sortby($sort,$dir);

$total = $modx->getCount('bdlTarget',$c);

$c->limit($limit,$start);

$query = $modx->getCollection('bdlTarget',$c);
$results = array();

/* @var bdlCategory $r */
foreach ($query as $r) {
    $ta = $r->toArray();
    $results[] = array(
        'id' => $ta['id'],
        'name' => $ta['name'],
    );
}

$returnArray = array(
    'success' => true,
    'total' => $total,
    'results' => $results
);
return $modx->toJSON($returnArray);