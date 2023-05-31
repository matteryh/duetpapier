<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Duet - Papier s.c. - Hurtownia Artykułów Biurowych</title>
    <link rel="icon" type="image/x-icon" href="../logo.png">
</head>
<body>
    <header class="sticky-top">
        <nav class="navbar navbar-expand-md navbar-light bg-warning">
            <div class="container-fluid">
                <a class="navbard-brand" href="../"><img src="../logo.png" class="rounded" style="height:40px;"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#pasek">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="pasek">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="kategorie" role="button" data-bs-toggle="dropdown">Kategorie</a>
                            <ul class="dropdown-menu" aria-labelledby="kategorie">
                                <?php
                                    use PHPMailer\PHPMailer\PHPMailer;
                                    use PHPMailer\PHPMailer\Exception;
                                    session_start();
                                    session_destroy();
                                    session_start();
                                    $polaczenie=@mysqli_connect('localhost', 'root', '', 'duetpapier');
                                    $zapytanie=mysqli_query($polaczenie, "SELECT * FROM kategorie;");
                                    while($rezultat = mysqli_fetch_array($zapytanie))
                                    {
                                        echo "
                                        <li>
                                            <form method='get' action='../produkty'>
                                                <button class='dropdown-item' type='submit' name='kategoria' id='kategoria' value='$rezultat[id]'>$rezultat[nazwa]</button>
                                            </form>
                                        </li>
                                        "; 
                                    }
                                ?>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../konto">Konto</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../koszyk">Koszyk</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://drive.google.com/file/d/1kxkXz4hvwu61drGq7_A1LlD6wMdKWTXU/view?fbclid=IwAR1eeNuJlsiHI4D4WXNefFuOs58uT2kL5vNZ1FFlINqCn17HJBbnz6ScsKM">Katalog</a>
                        </li>
                    </ul>
                    <form method='get' action='produkty'>
                        <div class="input-group">
                            <input type='text' class='form-control' name='szukane' placeholder='Wpisz nazwę lub indeks' >
                            <button type='submit' class='btn btn-outline-dark'>Wyszukaj</button>
                        </div>
                    </form>
                </div>
            </div>
        </nav>
    </header>
    <div class="container mb-4 mt-4">
        <div class="row">
            <div class="col-12">
                <h4 class='display-4 mb-4'>Odzyskiwanie konta</h4>
                <?php
                if(isset($_POST['nowehaslo'])&&!empty($_POST['nowehaslo']))
                {
                    $odzyskiwanie=$_POST['odzyskiwanie'];
                    $nowehaslo=$_POST['nowehaslo'];
                    $nowehaslos=password_hash($nowehaslo, PASSWORD_DEFAULT);
                    mysqli_query($polaczenie, "UPDATE uzytkownicy SET haslo = '$nowehaslos' WHERE email='$odzyskiwanie';");
                    mysqli_query($polaczenie, "UPDATE uzytkownicy SET kod = NULL WHERE email='$odzyskiwanie';");
                    echo "<div class='alert alert-success'>Zaktualizowano hasło. Możesz się zalogować.</div>";
                }
                else if(isset($_POST['kod'])&&!empty($_POST['kod']))
                {
                    $odzyskiwanie=$_POST['odzyskiwanie'];
                    $zapytanie=mysqli_query($polaczenie, "SELECT * FROM uzytkownicy WHERE email='$odzyskiwanie'");
                    $rezultat = mysqli_fetch_array($zapytanie);
                    if(is_array($rezultat))
                    {
                        if($_POST['kod']==$rezultat['kod'])
                        {
                            echo "<div class='alert alert-info'>Poniżej wpisz nowe hasło.</div>
                            <form action='' class='was-validated' method='post'>
                                <label for='nowehaslo' class='form-label'>Nowe hasło:</label>
                                <input type='password' class='form-control' id='nowehaslo' placeholder='Nowe hasło' name='nowehaslo' required>
                                <div class='invalid-feedback'>Wypełnij to pole.</div>
                                <input type='hidden' name='odzyskiwanie' value='$odzyskiwanie'>
                                <button type='submit' class='btn btn-outline-warning mt-4'>Zmień hasło</button>
                            </form>";
                        }
                        else
                        {
                            $liczba = rand(100000,999999);
                            mysqli_query($polaczenie, "UPDATE uzytkownicy SET kod='$liczba' WHERE email='$odzyskiwanie';");
                            require 'phpmailer/src/Exception.php';
                            require 'phpmailer/src/PHPMailer.php';
                            require 'phpmailer/src/SMTP.php';
                            $mail = new PHPMailer(true);
                            $mail->isSMTP();
                            $mail->Host='smtp.gmail.com';
                            $mail->CharSet = "UTF-8";
                            $mail->SMTPAuth=true;
                            $mail->Username='x'; //MAIL Z KTÓREGO WYSYŁAMY
                            $mail->Password='x'; //HASŁO
                            $mail->SMTPSecure='ssl';
                            $mail->Port=465;
                            $mail->SetFrom('x'); //MAIL Z KTÓREGO WYSYŁAMY
                            $mail->AddAddress($odzyskiwanie); //MAIL NA KTÓRY WYSYŁAMY
                            $mail->isHTML(false);
                            $mail->Subject='Odzyskiwanie konta Duet - Papier s.c.';
                            $mail->Body="Twój kod odzyskiwania konta: ".$liczba;
                            $mail->Send();
                            echo "<div class='alert alert-danger'>Wprowadzono niepoprawny kod. Wysłano nowy kod odzyskiwania, wprowadź go poniżej.</div>
                            <form action='' class='was-validated' method='post'>
                                <label for='kod' class='form-label'>Kod odzyskiwania:</label>
                                <input type='text' class='form-control' id='kod' placeholder='6-cyfrowy kod' name='kod' required>
                                <div class='invalid-feedback'>Wypełnij to pole.</div>
                                <input type='hidden' name='odzyskiwanie' value='$odzyskiwanie'>
                                <button type='submit' class='btn btn-outline-warning mt-4'>Zweryfikuj kod</button>
                            </form>";
                        }
                    }
                }
                else if(isset($_POST['odzyskiwanie'])&&!empty($_POST['odzyskiwanie']))
                {
                    $odzyskiwanie=$_POST['odzyskiwanie'];
                    $zapytanie=mysqli_query($polaczenie, "SELECT * FROM uzytkownicy WHERE email='$odzyskiwanie'");
                    $rezultat = mysqli_fetch_array($zapytanie);
                    if(is_array($rezultat))
                    {
                        $liczba = rand(100000,999999);
                        mysqli_query($polaczenie, "UPDATE uzytkownicy SET kod='$liczba' WHERE email='$odzyskiwanie';");
                        require 'phpmailer/src/Exception.php';
                        require 'phpmailer/src/PHPMailer.php';
                        require 'phpmailer/src/SMTP.php';
                        $mail = new PHPMailer(true);
                        $mail->isSMTP();
                        $mail->Host='smtp.gmail.com';
                        $mail->CharSet = "UTF-8";
                        $mail->SMTPAuth=true;
                        $mail->Username='x'; //MAIL Z KTÓREGO WYSYŁAMY
                        $mail->Password='x'; //HASŁO
                        $mail->SMTPSecure='ssl';
                        $mail->Port=465;
                        $mail->SetFrom('x'); //MAIL Z KTÓREGO WYSYŁAMY
                        $mail->AddAddress($odzyskiwanie); //MAIL NA KTÓRY WYSYŁAMY
                        $mail->isHTML(false);
                        $mail->Subject='Odzyskiwanie konta Duet - Papier s.c.';
                        $mail->Body="Twój kod odzyskiwania konta: ".$liczba;
                        $mail->Send();
                        echo "<div class='alert alert-success'>Na adres $rezultat[email] wysłano 6-cyfrowy kod odzyskiwania. Wpisz go poniżej, aby zmienić hasło do konta.</div>
                        <form action='' class='was-validated' method='post'>
                            <label for='kod' class='form-label'>Kod odzyskiwania:</label>
                            <input type='text' class='form-control' id='kod' placeholder='6-cyfrowy kod' name='kod' required>
                            <div class='invalid-feedback'>Wypełnij to pole.</div>
                            <input type='hidden' name='odzyskiwanie' value='$odzyskiwanie'>
                            <button type='submit' class='btn btn-outline-warning mt-4'>Zweryfikuj kod</button>
                        </form>";
                    }
                    else
                    {
                        echo "<div class='alert alert-danger'>Na stronie nie został zarejestrowany użytkownik z podanym adresem e-mail</div>
                        <form action='' class='was-validated' method='post'>
                            <label for='odzyskiwanie' class='form-label'>Podaj dres e-mail konta, do którego dostęp chcesz odzyskać:</label>
                            <input type='text' class='form-control' id='odzyskiwanie' placeholder='Adres e-mail' name='odzyskiwanie' required  pattern='[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$$'>
                            <div class='invalid-feedback'>Wypełnij to pole.</div>
                            <button type='submit' class='btn btn-outline-warning mt-4'>Wyślij kod</button>
                        </form>";
                    }
                }
                else
                {
                    echo "<form action='' class='was-validated' method='post'>
                            <label for='odzyskiwanie' class='form-label'>Podaj adres e-mail konta, do którego dostęp chcesz odzyskać:</label>
                            <input type='text' class='form-control' id='odzyskiwanie' placeholder='Adres e-mail' name='odzyskiwanie' required  pattern='[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$$'>
                            <div class='invalid-feedback'>Wypełnij to pole.</div>
                        <button type='submit' class='btn btn-outline-warning mt-4'>Wyślij kod</button>
                    </form>";
                }
                mysqli_close($polaczenie);
                ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>