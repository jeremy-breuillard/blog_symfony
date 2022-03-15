<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Tag;
use App\Service\UploaderHelper;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\File;

class ArticleFixtures extends BaseFixture implements DependentFixtureInterface
{

    private static $articleImages = [
        'asteroid.jpeg',
        'mercury.jpeg',
        'lightspeed.png',
    ];

    private $uploaderHelper;

    public function __construct(UploaderHelper $uploaderHelper)
    {
        $this->uploaderHelper = $uploaderHelper;
    }

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_articles', function($count) use ($manager) {

            $randomImage = $this->faker->randomElement(self::$articleImages);
            $imageFilename = $this->uploaderHelper
                ->uploadArticleImage(new File(__DIR__.'/images/'.$randomImage));

            $article->setAuthor($this->getRandomReference('main_users'))
                ->setHeartCount($this->faker->numberBetween(5, 100))
                ->setImageFilename($imageFilename)
            ;

            $tags = $this->getRandomReferences('main_tags', $this->faker->numberBetween(0, 5));
            foreach ($tags as $tag) {
                $article->addTag($tag);
            }

            return $article;
        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TagFixture::class,
            UserFixture::class,
        ];
    }
}
