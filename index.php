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
                <a class="navbard-brand" href=""><img src="logo.png" class="rounded" style="height:40px;"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#pasek">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="pasek">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="kategorie" role="button" data-bs-toggle="dropdown">Kategorie</a>
                            <ul class="dropdown-menu" aria-labelledby="kategorie">
                                <?php
                                    $polaczenie=@mysqli_connect('localhost', 'root', '', 'duetpapier');
                                    $zapytanie=mysqli_query($polaczenie, "SELECT * FROM kategorie;");
                                    while($rezultat = mysqli_fetch_array($zapytanie))
                                    {
                                        echo "
                                        <li>
                                            <form method='get' action='produkty'>
                                                <button class='dropdown-item' type='submit' name='kategoria' id='kategoria' value='$rezultat[id]'>$rezultat[nazwa]</button>
                                            </form>
                                        </li>
                                        "; 
                                    }
                                    mysqli_close($polaczenie);
                                ?>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="konto">Konto</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="koszyk">Koszyk</a>
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
            <div class="col-12 text-center">
                <img src="banner.png" class="rounded img-fluid mt-3" alt="Banner">
            </div>
            <div class="col-12 mt-5">
                <p class='h5'>Witamy na naszej platformie zamówień!</br>
                Platforma zawiera tylko część naszej oferty, z czasem będziemy ją rozwijać. Jeśli nie znajdziesz szukanego produktu a chcesz go zamówić, dołącz proszę informację w uwagach do zamówienia.</br>
                Pragniemy zaznaczyć, że prezentowana strona jest w formie testów, zauważone błędy można zgłaszać – za co z góry dziękujemy.</p>
            </div>
            <div class="col-12 text-center">
                <img src="firmy.png" class="rounded img-fluid mt-3" alt="Firmy">
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
                        <tr><td>duetpapier@wp.pl</td></tr>
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
                <a href="https://www.google.com/maps/place/Duet+-+Papier+s.c./data=!3m1!4b1!4m2!3m1!1s0x473db38694e3bdf3:0xe8532629f3f7c1e9"><img src="mapa.png" class="rounded img-fluid mt-3" alt="Certyfikat autoryzacyjny"></a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>