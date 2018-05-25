<?php

require  'lib/PHPMailerAutoload.php';

$mail = new PHPMailer;

$mail->isSMTP();

$mail->Host = 'smtp.timeweb.ru';
$mail->SMTPAuth = true;
$mail->Username = 'delivery52test@cb62856.tmweb.ru'; // логин от вашей почты
$mail->Password = 'delivery52test'; // пароль от почтового ящика
$mail->SMTPSecure = 'ssl';
$mail->Port = '465';

$mail->CharSet = 'UTF-8';
$mail->From = 'delivery52test@cb62856.tmweb.ru'; // адрес почты, с которой идет отправка
$mail->FromName = 'delivery52'; // имя отправителя
$mail->addAddress('uncle-4040@yandex.ru', 'TEST');
//$mail->addAddress('email2@email.com', 'Имя 2');
//$mail->addCC('email3@email.com');

$mail->isHTML(true);

$send_data = json_decode(file_get_contents("php://input"), true);

$call_data =    $send_data['call_data'];
$name_data  =   $send_data['name_data'];

$from_name =    $send_data['from_name'];
$from_phone =   $send_data['from_phone'];
$from_address = $send_data['from_address'];
$to_name =      $send_data['to_name'];
$to_phone =     $send_data['to_phone'];
$to_address =   $send_data['to_address'];
$to_type =      $send_data['to_type'];


$mail->Subject = 'Delivery52';
$send_body_content = '';

if($call_data && $name_data){
  $send_body_content = '
    <div style="width: 400px; border: 2px solid orange; padding: 10px; margin: 0 auto;">
      <p>
        <span style="text-transform: uppercase; background: orange; display: block; color: #fff; font-weight: bold; padding: 10px; margin-bottom: 20px;">Заказ звонка:  </span>
        <span style="display: block; color: #000;">От:  ' . $call_data . '</span>
        <span style="display: block; color: #000;">Тел:  ' . $name_data . '</span>
      </p>
    </div>';
}else{
  $send_body_content = '
    <div style="width: 400px; border: 2px solid orange; padding: 10px; margin: 0 auto;">
      <p>
        <span style="text-transform: uppercase; background: orange; display: block; color: #fff; font-weight: bold; padding: 10px; margin-bottom: 20px;">Заявка на доставку: </span>
        <span style="display: block; color: #000;">От:  ' . $from_name . '</span>
        <span style="display: block; color: #000;">Тел:  ' . $from_phone. '</span>
        <span style="display: block; color: #000;">Откуда:  ' . $from_address . '</span>
      <hr>
        <span style="display: block; color: #000;">Кому:  ' . $to_name . '</span>
        <span style="display: block; color: #000;">Тел:  ' . $to_phone . '</span>
        <span style="display: block; color: #000;">Куда:  ' . $to_address . '</span>
        <span style="display: block; color: #000;">Тип посылки:  ' . $to_type . '</span>
      </p>
    </div>';
}

$mail->Body = $send_body_content;

$mail->AltBody = $from_name . $from_phone . $from_address . $to_name . $to_phone . $to_address . $to_type . $call_data . $name_data;
if( $mail->send() ){
		$answer = '1';
	}else{
		$answer = '0';
		/*echo 'Письмо не может быть отправлено. ';
		echo 'Ошибка: ' . $mail->ErrorInfo;*/
	}
	die( $answer );

?>
