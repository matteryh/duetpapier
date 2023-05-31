<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if(isset($_POST['wyslij']))
{
    session_start();
    $polaczenie=@mysqli_connect('localhost', 'root', '', 'duetpapier');
    $email=$_SESSION['email'];
    $plik=$_POST['wyslij'];
    $opcja=$_POST['opcja'];
    $uwagi=$_POST['uwagi'];
    if($opcja=="opcja1")
    {
        $wybor="Klient chce otrzymać dokładnie te zamawiane produkty";
    }
    else
    {
        $wybor="Klient chce otrzymać podobne produkty";
    }
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host='smtp.gmail.com';
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth=true;
    $mail->Username='x'; //MAIL Z KTÓREGO WYSYŁAMY
    $mail->Password='x'; //HASŁO
    $mail->SMTPSecure='ssl';
    $mail->Port=465;
    $mail->SetFrom('x', 'x'); //MAIL Z KTÓREGO WYSYŁAMY
    $mail->AddAddress('x'); //MAIL NA KTÓRY WYSYŁAMY
    $mail->isHTML(false);
    $zapytanie=mysqli_query($polaczenie, "SELECT * FROM uzytkownicy WHERE email='$email';");
    while($rezultat = mysqli_fetch_array($zapytanie))
    {
        $mail->Subject='Zamówienie od '.$rezultat['email'];
        $mail->Body="Zamówienie wysłane przez: ".$rezultat['imie']." ".$rezultat['nazwisko']." (".$rezultat['email'].")\r\n".$wybor."\r\nUwagi do zamówienia:\r\n".$uwagi;
    }
    $file_to_attach='C:/zamowienia/'.$plik; 
    $mail->AddAttachment($file_to_attach , $plik);
    $mail->Send();
    mysqli_query($polaczenie, "UPDATE zamowienia SET status=1 WHERE email='$email' AND plik='$plik';");
    header('Location: ./');
    mysqli_close($polaczenie);
}
?>