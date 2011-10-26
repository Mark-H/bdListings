<?php

$node = $modx->getOption('node',$scriptProperties,'root');

$return = array();
/* Looking for the top level, or in other words: categories. */
if ($node == 'root') {
    $c = $modx->newQuery('bdlCategory');
    $c->where(array('parent' => 0));
    $results = $modx->getCollection('bdlCategory',$c);
    foreach ($results as $category) {
        /* @var bdlCategory $category */
        if ($category instanceof bdlCategory) {
            $tr = $category->toArray();
            $return[] = array (
                'text' => $tr['name'] . ' (' . $tr['id'] . ')',
                'id' => $tr['id'],
                'leaf' => ($modx->getCount('bdlCategory',array('parent' => $tr['id'])) > 0) ? false : true,
                'type' => 'category',
                'qtip' => $tr['description'],
            );
        }
    }
}
else {
    if (is_numeric($node)) {
        $node = (int)$node;
        $c = $modx->newQuery('bdlCategory');
        $c->where(array('parent' => $node));
        $results = $modx->getCollection('bdlCategory',$c);
        foreach ($results as $category) {
            /* @var bdlCategory $category */
            if ($category instanceof bdlCategory) {
                $tr = $category->toArray();
                $return[] = array (
                    'text' => $tr['name'] . ' (' . $tr['id'] . ')',
                    'id' => $tr['id'],
                    'leaf' => ($modx->getCount('bdlCategory',array('parent' => $tr['id'])) > 0) ? false : true,
                    'type' => 'subcategory',
                    'qtip' => $tr['description'],
                );
            }
        }
    }
}

return $modx->toJSON($return);

?>