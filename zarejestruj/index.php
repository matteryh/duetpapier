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
                <a class="navbard-brand" href="../glowna"><img src="../logo.png" class="rounded" style="height:40px;"></a>
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
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h4 class="display-4">Rejestracja</h4>
                <?php
                    if(isset($_POST['zarejestruj']))
                    {
                        $email=$_POST['email'];
                        $haslo=$_POST['haslo'];
                        $haslo0=$_POST['haslo0'];
                        $imie=$_POST['imie'];
                        $nazwisko=$_POST['nazwisko'];
                        $telefon=$_POST['telefon'];
                        $firma=$_POST['firma'];
                        $nip=$_POST['nip'];
                        $zapytanie=mysqli_query($polaczenie, "SELECT * FROM uzytkownicy WHERE email='$email'");
                        $rezultat = mysqli_fetch_array($zapytanie);
                        if(is_array($rezultat))
                        {
                            echo "<div class='alert alert-danger mt-4'>Podany adres e-mail już jest używany</div>";
                        }
                        else
                        {
                            if($haslo==$haslo0)
                            {
                                mysqli_query($polaczenie, "INSERT INTO `uzytkownicy` (`id`, `email`, `haslo`, `firma`, `nazwisko`, `imie`, `telefon`, `nip`) VALUES (NULL, '$email', '$haslo', '$firma', '$nazwisko', ' $imie', '$telefon', '$nip');");
                                $_SESSION['email']=$email;
                                $_SESSION['haslo']=$haslo;
                                echo "<div class='alert alert-success mt-4'>Pomyślnie zarejestrowano i zalogowano</div>";
                            }
                            else
                            {
                                echo "<div class='alert alert-danger mt-4'>Podane hasła nie są takie same</div>";
                            }
                        }
                    }
                    mysqli_close($polaczenie);
                ?>
                <form action="" class="was-validated" method="post">
                    <div class="mt-4">
                        <label for="email" class="form-label">Adres e-mail:</label>
                        <input type="text" class="form-control" id="email" placeholder="Adres e-mail" name="email" required>
                        <div class="invalid-feedback">Wypełnij to pole.</div>
                    </div>
                    <div class="mt-3">
                        <label for="haslo" class="form-label">Hasło:</label>
                        <input type="password" class="form-control" id="haslo" placeholder="Hasło" name="haslo" required>
                        <div class="invalid-feedback">Wypełnij to pole.</div>
                    </div>
                    <div class="mt-3">
                        <label for="haslo0" class="form-label">Potwierdź (powtórz) hasło:</label>
                        <input type="password" class="form-control" id="haslo0" placeholder="Potwierdź hasło" name="haslo0" required>
                        <div class="invalid-feedback">Wypełnij to pole.</div>
                    </div>
                    <div class="mt-3">
                        <label for="imie" class="form-label">Imię:</label>
                        <input type="text" class="form-control" id="imie" placeholder="Imię" name="imie" required>
                        <div class="invalid-feedback">Wypełnij to pole.</div>
                    </div>
                    <div class="mt-3">
                        <label for="nazwisko" class="form-label">Nazwisko:</label>
                        <input type="text" class="form-control" id="nazwisko" placeholder="Nazwisko" name="nazwisko" required>
                        <div class="invalid-feedback">Wypełnij to pole.</div>
                    </div>
                    <div class="mt-3">
                        <label for="telefon" class="form-label">Numer telefonu:</label>
                        <input type="text" class="form-control" id="telefon" placeholder="Numer telefonu" name="telefon" required>
                        <div class="invalid-feedback">Wypełnij to pole.</div>
                    </div>
                    <div class="mt-3">
                        <label for="firma" class="form-label">Nazwa firmy:</label>
                        <input type="text" class="form-control" id="firma" placeholder="Nazwa firmy" name="firma" required>
                        <div class="invalid-feedback">Wypełnij to pole.</div>
                    </div>
                    <div class="mt-3">
                        <label for="nip" class="form-label">NIP firmy:</label>
                        <input type="text" class="form-control" id="nip" placeholder="NIP firmy" name="nip" required>
                        <div class="invalid-feedback">Wypełnij to pole.</div>
                    </div>
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" id="myCheck" name="remember" required>
                        <label class="form-check-label" for="myCheck">Zgadzam się na wykorzystywanie podanych danych przez Duet - Papier s.c. w celach kontaktowych.</label>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Aby się zarejestrować musisz wyrazić zgodę.</div>
                    </div>
                    <button type="submit" name="zarejestruj" class="btn btn-outline-warning mt-3 mb-4">Zarejestruj się</button>
                </form>     
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>