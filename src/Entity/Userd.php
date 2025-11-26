<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'usersd')]
class Userd
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private string $email;

    #[ORM\Column(type: 'string', length: 255)]
    private string $password;

    #[ORM\Column(type: 'string', length: 255, options: ['default' => 'user'])]
    private string $role = 'user';

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    // Геттеры и сеттеры
    public function getId(): ?int { return $this->id; }
    
    public function getName(): string { return $this->name; }
    public function setName(string $name): void { $this->name = $name; }
    
    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): void { $this->email = $email; }
    
    public function getPassword(): string { return $this->password; }
    public function setPassword(string $password): void { $this->password = $password; }
    
    public function getRole(): string { return $this->role; }
    public function setRole(string $role): void { $this->role = $role; }
    
    public function getCreatedAt(): \DateTimeInterface { return $this->createdAt; }
    public function setCreatedAt(\DateTimeInterface $createdAt): void { $this->createdAt = $createdAt; }
    
    public function getUpdatedAt(): \DateTimeInterface { return $this->updatedAt; }
    public function setUpdatedAt(\DateTimeInterface $updatedAt): void { $this->updatedAt = $updatedAt; }
}