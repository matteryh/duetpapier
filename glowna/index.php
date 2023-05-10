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
            <div class="col-12 text-center">
                <h1 class="display-1"><b><i>Duet - Papier s.c.</i></b></h1>
                <h2>Hurtownia Artykułów Biurowych w Jaśle</h2>
                <img src="../certyfikat.png" class="rounded img-fluid mt-3" alt="Certyfikat autoryzacyjny">
            </div>
        </div>
        <div class="row mt-4 mb-4">
            <div class="col-md-4">
                <h6 class="display-6">Kontakt</h6>
                <table class="table">
                    <tbody>
                        <tr><td>13 446 83 31</td></tr>
                        <tr><td>602 705 798</td></tr>
                        <tr><td>880 223 630</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <h6 class="display-6">Adres</h6>
                <table class="table">
                    <tbody>
                        <tr><td>Towarowa 29</td></tr>
                        <tr><td>38-200 Jasło</td></tr>
                        <tr><td>Polska</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <h6 class="display-6">Godziny otwarcia</h6>
                <table class="table">
                    <tbody>
                        <tr><td>pon.:</td><td>08:00-16:00</td></tr>
                        <tr><td>wt.:</td><td>08:00-16:00</td></tr>
                        <tr><td>śr.:</td><td>08:00-16:00</td></tr>
                        <tr><td>czw.:</td><td>08:00-16:00</td></tr>
                        <tr><td>pt.:</td><td>08:00-16:00</td></tr>
                        <tr><td>sob.:</td><td>Zamknięte</td></tr>
                        <tr><td>niedz.:</td><td>Zamknięte</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="col-12 text-center">
                <a href="https://www.google.com/maps/place/Duet+-+Papier+s.c./data=!3m1!4b1!4m2!3m1!1s0x473db38694e3bdf3:0xe8532629f3f7c1e9"><img src="../mapa.png" class="rounded img-fluid mt-3" alt="Certyfikat autoryzacyjny"></a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>