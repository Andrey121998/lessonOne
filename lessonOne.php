<?php 
declare(strict_types=1);
echo "________________________________Урок_1________________________________" . '<br>';
// задача 1
function getStatusMessage(string $status): string {
    // match($status){  
    //     'success' => $return = 'Успех',
    //     'error'   => $return ='Ошибка',
    //     'pending' => $return ='Ожидание',
    //     default   => $return ='Неизвестно'
    // };
    // return $return;
    return match($status){ // раньше я так не делал, повод начать.
        'success' => 'Успех',
        'error'   =>'Ошибка',
        'pending' => 'Ожидание',
        default   => 'Неизвестно'
    };
}
$testArray = ['success','error','pending', '' ];
foreach($testArray  as $row){
    echo getStatusMessage($row). '<br>';
}
// задача 2
'<br>';
function getCalculatePrice(float $basePrice, float $discount , float $tax  ):float{
    $disPrice = $basePrice - (($basePrice / 100)*$discount) ;
    $calculate = $disPrice + (($disPrice / 100) * $tax);
    return $calculate; 
}
echo getCalculatePrice(basePrice: 1000, discount: 10, tax: 5) .'<br>';
echo getCalculatePrice(tax: 5, discount: 10, basePrice: 2000) . '<br>';
// задача 3
class User {
  public readonly int $id;
  public readonly string $name;
  public readonly string $email;
  public function __construct(int $id, string $name, string $email)
  {
    $this->id = $id;
    $this->name = $name;
    $this->email = $email;
  }  
}
$user = new User(1, 'Иван', 'ivan');
echo $user->name. '<br>';
echo "место для ошибки". '<br>';//$user->name = 'Андрей'. '<br>';
'<br>';
// задача 4
enum OrderStatus: string {
    case Pending = 'pending';
    case Shipped = 'shipped';
    case Delivered = 'delivered';
}

function getDeliveryMessage(OrderStatus $status): string {
    //  match ($status) {
    //     OrderStatus::Pending => $return ='Заказ в ожидании',
    //     OrderStatus::Shipped => $return ='Заказ отправлен',
    //     OrderStatus::Delivered => $return ='Заказ доставлен',
    // };
    // return $return;
   return match ($status) {
        OrderStatus::Pending => 'Заказ в ожидании',
        OrderStatus::Shipped => 'Заказ отправлен',
        OrderStatus::Delivered => 'Заказ доставлен',
    };
}

echo getDeliveryMessage(OrderStatus::Pending). '<br>';  
echo getDeliveryMessage(OrderStatus::Shipped). '<br>';  
echo getDeliveryMessage(OrderStatus::Delivered). '<br>';
'<br>';
// задача 5
function getUserEmail(?object $user): string {
    return $user?->profile?->email ?? 'Email не найден';
}
$user1 = (object)[
    'profile' => (object)[
        'email' => 'email'
    ]
];
echo getUserEmail($user1). '<br>'; 

$user2 = (object)[
    'profile' => null
];
echo getUserEmail($user2). '<br>';
echo "________________________________Урок_2________________________________" . '<br>';
// задача 1
function multiply(float $mul1, int $mul2):float{
    
    return $mul1 * $mul2; 
}
echo multiply(1.2, 2). '<br>';
// задача 2
function isAdult(int $age): bool{
    // return $age >=18 ? true : false; //как оказалось, это не нужно.
    return $age >= 18;
}
echo isAdult(18). '<br>';
echo isAdult(16). '<br>';
// задача 3
function calculateTax(float $price, float $tax): float{
    if($tax<1){
    $total= $price + ($price * $tax);
    }else $total= $price +(($price * $tax)/100);
    return round($total,2);
}
echo calculateTax(50, 40). '<br>';
echo calculateTax(50, 0.4). '<br>';
// задача 4
function getNamesLength(array $names): array {
    return array_map('strlen', $names);
}
$arratest4=["Alice", "Bob", "Charlie"];
echo implode(',',getNamesLength($arratest4)). '<br>';
// задача 5
function formatValue(int|float|string $value): string{
    if (is_numeric($value)) {
        // Приведение к float для точного форматирования
        return number_format((float) $value);
    } else {
        return $value;
    }
}
echo formatValue('tax'). '<br>';
echo formatValue(50). '<br>';
echo "________________________________Урок_3________________________________" . '<br>';
// задача 1
function filterEvenNumbers(array $numbers): array
{
    return array_filter($numbers, function($number) {
        return $number % 2 === 0;
    });
}

