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