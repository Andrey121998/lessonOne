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
        'success' => $return = 'Успех',
        'error'   => $return ='Ошибка',
        'pending' => $return ='Ожидание',
        default   => $return ='Неизвестно'
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
     match ($status) {
        OrderStatus::Pending => $return ='Заказ в ожидании',
        OrderStatus::Shipped => $return ='Заказ отправлен',
        OrderStatus::Delivered => $return ='Заказ доставлен',
    };
    return $return;
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
function multiply(float $mul1, float $mul2):float{
    
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
        return number_format((float) $value, 2, '.', '');
    } else {
        return $value;
    }
}
echo formatValue('tax'). '<br>';
echo formatValue(50). '<br>';
echo "________________________________Урок_3________________________________" . '<br>';