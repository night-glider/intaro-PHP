<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Book;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $images = [
            "https://149349728.v2.pressablecdn.com/wp-content/uploads/2019/08/The-Crying-Book-by-Heather-Christie-1.jpg",
            "https://www.adobe.com/express/create/cover/media_178ebed46ae02d6f3284c7886e9b28c5bb9046a02.jpeg?width=400&format=jpeg&optimize=medium",
            "https://edit.org/images/cat/book-covers-big-2019101610.jpg",
            "https://cdn.pastemagazine.com/www/system/images/photo_albums/best-book-covers-fall-2019/large/bbcdune.jpg?1384968217"
        ];

        for ($i = 0; $i < 20; $i++) {
            $book = new Book();
            $book->setName('book '.$i);
            $book->setAuthor('author'.$i);
            $book->setCoverUrl( $images[array_rand($images)] );
            $book->setFileUrl( "https://logomama.ru/res/%D0%BA%D0%BE%D0%BB%D0%BE%D0%B1%D0%BE%D0%BA.pdf" );
            $manager->persist($book);
        }

        $manager->flush();
    }
}
