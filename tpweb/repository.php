<?php

class Repository {
    protected $pdo;
    protected $table;

    public function __construct(PDO $pdo, string $table) {
        $this->pdo = $pdo;
        $this->table = $table;
    }

    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function create(array $data): bool {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(fn($key) => ":$key", array_keys($data)));
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} ($columns) VALUES ($placeholders)");
        return $stmt->execute($data);
    }

    public function delete($id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=testdb', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sectionRepo = new Repository($pdo, 'section');
    $sectionRepo->create(['name' => 'New Section']);
    print_r($sectionRepo->findAll());
    print_r($sectionRepo->findById(1));
    $sectionRepo->delete(1);

    $userRepo = new Repository($pdo, 'user');
    $userRepo->create(['username' => 'johndoe', 'email' => 'john@example.com']);
    print_r($userRepo->findAll());
    print_r($userRepo->findById(1));
    $userRepo->delete(1);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}