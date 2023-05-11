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
                <h4 class="display-4">Dane konta</h4>
                <?php
                    if(isset($_SESSION['login']))
                    {
                        $login=$_SESSION['login'];
                        if(isset($_POST['zmien']))
                        {
                            $email=$_POST['email'];
                            $imie=$_POST['imie'];
                            $nazwisko=$_POST['nazwisko'];
                            $telefon=$_POST['telefon'];
                            $firma=$_POST['firma'];
                            $nip=$_POST['nip'];
                            mysqli_query($polaczenie, "UPDATE uzytkownicy SET email='$email', firma='$firma', nazwisko='$nazwisko', imie='$imie', telefon='$telefon', nip='$nip' WHERE login='$login';");
                            echo "<div class='alert alert-success mt-4'>Pomyślnie zmieniono dane</div>";
                        }
                        $zapytanie=mysqli_query($polaczenie, "SELECT * FROM uzytkownicy WHERE login='$login';");
                        while($rezultat = mysqli_fetch_array($zapytanie))
                        {
                            echo "
                            <form action='' class='was-validated' method='post'>
                                <div class='mt-4'>
                                    <label for='email' class='form-label'>Adres e-mail:</label>
                                    <input type='text' class='form-control' id='email' placeholder='Adres e-mail' name='email' value='$rezultat[email]' required>
                                    <div class='invalid-feedback'>Wypełnij to pole.</div>
                                </div>
                                <div class='mt-3'>
                                    <label for='imie' class='form-label'>Imię:</label>
                                    <input type='text' class='form-control' id='imie' placeholder='Imię' name='imie' value='$rezultat[imie]' required>
                                    <div class='invalid-feedback'>Wypełnij to pole.</div>
                                </div>
                                <div class='mt-3'>
                                    <label for='nazwisko' class='form-label'>Nazwisko:</label>
                                    <input type='text' class='form-control' id='nazwisko' placeholder='Nazwisko' name='nazwisko' value='$rezultat[nazwisko]' required>
                                    <div class='invalid-feedback'>Wypełnij to pole.</div>
                                </div>
                                <div class='mt-3'>
                                    <label for='telefon' class='form-label'>Numer telefonu:</label>
                                    <input type='text' class='form-control' id='telefon' placeholder='Numer telefonu' name='telefon' value='$rezultat[telefon]' required>
                                    <div class='invalid-feedback'>Wypełnij to pole.</div>
                                </div>
                                <div class='mt-3'>
                                    <label for='firma' class='form-label'>Nazwa firmy:</label>
                                    <input type='text' class='form-control' id='firma' placeholder='Nazwa firmy' name='firma' value='$rezultat[firma]' required>
                                    <div class='invalid-feedback'>Wypełnij to pole.</div>
                                </div>
                                <div class='mt-3'>
                                    <label for='nip' class='form-label'>NIP firmy:</label>
                                    <input type='text' class='form-control' id='nip' placeholder='NIP firmy' name='nip' value='$rezultat[nip]' required>
                                    <div class='invalid-feedback'>Wypełnij to pole.</div>
                                </div>
                                <div class='form-check mt-3'>
                                    <input class='form-check-input' type='checkbox' id='myCheck' name='remember' required>
                                    <label class='form-check-label' for='myCheck'>Zgadzam się na wykorzystywanie podanych danych przez Duet - Papier s.c. w celach kontaktowych.</label>
                                    <div class='valid-feedback'></div>
                                    <div class='invalid-feedback'>Aby zmienić dane konta musisz wyrazić zgodę.</div>
                                </div>
                                <button type='submit' name='zmien' class='btn btn-outline-warning mt-3 mb-4'>Zmień dane</button>
                            </form>";
                        }
                    }
                    else
                    {
                        echo "<div class='alert alert-info mt-4'>Aby zmienić dane konta musisz się zalogować</div>";
                    }
                    mysqli_close($polaczenie);
                ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>