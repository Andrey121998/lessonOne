<?php

namespace App\DataFixtures;

use App\Entity\Userd;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserdFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $users = [
            ['name' => 'Дмитрий Орлов', 'email' => 'dmitry@example.com', 'role' => 'user'],
            ['name' => 'Елена Воробьева', 'email' => 'elena@example.com', 'role' => 'admin'],
            ['name' => 'Алексей Новиков', 'email' => 'alexey@example.com', 'role' => 'user'],
            ['name' => 'Ольга Кузнецова', 'email' => 'olga@example.com', 'role' => 'user'],
            ['name' => 'Виктор Павлов', 'email' => 'viktor@example.com', 'role' => 'user'],
        ];

        foreach ($users as $userData) {
            $user = new Userd();
            $user->setName($userData['name']);
            $user->setEmail($userData['email']);
            $user->setRole($userData['role']);
            $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
            
            $manager->persist($user);
        }

        $manager->flush();
    }
}