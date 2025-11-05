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