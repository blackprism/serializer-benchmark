<?php

require_once 'common.php';

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CityNormalizer extends SerializerAwareNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        return [
            'name' => $object->getName(),
            'country' => $this->serializer->normalize($object->getCountry(), $format, $context)
        ];
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof City;
    }
}

class CountryNormalizer extends SerializerAwareNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        return [
            'name' => $object->getName()
        ];
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Country;
    }
}


$encoders = array(new JsonEncoder());
$normalizers = array(new CityNormalizer(), new CountryNormalizer());

$serializer = new Serializer($normalizers, $encoders);

$start = microtime(true);
for ($i = 0; $i < 100000; $i++) {
    $jsonContent = $serializer->serialize($city, 'json');
}
$end = microtime(true);

echo $jsonContent;
echo "\n";
echo "Time\t" . round($end - $start, 3) . " sec\n";
echo "Memory\t" . round(memory_get_usage() / 1024) . " KB\n";
