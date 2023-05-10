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
    <div class="container-fluid bg-warning sticky-top">
        <div class="row">
            <div class="col-12">
                <!--Strona główna-->
                <a href="../glowna" type="button" class="btn btn-warning text-white btn-lg float-start">
                    <img src="../logo.png" class="rounded" style="height:45px;">
                </a>
                <!--Wybieranie kategorii-->
                <div class="dropdown">
                    <button type="button" class="btn btn-warning text-white float-start btn-lg" data-bs-toggle="dropdown">
                        <img src="../menu.png" style="height:45px;">
                    </button>
                    <ul class="dropdown-menu">
                        <?php
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
                </div>
                <!--Wyszukiwanie-->
                <a href="../wyszukiwanie" type="button" class="btn btn-warning text-white btn-lg float-start">
                    <img src="../lupa.png" class="rounded" style="height:45px;">
                </a>
                <!--Koszyk-->
                <a href="../koszyk" type="button" class="btn btn-warning text-white float-end btn-lg">
                    <img src="../wózek.png" style="height:45px;">
                </a>
                <!--Konta-->
                <a href="../konto" type="button" class="btn btn-warning text-white float-end btn-lg">
                    <img src="../konto.png" style="height:45px;">
                </a>
            </div>
        </div>
    </div>
    <div class="container mb-4 mt-4">
        <div class="row">
            <div class="col-12">
                <?php
                    if(isset($_SESSION['email']))
                    {
                        echo "<h4 class='display-4'>Konto</h4>
                            <p class='mt-4'>Jesteś zalogowany jako <b>".$_SESSION['email']."</b></p>
                            <a href='../zamowienia' type='button' class='btn btn-outline-warning'>Utworzone zamówienia</a>
                            <form action='wyloguj.php' method='post'>
                                <button type='submit' name='wyloguj' class='btn btn-outline-danger mt-3'>Wyloguj się</button>
                            </form>";
                    }
                    else
                    {
                        echo "<h4 class='display-4'>Logowanie</h4>";
                        if(isset($_POST['zaloguj']))
                        {
                            $email=$_POST['email'];
                            $haslo=$_POST['haslo'];
                            $zapytanie=mysqli_query($polaczenie, "SELECT * FROM uzytkownicy WHERE email='$email' AND haslo='$haslo'");
                            $rezultat = mysqli_fetch_array($zapytanie);
                            if(is_array($rezultat))
                            {
                                $_SESSION['email']=$rezultat['email'];
                                $_SESSION['haslo']=$rezultat['haslo'];
                                echo("<meta http-equiv='refresh' content='1'>");
                            }
                            else
                            {
                                echo "<div class='alert alert-danger mt-4'>Nieprawidłowy adres e-mail i/lub hasło!</div>";
                            }
                        }
                        echo "<form action='' method='post' class='was-validated'>
                            <div class='mt-4'>
                                <label for='email' class='form-label'>Adres e-mail:</label>
                                <input type='text' class='form-control' id='email' placeholder='Adres e-mail' name='email' required>
                                <div class='invalid-feedback'>Wypełnij to pole.</div>
                            </div>
                            <div class='mt-3'>
                                <label for='haslo' class='form-label'>Hasło:</label>
                                <input type='password' class='form-control' id='haslo' placeholder='Hasło' name='haslo' required>
                                <div class='invalid-feedback'>Wypełnij to pole.</div>
                            </div>
                            <button type='submit' name='zaloguj' class='btn btn-outline-warning mt-3'>Zaloguj się</button>
                        </form> 
                        <p class='mt-3'>Nie masz konta?<a href='../zarejestruj' type='button' class='btn btn-outline-warning ms-3'>Zarejestruj się</a></p>";
                    }
                    mysqli_close($polaczenie);
                ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>