print_r(filterEvenNumbers([1, 2, 3, 4, 5, 6]));
//задача 2
echo "/задача 2/ ";
function squareNumbers(array $numbers): array
{
    return array_map(function($number) {
        return $number * $number;
    }, $numbers);
}
print_r(squareNumbers([1, 2, 3, 4]));
//задача 3
echo "/задача 3/ ";
function getUserEmails(array $users): array
{
    return array_map(function($user) {
        return $user['email'];
    }, $users);
}

$users = [
    ['id' => 1, 'name' => 'Alice', 'email' => 'alice@example.com'],
    ['id' => 2, 'name' => 'Bob', 'email' => 'bob@example.com'],
];

print_r(getUserEmails($users));
echo '<br>' . "________________________________Урок_4________________________________" . '<br>';
// задача 1
function checkNumber(int $int):string{
    if ($int > 0){
        return "положительное";
    }else if ($int < 0){
        return "отрицательное";
    }else{
        return "ноль";
    }
}
$numArr=[1,-3,0];
foreach($numArr as $row){
    echo checkNumber($row). '<br>' ;
}
// задача 2
function getAgeCategory(int $age):string{
    return match(true) {
        $age >= 0 && $age <= 12 => "Ребенок",
        $age >= 13 && $age <= 17 => "Подросток",
        $age >= 18 && $age <= 64 => "Взрослый",
        $age >= 65 => "Пожилой",
        default => "некорректный возраст"
    };
}

echo getAgeCategory(8) . '<br>';    
echo getAgeCategory(15) . '<br>';   
echo getAgeCategory(25) . '<br>';   
echo getAgeCategory(70) . '<br>';   
// задача 3
function printNumbers(int $num):void{
    for ( $i = 1; $i <= $num; $i++ ){
        echo $i . '<br>';
    }
}
$numTest = 6;
printNumbers($numTest);
// задача 4
function factorial(int $num): void{
    $facnum = 1;
    $i = 1;
    // for ( $i = 1; $i <= $num; $i++ ){
        
    //     $facnum = $facnum * $i;
    // }
    while ($i <= $num){
        $facnum = $facnum * $i;
        $i++;
    }
    echo $facnum . '<br>';
}
factorial(5);
// задача 5
function printArrayItems(array $arr):void{
    foreach($arr as $row){
        echo $row . '<br>';
    }
}
printArrayItems(["apple", "banana", "cherry"]);
// задача 6
function printEvenNumbers(int $num):void {
    $i = 1;
    while($i <= $num){
        if($i % 2 !==0){
            $i++;
            continue;
        }
        echo $i . '<br>'; 
        $i++;
    }
}
printEvenNumbers(10);
echo '<br>' . "________________________________Урок_5________________________________" . '<br>';
// задача 1
function greetUser(string $name, string $lang = 'ru'):void{
    if($lang !=='ru'){
        echo 'hello, ' . $name . '!'. '<br>';
    }else{
         echo 'привет, ' . $name . '!'. '<br>';
    }
}
greetUser('Jhon','er');
greetUser('Андрей');
// задача 2
function calculateDiscount(float $price, float $discount = 0.1): void{
    if($discount<1){
    $total= $price - ($price * $discount);
    echo round($total,2). '<br>';
    }else{ $total= $price -(($price * $discount)/100);
    echo round($total,2). '<br>';
    }
}
calculateDiscount(100);
calculateDiscount(100, 20);
// задача 3
function orderPizza(string $size = 'medium', string $crust ='thin', array $toppings = ["cheese"]):void{
    echo 'вы заказали ' . $size . ' пиццу на ' . $crust . ' тесте с добавлением ';
    foreach($toppings as $row){
        echo $row . ' ';
    }
    echo '<br>'; 
}
orderPizza();
orderPizza('extra large', 'extra thin', ['two', 'number', 'nines', 'and', 'big', 'soda']);
// задача 4
function formatText(string $text, bool $uppercase = false): string {
    if ($uppercase) {
        return strtoupper($text);
    }
    return $text;
}

echo formatText("hello").'<br>'; 
echo formatText("hello", true).'<br>';  
echo formatText("hello", false).'<br>'; 
// задача 5
function generatePassword(int $length = 8, bool $includeNumbers = true, bool $includeSpecialChars = false): string {
    $letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $numbers = '0123456789';
    $specialChars = '!@#$%^&*()_+-=[]{}|;:,.<>?';
    
    $characters = $letters;
    if ($includeNumbers) {
        $characters .= $numbers;
    }
    if ($includeSpecialChars) {
        $characters .= $specialChars;
    }
    
    $password = '';
    $charCount = strlen($characters);
    
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[random_int(0, $charCount - 1)];
    }
    
    return $password;
}
echo generatePassword() .'<br>';
echo generatePassword(length: 12, includeSpecialChars: true) .'<br>';