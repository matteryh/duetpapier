<html>
<head>
    <meta charset='utf-8'>
</head>
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
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host='smtp.gmail.com';
    $mail->SMTPAuth=true;
    $mail->Username='mateuszhonc@gmail.com'; //UZUPEŁNIĆ MAIL Z KTÓREGO WYSYŁAMY
    $mail->Password='quhwbevvyevfldvb'; //UZUPEŁNIĆ HASŁO
    $mail->SMTPSecure='ssl';
    $mail->Port=465;

    $mail->SetFrom('mateuszhonc@gmail.com', 'Duet - Papier s.c.'); //UZUPEŁNIĆ MAIL Z KTÓREGO WYSYŁAMY
    $mail->AddAddress('mateuszhonc@gmail.com'); //UZUPEŁNIĆ MAIL NA KTÓRY WYSYŁAMY
    $mail->isHTML(true);
    $mail->Subject='Zamowienie';
    $zapytanie=mysqli_query($polaczenie, "SELECT * FROM uzytkownicy WHERE email='$email';");
    while($rezultat = mysqli_fetch_array($zapytanie))
    {
        $mail->Body='Zamówienie wysłane przez: '.$rezultat['imie'].' '.$rezultat['nazwisko'].' ('.$rezultat['email'].')';
    }
    $file_to_attach='C:/zamowienia/'.$plik; 
    $mail->AddAttachment($file_to_attach , $plik);

    $mail->Send();

    mysqli_query($polaczenie, "UPDATE zamowienia SET status=1 WHERE email='$email' AND plik='$plik';");
    header('Location: ./');
    mysqli_close($polaczenie);
}
?>
</html>