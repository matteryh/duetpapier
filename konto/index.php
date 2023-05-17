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
        <nav class="navbar navbar-expand-sm navbar-light bg-warning">
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
                            <a class="nav-link active" href="../konto">Konto</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../koszyk">Koszyk</a>
                        </li>
                    </ul>
                    <form method='get' action='../produkty'>
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
                <?php
                    if(isset($_SESSION['email']))
                    {
                        echo "<h4 class='display-4'>Konto</h4>
                            <p class='mt-4'>Jesteś zalogowany jako <b>".$_SESSION['email']."</b></p>
                            <p><a href='../dane' type='button' class='btn btn-outline-warning'>Dane konta</a></p>
                            <p><a href='../zamowienia' type='button' class='btn btn-outline-warning'>Utworzone zamówienia</a><p>
                            <form action='wyloguj.php' method='post'>
                                <button type='submit' name='wyloguj' class='btn btn-outline-danger'>Wyloguj się</button>
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
                                echo("<meta http-equiv='refresh' content='1'>");
                            }
                            else
                            {
                                echo "<div class='alert alert-danger mt-4'>Nieprawidłowy adres email i/lub hasło!</div>";
                            }
                        }
                        echo "<form action='' method='post' class='was-validated'>
                            <div class='mt-4'>
                                <label for='email' class='form-label'>Adres e-mail:</label>
                                <input type='text' class='form-control' id='email' placeholder='email' name='email' required>
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