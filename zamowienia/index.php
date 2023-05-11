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
    <div class="container mb-4 mt-4">
        <div class="row">   
            <div class="col-12">
                <h4 class="display-4">Utworzone zamówienia</h4>
                <?php
                    $email=$_SESSION['email'];
                    $zapytanie=mysqli_query($polaczenie, "SELECT * FROM zamowienia WHERE email='$email';");
                    $rezultat = mysqli_fetch_array($zapytanie);
                    if(is_array($rezultat))
                    {
                        echo "<table class='table table-hover mt-3'>
                            <thead>
                                <tr><th></th><th>Data utworzenia zamówienia</th><th>Pobierz zamówienie</th><th>Złóż zamówienie</th></tr>
                            </thead>
                            <tbody>";
                        $zapytanie=mysqli_query($polaczenie, "SELECT * FROM zamowienia WHERE email='$email' ORDER BY data DESC;");
                        while($rezultat = mysqli_fetch_array($zapytanie))
                        {
                            echo "<tr>
                                <td><button type='button' class='btn btn-outline-warning btn-sm dropdown-toggle' data-bs-toggle='collapse' data-bs-target='#c$rezultat[id]'></button></td>
                                <td>$rezultat[data]</td>
                                <td><a href='pobierz.php?path=$rezultat[plik]'><button class='btn btn-outline-warning btn-sm'>Pobierz</button></a></td>
                                <td>";
                            if($rezultat['status']==0)
                            {
                                echo "<form method='post' action='wyslij.php'><button type='submit' class='btn btn-outline-warning btn-sm' name='wyslij' value='$rezultat[plik]'>Złóż</button></form>";
                            }
                            else
                            {
                                echo "Złożono!";
                            }
                            echo "</td>
                            </tr>
                            <tr>
                                <td colspan='4'><div id='c$rezultat[id]' class='collapse'><pre>";
                                readfile("C:/zamowienia/$rezultat[plik]");
                                echo "</pre></div></td>
                            </tr>";
                        }
                        echo "</tbody>
                        </table>";
                    }
                    else
                    {
                        echo "<p class='mt-3'>Nie utworzyłeś żadnych zamówień</p>";
                    }
                    mysqli_close($polaczenie);
                ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>