<?php

namespace App\DataFixtures;

use App\Entity\Blog;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('admin@beneficium.ru');
        $user->setRoles(['ROLE_ADMIN']);
        $password = $this->hasher->hashPassword($user, 'admin@beneficium.ru');
        $user->setPassword($password);
        $manager->persist($user);

        for ($i = 1; $i <= 3; $i++){
            $category = new Category();
            $category->setName('category ' . $i);
            $manager->persist($category);
        }

        for ($userIndex = 1; $userIndex <= 10; $userIndex++) {
            $user = new User();
            $user->setEmail('user'. $userIndex . '@yandex.ru');
            $password = $this->hasher->hashPassword($user, 'pass_1234');
            $user->setPassword($password);
            $manager->persist($user);

            for ($blogIndex = 1; $blogIndex <= 5; $blogIndex++) {
                $blog = (new Blog($user))
                    ->setTitle('Blog title' . $userIndex . " " . $blogIndex)
                    ->setDescription('Blog description' . $userIndex . " " . $blogIndex)
                    ->setText('Blog text ' . $userIndex . " " . $blogIndex)
                    ->setUser($user);
                $manager->persist($blog);
            }
        }

        $manager->flush();
    }
}
