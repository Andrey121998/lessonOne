<?php 
declare(strict_types=1);
echo "________________________________Урок_1________________________________" . '<br>';
// задача 1
class Car implements Movable {
    use Loggable;
    protected string $brand;
    protected string $model;
    protected int $year;
    public function __construct(string $brand, string $model, int $year)
    {
        $this -> brand = $brand;
        $this -> model = $model;
        $this -> year = $year;
    }
    public function getCarInfo() : string{
        return $this -> year . ' ' . $this -> brand . ' ' . $this -> model. '<br>';
    }
    public function getYear() : int{
        return $this->year;
    }
    public function setYear(int $year) : void{
        $this->year = $year; 
    }
    public function move(): void {
        echo "Машина едет!";
    }

}
$car = new Car("Toyota", "Camry", 2020);
echo $car->getCarInfo(); 
// задача 2
$car->setYear(2010);
echo $car->getYear(). '<br>';
// задача 3
class ElectricCar extends Car{
    protected int $batteryCapacity;
    public function __construct(string $brand, string $model, int $year, int $batteryCapacity)
    {
        parent::__construct($brand, $model, $year);
        $this->batteryCapacity = $batteryCapacity;
    }
    public function getBatteryInfo(): int{
        return $this->batteryCapacity;
    }
}
$tesla = new ElectricCar("Tesla", "Model S", 2021, 100);
echo $tesla->getBatteryInfo(). '<br>';
echo $tesla->getYear(). '<br>';
// задача 4
interface Movable {
    public function move(): void;
}
class Bicycle implements Movable {
    public function move(): void {
        echo "Велосипед едет!";
    }
}
echo $car->move(). '<br>';
$bike = new Bicycle();
echo $bike->move(). '<br>'; 
echo $tesla->move(). '<br>';
// задача 5
trait Loggable {
    public function log(string $message): void {
        echo "[LOG]: $message";
    }
}
$car->log("Запущен двигатель");
echo '<br>'; 
echo "________________________________Урок_2________________________________" . '<br>';

// задача 1
class BankAccount implements Payable {
    private int $balance;
    public function __construct(int $balance)
    {
        $this->balance=$balance;
    }
    public function deposit(int $num):void{
        $this->balance +=$num;
    }
    public function withdraw(int $num):void{
        if($num<=$this->balance){
            $this->balance-=$num;
        }else echo "Ошибка: недостаточно средств". '<br>';
    }
    public function getBalance():int{
        return $this->balance;
    }
    public function pay(int $amount):void{
        if($amount <=$this->balance){
            $this->withdraw($amount);
            echo "Баланс уменьшился на " . $amount. '<br>';
        }else $this->withdraw($amount);
        
    }
}
$account = new BankAccount(1000);
$account->deposit(500);
echo $account->getBalance(). '<br>';  
$account->withdraw(300);
echo $account->getBalance(). '<br>';  
$account->withdraw(5000);

// задача 2
class SavingsAccount extends BankAccount{
    private int $stake;
    public function __construct(int $balance, int $stake)
    {
        parent::__construct($balance);
        $this->stake=$stake;
    }
    public function applyInterest() : void {
        $interest=$this->getBalance()*$this->stake/100;
        $this->deposit($interest);
    }
}
$savings = new SavingsAccount(1000, 5);
$savings->applyInterest();
echo $savings->getBalance(). '<br>';  

// задача 3
class CreditAccount extends BankAccount{
    public function withdraw(int $num):void{
        $this->deposit(-$num);
    }
    public function pay(int $amount):void{
        $this->withdraw($amount);
        echo "Ваш баланс составляет " . $this->getBalance(). '<br>';
    }
}
$credit = new CreditAccount(1000);
$credit->withdraw(1500);
echo $credit->getBalance(). '<br>';

// задача 4
interface Payable{
    public function pay(int $amount):void;
}
$bank = new BankAccount(500);
$credit = new CreditAccount(500);
$bank->pay(200);
$credit->pay(700);
echo "________________________________Урок_3________________________________" . '<br>';
// задача 1
abstract class Shape {

   abstract public function getArea(): float;
   abstract public function draw(): void;
}
class Rectangle extends Shape implements Drawable{
    protected float $horizontal;
    protected float $vertical;
    public function __construct(float $horizontal, float $vertical)
    {
        $this->horizontal = $horizontal;
        $this->vertical = $vertical;
    }
    public function getArea(): float
    {
        return $this->horizontal * $this->vertical;
    }
    public function draw(): void
    {
        echo "Рисую квадрат со сторонами " . $this->horizontal . " и " . $this->vertical. '<br>';
    }
}
class Circle extends Shape implements Drawable{
    protected float $radius;
    protected const float pi =   3.1415926535;
    public function __construct(float $radius)
    {
        $this->radius=$radius;
    }
    public function getArea(): float
    {
        return round($this->radius*$this->radius  *self::pi,2);
    }
    public function draw(): void
    {
        echo "Рисую круг радиусом " . $this->radius. '<br>';
    }
}
$rect = new Rectangle(10, 5);
echo $rect->getArea(). '<br>';
$circle = new Circle(7);
echo $circle->getArea(). '<br>';  
// задача 2
interface Drawable {
    public function draw():void;
}
$rect->draw();
$circle->draw();
// задача 3
function renderShape(Shape $shape): void {
    $shape->draw(); 
    echo "Площадь: " . $shape->getArea() . '<br>'; // пришлось добавить абстрактный метод drow, не знаю нужно ли было это делать
}
renderShape(new Rectangle(5, 5));  
renderShape(new Circle(3));
// задача 4
abstract class Vehicle {
    abstract public function move():void;
}
interface Fuelable {
    public function refuel():void;
}
class Crossover extends Vehicle implements Fuelable{
    public function move(): void
    {
        echo "Машина едет!". '<br>';
    }
    public function refuel(): void
    {
        echo "Машина заправлена!". '<br>';
    }
}
class Bike extends Vehicle{
    public function move(): void
    {
        echo "Велосипед едет!". '<br>';
    }
}
$crossover = new Crossover();
$crossover->move(); 
$crossover->refuel(); 
$bicycle = new Bike();
$bicycle->move();
echo "________________________________Урок_4________________________________" . '<br>';
// задача 1
//require "User.php";
//$user = new App\Models\User("Иван");
//echo $user->getName();//работает, но нужно было закоментить что бы проверить как работает композер
// задача 2
// require 'vendor/autoload.php';//дублируется в индексе
// use App\Models\User;//пока используем полный путь.
$user = new App\Models\User("Анна");
echo $user->getName();
// задача 3
$service = new App\Services\UserService();
echo $service->getUserGreeting("Олег");
// задача 4
$service = new App\Services\UserService();
echo $service->getUserGreeting("Мария");    
// задача 5
$order = new App\Models\Order();
$order->log("Заказ создан");


