<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Repository\AuthorRepository;
use App\Entity\Author;
use App\Entity\Book;

class BookFixtures extends Fixture implements DependentFixtureInterface 
{
    private $authorRepository;
    
    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }
    
    public function getDependencies()   
    {
        return [
            AuthorFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $authors = $this->authorRepository->findAll();
        $randomAuthor = $authors[rand(0, 10)];        
 
        for ($i = 1; $i <=50; $i++) {

            $book = new Book();
            $book->setTitle('Book '.$i);
            $book->setAuthor($randomAuthor); 
            $manager->persist($book);
        }
        $manager->flush();
    }
}
