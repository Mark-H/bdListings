<?php

$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,20);
$sort = $modx->getOption('sort',$scriptProperties,'name');
$dir = $modx->getOption('dir',$scriptProperties,'asc');

$search = $modx->getOption('query',$scriptProperties,'');
$parent = $modx->getOption('parent',$scriptProperties,'');

$c = $modx->newQuery('bdlCategory');

if (strlen($search) > 0) {
    $c->where(array(
                  'name:LIKE' => "%$search%",
                  'OR:description:LIKE' => "%$search%",
              ));
}

if (is_numeric($parent)) $c->where(array('parent' => (int)$parent,));
else $c->where(array('parent' => 0,));

$c->sortby($sort,$dir);

$total = $modx->getCount('bdlCategory',$c);

$c->limit($limit,$start);

$query = $modx->getCollection('bdlCategory',$c);
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