<?php

require_once 'common.php';

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class CityDenormalizer extends SerializerAwareNormalizer implements DenormalizerInterface
{
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        $city = new City();
        $city->setName($data['name']);
        $city->countryIs($this->serializer->denormalize($data['country'], 'Country', 'json'), $format, $context);

        return $city;
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === 'City';
    }
}

class CountryDenormalizer extends SerializerAwareNormalizer implements DenormalizerInterface
{
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        $country = new Country();
        $country->setName($data['name']);

        return $country;
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === 'Country';
    }
}

$encoders = array(new JsonEncoder());

$normalizers = array(new CityDenormalizer(), new CountryDenormalizer());

$serializer = new Serializer($normalizers, $encoders);

$start = microtime(true);
for ($i = 0; $i < 100000; $i++) {
    $city = $serializer->deserialize($jsonToDeserialize, City::class, 'json');
}
$end = microtime(true);

var_dump($city);
echo "\n";
echo "Time\t" . round($end - $start, 3) . " sec\n";
echo "Memory\t" . round(memory_get_usage() / 1024) . " KB\n";
