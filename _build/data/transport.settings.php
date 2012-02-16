<?php
$s = array(
    'categoryresource' => 0,
    'showExtendedCheckbox' => true,
);

$settings = array();

foreach ($s as $key => $value) {
    if (is_string($value) || is_int($value)) { $type = 'textfield'; }
    elseif (is_bool($value)) { $type = 'combo-boolean'; }
    else { $type = 'textfield'; }

    $settings['bdlistings.'.$key] = $modx->newObject('modSystemSetting');
    $settings['bdlistings.'.$key]->set('key', 'bdlistings.'.$key);
    $settings['bdlistings.'.$key]->fromArray(array(
        'value' => $value,
        'xtype' => $type,
        'namespace' => 'bdlistings',
        'area' => 'Default'
    ));
}

return $settings;


