<?php
$snips = array(
    'bdCategories' => 'Generates list of categories and optionally sub-categories.',
    'bdListings' => 'Used for creating an overview of listings.',
    'bdPriceGroups' => 'Lists price groups as defined in the component.',
    'bdTargets' => 'Lists target groups as defined in the component.',
    'bdHookNewListing' => 'Hook to create an inactive listing. Use in conjunction with a validate property, and email hook to send notifications.',
    'bdRedirect' => 'Takes care of Redirecting the user to the listing URL, as well as registering a click.',
);

$snippets = array();
$idx = 0;

foreach ($snips as $sn => $sdesc) {
    $idx++;
    $snippets[$idx] = $modx->newObject('modSnippet');
    $snippets[$idx]->fromArray(array(
       'id' => $idx,
       'name' => $sn,
       'description' => $sdesc . ' (Part of bdListings)',
       'snippet' => getSnippetContent($sources['snippets'].$sn.'.snippet.php')
    ));

    $snippetProperties = array();
    $props = include $sources['snippets'].$sn.'.properties.php';
    foreach ($props as $key => $value) {
        if (is_string($value) || is_int($value)) { $type = 'textfield'; }
        elseif (is_bool($value)) { $type = 'combo-boolean'; }
        else { $type = 'textfield'; }
        $snippetProperties[] = array(
            'name' => $key,
            'desc' => 'bdlistings.prop_desc.'.$key,
            'type' => $type,
            'options' => '',
            'value' => ($value != null) ? $value : '',
            'lexicon' => 'bdlistings:properties'
        );
    }

    if (count($snippetProperties) > 0)
        $snippets[$idx]->setProperties($snippetProperties);
}

return $snippets;

?>
