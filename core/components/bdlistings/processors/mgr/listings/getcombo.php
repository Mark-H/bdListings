<?php

$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,20);
$sort = $modx->getOption('sort',$scriptProperties,'title');
$dir = $modx->getOption('dir',$scriptProperties,'asc');

$search = $modx->getOption('query',$scriptProperties,'');

$c = $modx->newQuery('bdlListing');

if (strlen($search) > 0) {
    $c->where(array(
                  'title:LIKE' => "%$search%",
                  'OR:description:LIKE' => "%$search%",
              ));
}

$c->sortby($sort,$dir);

$total = $modx->getCount('bdlListing',$c);

$c->limit($limit,$start);

$query = $modx->getCollection('bdlListing',$c);
$results = array();

/* @var bdlCategory $r */
foreach ($query as $r) {
    $ta = $r->toArray();
    $results[] = array(
        'id' => $ta['id'],
        'title' => $ta['title'],
    );
}

$returnArray = array(
    'success' => true,
    'total' => $total,
    'results' => $results
);
return $modx->toJSON($returnArray);