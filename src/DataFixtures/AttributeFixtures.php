<?php

namespace App\DataFixtures;

use App\Entity\Attribute;
use App\Entity\Product;
use App\Entity\ProductBrand;
use App\Entity\ProductImage;
use Bezhanov\Faker\Provider\Device;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AttributeFixtures extends Fixture
{


    public function getAttributesArray(): array
    {
        $faker = Factory::create();

        return [
            "Système d'exploitation" => function () use ($faker) {
                return $faker->randomElement(['iOS', 'Android']);
            },
            "Version OS" => function () use ($faker) {
                return $faker->numerify('##.##');
            },
            "Processeur" => function () use ($faker) {
                return $faker->word . ' ' . $faker->numerify('###');
            },
            "Nombre de cœurs" => function () use ($faker) {
                return $faker->randomElement([4, 6, 8]);
            },
            "Fréquence du processeur" => function () use ($faker) {
                return $faker->randomFloat(2, 1.0, 3.5) . ' GHz';
            },
            "Mémoire RAM" => function () use ($faker) {
                return $faker->randomElement([4, 6, 8, 12, 16]) . ' GB';
            },
            "Capacité de stockage interne" => function () use ($faker) {
                return $faker->randomElement([64, 128, 256, 512]) . ' GB';
            },
            "Extension de stockage" => function () use ($faker) {
                return $faker->randomElement(['Non', 'Oui, jusqu\'à 1TB']);
            },
            "Taille de l'écran" => function () use ($faker) {
                return $faker->randomFloat(1, 5.0, 7.0) . ' pouces';
            },
            "Résolution de l'écran" => function () use ($faker) {
                return $faker->randomElement(['1080x2400', '1440x3200', '1284x2778']);
            },
            "Technologie de l'écran" => function () use ($faker) {
                return $faker->randomElement(['LCD', 'OLED', 'AMOLED']);
            },
            "Caméra principale" => function () use ($faker) {
                return $faker->randomElement(['12 MP', '48 MP', '64 MP', '108 MP']);
            },
            "Résolution caméra principale" => function () use ($faker) {
                return $faker->randomElement(['4K', '1080p', '720p']);
            },
            "Caméra secondaire" => function () use ($faker) {
                return $faker->randomElement(['8 MP', '16 MP', '32 MP']);
            },
            "Résolution caméra secondaire" => function () use ($faker) {
                return $faker->randomElement(['1080p', '720p']);
            },
            "Batterie" => function () use ($faker) {
                return $faker->randomElement(['Lithium-ion', 'Lithium-polymer']);
            },
            "Capacité de la batterie" => function () use ($faker) {
                return $faker->randomElement([3000, 4000, 4500, 5000]) . ' mAh';
            },
            "Type de batterie" => function () use ($faker) {
                return 'Non amovible';
            },
            "Connectivité" => function () use ($faker) {
                return $faker->randomElement(['4G', '5G']);
            },
            "Port USB" => function () use ($faker) {
                return $faker->randomElement(['USB-C', 'Micro-USB', 'Lightning']);
            },
            "Prise casque" => function () use ($faker) {
                return $faker->randomElement(['Oui', 'Non']);
            },
            "Bluetooth" => function () use ($faker) {
                return '5.0';
            },
            "WiFi" => function () use ($faker) {
                return $faker->randomElement(['802.11 a/b/g/n/ac', '802.11 a/b/g/n/ac/ax']);
            },
            "NFC" => function () use ($faker) {
                return $faker->randomElement(['Oui', 'Non']);
            },
            "GPS" => function () use ($faker) {
                return $faker->randomElement(['Oui', 'Non']);
            },
            "Dimensions" => function () use ($faker) {
                return $faker->randomFloat(1, 5.0, 7.0) . ' x ' . $faker->randomFloat(1, 2.5, 3.5) . ' x ' . $faker->randomFloat(1, 0.2, 0.4) . ' cm';
            },
            "Poids" => function () use ($faker) {
                return $faker->randomFloat(1, 150, 250) . ' g';
            },
            "Matériau" => function () use ($faker) {
                return $faker->randomElement(['Aluminium', 'Verre', 'Plastique']);
            },
            "Couleurs disponibles" => function () use ($faker) {
                return $faker->randomElement(['Noir', 'Blanc', 'Bleu', 'Rouge', 'Vert']);
            },
            "Indice de protection" => function () use ($faker) {
                return $faker->randomElement(['IP67', 'IP68']);
            },
            "Date de sortie" => function () use ($faker) {
                return $faker->date($format = 'Y-m-d', $max = 'now');
            }
        ];
    }


    public function getValueForAttribute(string $attribute)
    {
        return $this->getAttributesArray()[$attribute]();
    }


    public function load(ObjectManager $manager): void
    {

        foreach (array_keys($this->getAttributesArray()) as $name) {
            $attribute = new Attribute();
            $attribute->setName($name);

            $manager->persist($attribute);
        }

        $manager->flush();
    }


}
