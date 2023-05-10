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
                            mysqli_close($polaczenie);
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
                <h4 class="display-4">Wyszukiwanie</h4>
                <form method='get' action='../produkty'>
                    <div class="input-group mt-4">
                        <input type='text' class='form-control' name='szukane' id='szukane' placeholder='Wpisz nazwę lub indeks produktu' >
                        <button type='submit' class='btn btn-outline-warning'>Wyszukaj</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>