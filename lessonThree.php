<?php 
declare(strict_types=1);

require_once 'vendor/autoload.php';

$host = "127.127.126.50";
$dbname = "Study_db";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Подключение успешно!". '<br>';
} catch (PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}

echo "________________________________Урок_1________________________________" . '<br>';
// задача 1
class Database {
    private $pdo;
    
    public function connect(): string {
        try {
            $this->pdo = new PDO("mysql:host=127.127.126.50;dbname=Study_db;charset=utf8", "root", "");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return "Подключение успешно". '<br>';
        } catch (PDOException $e) {
            return "Ошибка подключения: " . $e->getMessage();
        }
    }
    public function getUsers(): array{
        $stmt = $this->pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function addUser(string $name, string $email): void{
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
        $stmt->execute(['name' => $name, 'email' => $email]);
    }
    public function deleteUser($id): void {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getUserByEmail($email): array {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Неверный формат email");
        }
        
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }
    public function addUserP($name, $email, $password): void {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute([
            'name' => $name, 
            'email' => $email, 
            'password' => $password
        ]);
    }
}

$db = new Database();
echo $db->connect();  
// задача 2
print_r($db->getUsers());
echo "<br>";
// задача 3
//$db->addUser("Иван", "ivan@example.com");
print_r($db->getUsers());
echo "<br>";
// задача 4
//$db->addUser("Алексей', 'hacked@example.com'); DROP TABLE users; --", "hacker@example.com");  
print_r($db->getUsers());  
echo "<br>";
// задача 5
$db->deleteUser(1);
print_r($db->getUsers()); 
echo "<br>";
echo "________________________________Урок_2________________________________" . '<br>';
// задача 1
print_r($db->getUserByEmail("ivan@example.com"));
echo "<br>";  
// $db->getUserByEmail("hacker@example.com OR 1=1 --");
echo "<br>";  
// задача 2
// $db->addUserP("Алексей', 'haasdasdadm'); DROP TABLE users; --", "hacker@example.com", "123456");  
print_r($db->getUsers());
echo "<br>";
// задача 3
// $db->deleteUser("2 OR 1=1");  
print_r($db->getUsers());
echo "<br>";
// задача 4
// $db->addUser("Oleg", "oleg@example.com", "password");
print_r($db->getUserByEmail("oleg@example.com"));
echo "<br>";
// задача 5
// $db->getUserByEmail("неправильный_адрес");
echo "<br>";
echo "________________________________Урок_3________________________________" . '<br>';
require_once 'eloquent_bootstrap.php';
require_once 'doctrine_bootstrap.php';
use App\User as EloquentUser;
use App\Post as EloquentPost;
use App\Entities\User as DoctrineUser;
use App\Entities\Post as DoctrinePost;
// задача 1
try {
    $user = EloquentUser::firstOrCreate(
        ['email' => 'ivan-eloquent@example.com'],
        [
            'name' => "Иванннн",
            'password' => password_hash("secret", PASSWORD_DEFAULT)
        ]
    );
    echo "Пользователь обработан!<br>";
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage() . "<br>";
}
// задача 2
$post = EloquentPost::where('title', 'Первый пост Eloquent')->first();

if (!$post) {
    $user = EloquentUser::where('email', 'ivan-eloquent@example.com')->first();
    
    $post = new EloquentPost();
    $post->title = "Первый пост Eloquent";
    $post->content = "Содержание моего первого поста через Eloquent";
    $post->user_id = $user->id;
    $post->save();
    echo "Пост создан!<br>";
}

// Тестируем отношение
$foundPost = EloquentPost::where('title', 'Первый пост Eloquent')->first();
if ($foundPost && $foundPost->user) {
    echo "Автор поста: " . $foundPost->user->name . "<br>"; 
} else {
    echo "Пост или пользователь не найден<br>";
}
// задача 3
try {
    $existingDoctrineUser = $entityManager->getRepository(DoctrineUser::class)
        ->findOneBy(['email' => 'anna-doctrine@example.com']);

    if (!$existingDoctrineUser) {
        $doctrineUser = new DoctrineUser();
        $doctrineUser->setName("Анна");
        $doctrineUser->setEmail("anna-doctrine@example.com");
        $doctrineUser->setPassword(password_hash("doctrinepass", PASSWORD_DEFAULT));
        
        $entityManager->persist($doctrineUser);
        $entityManager->flush();
        echo "Doctrine: Пользователь добавлен в БД<br>";
    } else {
        echo "Doctrine: Пользователь уже существует<br>";
    }
} catch (Exception $e) {
    echo "Doctrine ошибка: " . $e->getMessage() . "<br>";
}
// задача 4
try {
    $userRepository = $entityManager->getRepository(DoctrineUser::class);
    $foundUser = $userRepository->findOneBy(['email' => 'ivan@example.com']);

    if ($foundUser) {
        echo "Doctrine найден: " . $foundUser->getName() . "<br>";
    } else {
        echo "Пользователь не найден<br>";
    }
} catch (Exception $e) {
    echo "Ошибка репозитория: " . $e->getMessage() . "<br>";
}
// задача 5
try {
    // Создаем пост для пользователя Doctrine
    $doctrinePost = $entityManager->getRepository(DoctrinePost::class)
        ->findOneBy(['title' => 'Пост от Анны Doctrine']);

    if (!$doctrinePost) {
        $doctrineUser = $entityManager->getRepository(DoctrineUser::class)
            ->findOneBy(['email' => 'anna-doctrine@example.com']);
        
        if ($doctrineUser) {
            $doctrinePost = new DoctrinePost();
            $doctrinePost->setTitle("Пост от Анны Doctrine");
            $doctrinePost->setContent("Это пост созданный через Doctrine");
            $doctrinePost->setUser($doctrineUser);
            
            $entityManager->persist($doctrinePost);
            $entityManager->flush();
            echo "Пост Doctrine создан!<br>";
        } else {
            echo "Пользователь Doctrine не найден для создания поста<br>";
        }
    } else {
        echo "Пост Doctrine уже существует<br>";
    }

    // Тестируем отношение
    $foundDoctrinePost = $entityManager->getRepository(DoctrinePost::class)
        ->findOneBy(['title' => 'Пост от Анны Doctrine']);

    if ($foundDoctrinePost && $foundDoctrinePost->getUser()) {
        echo "Автор поста Doctrine: " . $foundDoctrinePost->getUser()->getName() . "<br>"; // ✅ "Анна"
    } else {
        echo "Пост Doctrine не найден<br>";
    }
} catch (Exception $e) {
    echo "Ошибка отношений Doctrine: " . $e->getMessage() . "<br>";
}
echo "________________________________Урок_4________________________________" . '<br>';
