<?php

require_once 'common.php';

use Blackprism\Serializer\Configuration;
use Blackprism\Serializer\Value\ClassName;
use Blackprism\Serializer\Json;

$configuration = new Configuration();

$configurationObject = new Configuration\Object(new ClassName(City::class));
$configurationObject
    ->attributeUseMethod('name', 'setName', 'getName')
    ->attributeUseObject('country', new ClassName(Country::class), 'countryIs', 'getCountry')
    ->registerToConfiguration($configuration);

$configurationObject = new Configuration\Object(new ClassName(Country::class));
$configurationObject
    ->attributeUseMethod('name', 'setName', 'getName')
    ->registerToConfiguration($configuration);

$serializer = new Json\Deserialize($configuration);

$start = microtime(true);
for ($i = 0; $i < 100000; $i++) {
    $jsonContent = $serializer->deserialize($jsonToDeserialize, new ClassName(City::class));
}
$end = microtime(true);

var_dump($city);
echo "\n";
echo "Time\t" . round($end - $start, 3) . " sec\n";
echo "Memory\t" . round(memory_get_usage() / 1024) . " KB\n";
