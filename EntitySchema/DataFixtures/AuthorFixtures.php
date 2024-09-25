<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Author;

class AuthorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {         
        for ($i = 1; $i <=10; $i++) {
            $author = new Author();
            $author->setFirstname('author firstname '.$i);
            $author->setName('author name '.$i); 
            $manager->persist($author);
        }
        
        $manager->flush();
    }
}
