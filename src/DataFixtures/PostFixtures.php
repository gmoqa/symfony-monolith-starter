<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class PostFixtures
 * @package App\DataFixtures
 * @author Guillermo Quinteros A. <gu.quinteros@gmail.com>
 */
class PostFixtures extends BaseFixture implements DependentFixtureInterface
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(30, 'posts', function() {
            $post = new Post();
            /** @var User $author */
            $author = $this->getRandomReference('users');
            $post
                ->setTitle($this->faker->sentence())
                ->setBody($this->faker->paragraph(10))
                ->setCreatedBy($author)
            ;
            return $post;
        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixture::class
        ];
    }
}
