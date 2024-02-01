<?php

namespace App\Model;

class User
{
    public function __construct(
        private ?int $id = null,
        private ?string $fullname = null,
        private ?string $email = null,
        private ?string $password = null,
        private array $role = [],
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(?string $fullname): static
    {
        $this->fullname = $fullname;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function getRole(): array
    {
        return $this->role;
    }

    public function setRole(array $role): static
    {
        $this->role = $role;
        return $this;
    }

    public function findOneById(int $id): static|false
    {
        $pdo = new \PDO('mysql:host=localhost;dbname=draft-shop', 'root', '');
        $sql = "SELECT * FROM user WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->Fetch(\PDO::FETCH_ASSOC);
        if (!$result) {
            return false;
        }
        return new static(
            $result['id'],
            $result['fullname'],
            $result['email'],
            $result['password'],
            json_decode($result['role']),
        );
    }

    public function findAll(): array
    {
        $pdo = new \PDO('mysql:host=localhost;dbname=draft-shop', 'root', '');
        $sql = "SELECT * FROM user";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $users = [];
        foreach ($results as $user) {
            $users[] = new static(
                $user['id'],
                $user['fullname'],
                $user['email'],
                $user['password'],
                json_decode($user['role']),
            );
        }
        return $users;
    }

    public function create(): static
    {
        $pdo = new \PDO('mysql:host=localhost;dbname=draft-shop', 'root', '');
        $sql = "INSERT INTO user (fullname, email, password, role) VALUES (:fullname, :email, :password, :role)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':fullname', $this->getFullname());
        $stmt->bindValue(':email', $this->getEmail());
        $stmt->bindValue(':password', $this->getPassword());
        $stmt->bindValue(':role', json_encode($this->getRole()));
        $stmt->execute();
        $this->setId((int) $pdo->lastInsertId());
        return $this;
    }

    public function update(): static
    {
        $pdo = new \PDO('mysql:host=localhost;dbname=draft-shop', 'root', '');
        $sql = "UPDATE user SET fullname = :fullname, email = :email, password = :password, role = :role WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':fullname', $this->getFullname());
        $stmt->bindValue(':email', $this->getEmail());
        $stmt->bindValue(':password', $this->getPassword());
        $stmt->bindValue(':role', json_encode($this->getRole()));
        $stmt->bindValue(':id', $this->getId());
        $stmt->execute();
        return $this;
    }
}
