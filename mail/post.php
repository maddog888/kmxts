<?php
	require_once("class.phpmailer.php");
	require_once("class.smtp.php");
	$mail = new PHPMailer();
	$mail->SMTPDebug = false;
	$mail->isSMTP();
	$mail->SMTPAuth = true;
	$mail->Host = "smtp.qq.com";
	$mail->SMTPSecure = 'ssl';
	$mail->Port = 465;
	$mail->CharSet = 'UTF-8';
	$mail->FromName = $index['title'].' - '.$index['tail'];
	$mail->Username = $adminm['mailu'];
	$mail->Password = $adminm['mailp'];
	$mail->From = $adminm['mailu'];
	$mail->isHTML(true);
	$mail->addAddress($sjr);
	$mail->Subject = $sp['title'];
	$mail->Body = '感谢您在'.$index['title'].'购买了商品!您的卡密如下(一行一个):<br>'.$kms.'以上是您购买的卡密祝您生活愉快!';
	$status = $mail->send();
?>