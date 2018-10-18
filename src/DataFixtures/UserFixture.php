<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserFixture
 * @package App\DataFixtures
 * @author Guillermo Quinteros A. <gu.quinteros@gmail.com>
 */
class UserFixture extends BaseFixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * UserFixture constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    protected function loadData(ObjectManager $manager)
    {
        $admin = $this->getAdminFixture();
        $manager->persist($admin);

        $this->createMany(10, 'users', function () {
            $user = new User();
            $user
                ->setEmail($this->faker->safeEmail)
                ->setFirstName($this->faker->firstNameMale)
                ->setFirstLastName($this->faker->lastName)
                ->setRoles(['ROLE_USER'])
                ->setPassword($this->encoder->encodePassword(
                $user,
                '123pass'
            ));
            return $user;
        });

        $manager->flush();
    }

    /**
     * @return User
     */
    private function getAdminFixture()
    {
        $admin = new User();
        $admin
            ->setFirstName('Guillermo')
            ->setFirstLastName('Quinteros')
            ->setPassword($this->encoder->encodePassword(
                $admin,
                '123pass'
            ))
            ->setEmail('gu.quinteros@gmail.com')
            ->setRoles(['ROLE_ADMIN'])
        ;

        return $admin;
    }
}
