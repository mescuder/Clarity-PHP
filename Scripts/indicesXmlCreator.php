<?php

$tmpIndices = yaml_parse_file('/home/escudem/Nextera_XT_Indexes_v2.yml');
$indexNames = array();
$indexSeqs = array();
//var_dump($tmpIndices);
foreach ($tmpIndices as $name => $seq) {
    $newName = $name . ' (' . $seq . ')';
    $indexNames[] = $newName;
    $indexSeqs[] = $seq;
}
$groupName = 'Nextera XT Indexes v2';

$i = 0;
$configElement = simplexml_load_file(__DIR__ . '/../XmlTemplate/36_indices.xsd');

foreach ($configElement->ReagentTypes->xpath('//rtp:reagent-type') as $reagentElement) {
    $reagentElement->attributes()['name'] = $indexNames[$i];
    $reagentElement->{'special-type'}->attribute['value'] = $indexSeqs[$i];
    $reagentElement->{'reagent-category'} = $groupName;
    ++$i;
}

/*
$doc = new \DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->formatOutput = true;
$doc->loadXML($configElement->asXML());
echo $doc->saveXML();
 * 
 */

echo $configElement->asXML();
