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
            <?php
                //Wyświetlanie przez kategorię
                if(isset($_GET['kategoria'])&&!empty($_GET['kategoria']))
                {
                    $kategoria = $_GET['kategoria'];
                    $zapytanie=mysqli_query($polaczenie, "SELECT * FROM kategorie WHERE id='$kategoria';");
                    while($rezultat = mysqli_fetch_array($zapytanie))
                    {
                        echo "<h4 class='display-4'>$rezultat[nazwa]</h4>";
                    }
                    $zapytanie=mysqli_query($polaczenie, "SELECT * FROM produkty WHERE kategoria='$kategoria';");
                    while($rezultat = mysqli_fetch_array($zapytanie))
                    {
                        echo "
                        <div class='col-12 col-md-6 col-lg-4 col-xl-3 mt-4'>
                            <h2>$rezultat[nazwa]</h2>
                            <p class='text-primary'>Indeks: $rezultat[indeks]</p>
                            <img class='img-fluid d-block mx-auto' src='$rezultat[obraz]'>
                            <p>$rezultat[opis]</p>
                            <form method='get' action='../koszyk'>
                                <div class='input-group input-group-sm mt-2'>
                                    <input type='number' class='form-control' name='ilosc' id='ilosc' placeholder='Ilość' min='1'>
                                    <span class='input-group-text'>$rezultat[jednostka]</span>
                                    <button type='submit' name='indeks' value='$rezultat[indeks]' class='btn btn-outline-warning'>Dodaj do koszyka</button>
                                </div>
                            </form>
                        </div>";
                    }
                }
                //Wyświetlanie przez wyszukiwanie
                else if(isset($_GET['szukane'])&&!empty($_GET['szukane']))
                {
                    $szukane = $_GET['szukane'];
                    echo "<h4 class='display-4'>Wyszukiwania dla $szukane</h4>";
                    $zapytanie=mysqli_query($polaczenie, "SELECT * FROM produkty WHERE nazwa LIKE '%$szukane%' OR indeks LIKE '%$szukane%';");
                    while($rezultat = mysqli_fetch_array($zapytanie))
                    {
                        echo "
                        <div class='col-12 col-md-6 col-lg-4 col-xl-3 mt-4'>
                            <h2>$rezultat[nazwa]</h2>
                            <p class='text-primary'>Indeks: $rezultat[indeks]</p>
                            <img class='img-fluid d-block mx-auto' src='$rezultat[obraz]'>
                            <p>$rezultat[opis]</p>
                            <form method='get' action='../koszyk'>
                                <div class='input-group input-group-sm mt-2'>
                                    <input type='number' class='form-control' name='ilosc' id='ilosc' placeholder='Ilość' min='1'>
                                    <span class='input-group-text'>$rezultat[jednostka]</span>
                                    <button type='submit' name='indeks' value='$rezultat[indeks]' class='btn btn-outline-warning'>Dodaj do koszyka</button>
                                </div>
                            </form>
                        </div>";
                    }
                }
                //Błąd
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