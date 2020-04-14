<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }

    public function load(ObjectManager $manager)
    {
        // On configure dans quelles langues nous voulons nos données
        $faker = Factory::create('fr_FR');

        $tab = [0,3,5,7,9];

        // on créé 5 users
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($faker->email);
            foreach($tab as $value)
            {
                if($value != $i){
                    $user->setRoles((array)'ROLE_ADMIN');
                }
                else{
                    $user->setRoles((array)'ROLE_USER');
                }
            }
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'admin'
            ));

            $manager->persist($user);
        }
        $manager->flush();
    }
}
