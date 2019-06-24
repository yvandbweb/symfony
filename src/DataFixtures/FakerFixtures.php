<?php
// src/DataFixtures/FakerFixtures.php
namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Post;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class FakerFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        // on créé 10 personnes
        for ($i = 0; $i < 30; $i++) {
            $post=new Post();
            $post->setTxt($faker->text);
            $personne = new User();            
            $personne->setNameuser($faker->name);
            $personne->setDatetime($faker->dateTimeBetween( '-2 years', '+0 days'));
            $manager->persist($personne);
            $post->setUser($personne); 
            $post->setDatetime($faker->dateTimeBetween('-2 years', '+0 days'));
            $manager->persist($post);
        }

        $manager->flush();
    }
}

?>
