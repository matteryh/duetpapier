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
                            <a class="nav-link dropdown-toggle" href="#" id="kategorie" role="button" data-bs-toggle="dropdown">Kategorie</a>
                            <ul class="dropdown-menu" aria-labelledby="kategorie">
                                <?php
                                    session_start();
                                    $polaczenie=@mysqli_connect('localhost', 'root', '', 'duetpapier');
                                    if(!empty($_GET)){
                                        header('Location: ' . basename(__FILE__));
                                        header('Location: ./');
                                    }
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
                            <a class="nav-link active" href="../koszyk">Koszyk</a>
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
            <div class="col-12">
				<h4 class='display-4'>Koszyk</h4>
				<?php
                    if(isset($_SESSION['email']))
                    {
						$email=$_SESSION['email'];
                        if(isset($_POST['zmiana']))
						{
							$zmiana=$_POST['zmiana'];
                            $ilosc=$_POST['ilosc'];
							mysqli_query($polaczenie, "UPDATE koszyk SET ilosc='$ilosc' WHERE email='$email' AND indeks = '$zmiana';");
						}
						if(isset($_POST['usun']))
						{
							$usun=$_POST['usun'];
							mysqli_query($polaczenie, "DELETE FROM koszyk WHERE email='$email' AND indeks='$usun';");
						}
						if(isset($_POST['usunwszystko']))
						{
							mysqli_query($polaczenie, "DELETE FROM koszyk WHERE email='$email';");
						}
						if(isset($_POST['utworz']))
						{
							$plik=$email.date("Y-m-d-H-i-s").".txt";
                            $data=date("Y-m-d H:i:s");
                            $myfile=fopen("$plik", "a") or die("Nie można otworzyć pliku!");
                            $zapytanie=mysqli_query($polaczenie, "SELECT * FROM uzytkownicy WHERE email='$email';");
							while($rezultat = mysqli_fetch_array($zapytanie))
                            {
                                $txt="\tDATA UTWORZENIA ZAMÓWIENIA
".date("Y-m-d")."\n
\tDANE ZAMAWIAJĄCEGO
Imię: $rezultat[imie]
Nazwisko: $rezultat[nazwisko]
Nazwa firmy: $rezultat[firma]
NIP firmy: $rezultat[nip]
Adres e-mail: $rezultat[email]
Numer telefonu: $rezultat[telefon]\n
Lp.\tIndeks\tIlość\tJ.m.\tNazwa
------------------------------------------------------------------------------------------------------------------------\n";
                                fwrite($myfile, $txt);
                            }
                            $lp=1;
                            $zapytanie=mysqli_query($polaczenie, "SELECT koszyk.indeks, ilosc, nazwa, jednostka FROM koszyk, produkty WHERE email='$email' AND koszyk.indeks=produkty.indeks;");
							while($rezultat = mysqli_fetch_array($zapytanie))
                            {
                                $txt="$lp\t$rezultat[indeks]\t$rezultat[ilosc]\t$rezultat[jednostka]\t$rezultat[nazwa]\n";
                                fwrite($myfile, $txt);
                                $lp+=1;
                            }
                            fclose($myfile);
                            mysqli_query($polaczenie, "INSERT INTO `zamowienia` VALUES (NULL, '$email', '$data', '$plik', 0) ;");
                            rename("$plik", "C:/zamowienia/$plik");
                            mysqli_query($polaczenie, "DELETE FROM koszyk WHERE email='$email';");
                            echo "<div class='alert alert-success mt-4'>Utworzono zamówienie. Możesz je zobaczyć i złożyć w zakładce <a href='../zamowienia'>Utworzone zamówienia</a></div>";
						}
						$zapytanie=mysqli_query($polaczenie, "SELECT * FROM koszyk WHERE email='$email';");
                        $rezultat = mysqli_fetch_array($zapytanie);
						if(is_array($rezultat))
						{
							echo "<table class='table table-striped mt-4'><thead><tr><th>Indeks</th><th>Nazwa</th><th>Ilość</th><th>Usuń</th></tr></thead><tbody>";
							$zapytanie=mysqli_query($polaczenie, "SELECT koszyk.indeks, ilosc, nazwa, jednostka FROM koszyk, produkty WHERE email='$email' AND koszyk.indeks=produkty.indeks;");
							while($rezultat = mysqli_fetch_array($zapytanie))
							{
								echo "<tr>
                                <td>$rezultat[indeks]</td>
                                <td>$rezultat[nazwa]</td>
                                <td><form method='post' action=''><div class='input-group input-group-sm'><input type='number' class='form-control' name='ilosc' value='$rezultat[ilosc]' min='1'><span class='input-group-text'>$rezultat[jednostka]</span><button type='submit' name='zmiana' value='$rezultat[indeks]' class='btn btn-outline-warning btn-sm'>Zmień</button></span></form></td>
                                <td><form method='post' action=''><button type='submit' name='usun' value='$rezultat[indeks]' class='btn btn-outline-danger btn-sm'>Usuń</button></form></td>
                                </tr>";
							}
							echo "</tbody></table>
                            <form method='post' action=''><button type='submit' name='usunwszystko' class='btn btn-outline-danger float-start mt-4'>Usuń całą zawartość koszyka</button></form>
							<form method='post' action=''><button type='submit' name='utworz' class='btn btn-outline-warning float-end mt-4'>Utwórz zamówienie</button></form>";
						}
						else
						{
							echo "<div class='alert alert-info mt-4'>Nie masz żadnych produktów w koszyku</div>";
						}
					}
					else
					{
						echo "<div class='alert alert-info mt-4'>Aby dodawać produkty do koszyka musisz się zalogować</div>";
					}
                    mysqli_close($polaczenie);
				?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>