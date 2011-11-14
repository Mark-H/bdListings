<?php
$plugins = array();

/* create the plugin object */
$plugins[0] = $modx->newObject('modPlugin');
$plugins[0]->set('id',1);
$plugins[0]->set('name','bdlFriendlyCategoryURLs');
$plugins[0]->set('description','Acts on OnPageNotFound and if it matches the right URL it will sendForward to the category resource.');
$plugins[0]->set('plugincode', getSnippetContent($sources['plugins'] . 'bdFriendlyCategories.plugin.php'));
$plugins[0]->set('category', 0);

$events = array();

$events['OnPageNotFound']= $modx->newObject('modPluginEvent');
$events['OnPageNotFound']->fromArray(array(
    'event' => 'OnPageNotFound',
    'priority' => 0,
    'propertyset' => 0,
),'',true,true);

if (is_array($events) && !empty($events)) {
    $plugins[0]->addMany($events);
    $modx->log(xPDO::LOG_LEVEL_INFO,'Packaged in '.count($events).' Plugin Events for bdlFriendlyCategoryURLs.'); flush();
} else {
    $modx->log(xPDO::LOG_LEVEL_ERROR,'Could not find plugin events for bdlFriendlyCategoryURLs!');
}
unset($events);

return $plugins;

?>