<?php

require_once 'vendor/autoload.php';
require_once 'vendor/jms/serializer/src/JMS/Serializer/Annotation/Type.php';

use JMS\Serializer\Annotation\Type;

class City
{
    /**
     * @Type("string")
     */
    private $name = '';

    /**
     * @Type("Country")
     */
    private $country = null;

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function countryIs(Country $country)
    {
        $this->country = $country;
    }

    public function getCountry()
    {
        return $this->country;
    }
}

class Country
{
    /**
     * @Type("string")
     */
    private $name = '';

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}

$country = new Country();
$country->setName('France');

$city = new City();
$city->setName('Palaiseau');
$city->countryIs($country);

$jsonToDeserialize = '{"name":"Palaiseau","country":{"name":"France"}}';
