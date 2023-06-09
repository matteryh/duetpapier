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
                            <a class="nav-link dropdown-toggle active" href="#" id="kategorie" role="button" data-bs-toggle="dropdown">Kategorie</a>
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
                            <a class="nav-link" href="../konto">Konto</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../koszyk">Koszyk</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://drive.google.com/file/d/1kxkXz4hvwu61drGq7_A1LlD6wMdKWTXU/view?fbclid=IwAR1eeNuJlsiHI4D4WXNefFuOs58uT2kL5vNZ1FFlINqCn17HJBbnz6ScsKM">Katalog</a>
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
            <?php    
                if(isset($_POST['indeks'])&&!empty($_POST['ilosc'])&&$_POST['ilosc']!=0)
				{
                    if(isset($_SESSION['email']))
                    {
                        $email=$_SESSION['email'];
                        $indeks=$_POST['indeks'];
                        $ilosc=$_POST['ilosc'];
                        $zapytanie=mysqli_query($polaczenie, "SELECT * FROM koszyk WHERE email='$email' AND indeks='$indeks';");
                        $rezultat = mysqli_fetch_array($zapytanie);
                        if(is_array($rezultat))
                        {
                            $zapytanie=mysqli_query($polaczenie, "SELECT * FROM koszyk WHERE email='$email' AND indeks='$indeks';");
                            $suma=$ilosc+$rezultat['ilosc'];
                            mysqli_query($polaczenie, "UPDATE koszyk SET ilosc = '$suma' WHERE email='$email' AND indeks = '$indeks';");
                        }
                        else
                        {
                            mysqli_query($polaczenie, "INSERT INTO koszyk (`id`, `email`, `indeks`, `ilosc`) VALUES (NULL, '$email', '$indeks', '$ilosc');");
                        }
                    }
                    else
                    {
                        echo "<script>alert('Nie jesteś zalogowany. Aby dodawać produkty do koszyka musisz się zalogować');</script>";
                    }
				}
                if((isset($_GET['kategoria'])&&!empty($_GET['kategoria']))or(isset($_GET['szukane'])&&!empty($_GET['szukane'])))
                {
                    if(isset($_GET['kategoria'])&&!empty($_GET['kategoria']))
                    {
                        $kategoria = $_GET['kategoria'];
                        $zapytanie=mysqli_query($polaczenie, "SELECT * FROM kategorie WHERE id='$kategoria';");
                        while($rezultat = mysqli_fetch_array($zapytanie))
                        {
                            echo "<h4 class='display-4'>$rezultat[nazwa]</h4>";
                        }
                        $zapytanie=mysqli_query($polaczenie, "SELECT * FROM produkty WHERE kategoria='$kategoria';");
                    }
                    else if(isset($_GET['szukane'])&&!empty($_GET['szukane']))
                    {
                        $szukane = $_GET['szukane'];
                        echo "<h4 class='display-4'>Wyszukiwania dla $szukane</h4>";
                        $zapytanie=mysqli_query($polaczenie, "SELECT * FROM produkty WHERE nazwa LIKE '%$szukane%' OR indeks LIKE '%$szukane%';");
                    }
                    while($rezultat = mysqli_fetch_array($zapytanie))
                    {
                        echo "
                        <div class='col-12 col-md-6 col-lg-4 col-xl-3 mt-4 d-flex flex-wrap' id='form-anchor$rezultat[indeks]'>
                            <div class='w-100'>
                                <h2>$rezultat[nazwa]</h2>
                                <p class='text-primary'>Indeks: $rezultat[indeks]</p>
                                
                                <div class='modal' id='a$rezultat[indeks]'>
                                    <div class='modal-dialog'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h4 class='modal-title'>$rezultat[nazwa]</h4>
                                                <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                            </div>
                                            <div class='modal-body'>
                                                <p class='text-primary'>Indeks: $rezultat[indeks]</p>
                                                $rezultat[opis]
                                            </div>
                                            <div class='modal-footer'>
                                                <button type='button' class='btn btn-outline-danger' data-bs-dismiss='modal'>Zamknij opis</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='d-flex flex-wrap align-content-end w-100'>
                                <img class='img-fluid d-block mx-auto' src='img/$rezultat[obraz].png' style='max-height: 250px;'>
                                <div class='d-grid w-100 mt-1'>
                                    <button type='button' class='btn btn-sm btn-outline-warning btn-block mb-2' data-bs-toggle='modal' data-bs-target='#a$rezultat[indeks]'>Opis</button>
                                </div>
                                <form method='post' action='#form-anchor$rezultat[indeks]' class='input-group input-group-sm'>
                                    <input type='number' class='form-control' name='ilosc' id='ilosc' placeholder='Ilość' min='1' value='1'>
                                    <span class='input-group-text'>$rezultat[jednostka]</span>
                                    <button type='submit' name='indeks' value='$rezultat[indeks]' class='btn btn-outline-warning'>Dodaj do koszyka</button>
                                </form>
                            </div>
                        </div>";
                    }
                }
                else
                {
                    echo "<div class='alert alert-info'>Wybierz grupę asortymentową lub wyszukaj produkt</div>";
                }
                mysqli_close($polaczenie);
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>