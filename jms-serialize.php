<?php

require_once 'common.php';

$serializer = JMS\Serializer\SerializerBuilder::create()
    ->build();

$start = microtime(true);
for ($i = 0; $i < 100000; $i++) {
    $jsonContent = $serializer->serialize($city, 'json');
}
$end = microtime(true);

echo $jsonContent;
echo "\n";
echo "Time\t" . round($end - $start, 3) . " sec\n";
echo "Memory\t" . round(memory_get_usage() / 1024) . " KB\n";
