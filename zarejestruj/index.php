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
                <a class="navbard-brand" href=".."><img src="../logo.png" class="rounded" style="height:40px;"></a>
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
    <div class="container mt-4 mb-4">
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
                                $haslos=password_hash($haslo, PASSWORD_DEFAULT);
                                mysqli_query($polaczenie, "INSERT INTO `uzytkownicy` (`id`, `email`, `haslo`, `firma`, `nazwisko`, `imie`, `telefon`, `nip`) VALUES (NULL, '$email', '$haslos', '$firma', '$nazwisko', ' $imie', '$telefon', '$nip');");
                                $_SESSION['email']=$email;
                                echo "<div class='alert alert-success mt-4'>Pomyślnie zarejestrowano i zalogowano</div>";
                            }
                            else
                            {
                                echo "<div class='alert alert-danger mt-4'>Podane hasła nie są identyczne</div>";
                            }
                        }
                    }
                    mysqli_close($polaczenie);
                ?>
                <form action="" class="was-validated" method="post">
                    <div class="mt-4">
                        <label for="email" class="form-label">Adres e-mail:</label>
                        <input type="text" class="form-control" id="email" placeholder="Adres e-mail" name="email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$$">
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
                        <label class="form-check-label" for="myCheck">Wyrażam zgodę na przetwarzanie moich danych osobowych.</label>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Aby się zarejestrować musisz wyrazić zgodę.</div>
                    </div>
                    <button type="submit" name="zarejestruj" class="btn btn-outline-warning mt-3 mb-4">Zarejestruj się</button>
                </form>
                <p><small>
                    <i>Szanowni Państwo</i></br>
                    Uprzejmie informujemy, że od dnia 25.05.2018 roku zacznie obowiązywać Rozporządzenie
                    Parlamentu Europejskiego i Rady (UE) w sprawie ochrony danych osobowych osób
                    fizycznych („RODO”). Ma to na celu zwiększenie bezpieczeństwa Państwa danych
                    osobowych.</br>
                    W związku z powyższym przesyłamy Państwu informacje o zasadach przetwarzania przez
                    nas Państwa danych osobowych, a także przysługujących Państwu prawach w związku z
                    korzystaniem z naszych usług.</br>
                    Prosimy zapoznać się z poniższymi informacjami.</br>

                    <b>1. Kto jest administratorem Państwa danych osobowych</b></br>
                    Administratorem Państwa danych osobowych jest Duet – Papier spółka cywilna</br>
                    ul. Towarowa 29, 38-200 Jasło zwana dalej “Spółką” lub Duet – Papier </br>
                    <b>2. Jak można się z nami skontaktować</b></br>
                    Z administratorem można się kontaktować pisemnie, za pomocą poczty tradycyjnej na adres:</br>
                    ul. Towarowa 29, 38-200 Jasło lub mailem: duetpapier@wp.pl</br>
                    <b>3. Od kogo uzyskaliśmy Twoje dane osobowe?</b></br>
                    Twoje dane osobowe uzyskaliśmy bezpośrednio od Ciebie podczas zakładania konta na platformie zamówień jak i później, podczas korzystania przez Ciebie z panelu zamówień. </br>
                    <b>4. Jaki jest cel i podstawa prawna przetwarzania Państwa danych osobowych</b></br>
                    Jesteśmy uprawnieni do przetwarzania Twoich danych osobowych, ponieważ jest to
                    niezbędne do wykonania zawartej między nami umowy lub wykonania naszych prawnie
                    uzasadnionych interesów, dla celów:</br>
                    • umożliwienia Ci korzystania z usług świadczonych drogą elektroniczną, w tym zapewnienia
                    Ci możliwości pełnego korzystania i aktywacji konta;</br>
                    • umożliwienia Ci założenia i zarządzania Twoim kontem oraz umożliwienie monitorowania
                    zamówień i ich historii,</br>
                    • umożliwienia przeprowadzania i realizacji transakcji w</br>
                    • rozpatrywania oraz obsługi składanych przez Ciebie reklamacji dotyczących usług
                    świadczonych współpracy</br>
                    • obsługi zapytań i zgłoszeń, które do nas kierujesz;</br>
                    • kontaktowania się z Toba w szczególności w celu związanym ze świadczeniem usług;</br>
                    • rozwiązania umowy o świadczenie usług drogą elektroniczną, w tym żądania zamknięcia
                    konta.</br>
                    Przepisy prawa wymagają od nas przetwarzania Twoich danych dla celów podatkowych i
                    rachunkowych. Przetwarzać Twoje dane osobowe możemy również na podstawie prawnie
                    uzasadnionego interesu w celach:</br>
                    • organizacji programów lojalnościowych i konkursów, w których możesz wziąć udział;</br>
                    • zapewnienia bezpieczeństwa i integralności usług, które świadczymy Ci drogą
                    elektroniczną, w tym przeciwdziałania oszustwom i nadużyciom oraz zapewnienia
                    bezpieczeństwa ruchu;</br>
                    • kontaktowania się z Tobą, w tym w celach związanych z dozwolonymi działaniami
                    marketingowymi;</br>
                    • przechowywania danych dla celów archiwalnych, oraz zapewnienia rozliczalności
                    (wykazania spełnienia przez nas obowiązków wynikających z przepisów prawa).</br>
                    Spółka jest uprawniona przetwarzać Twoje dane osobowe na podstawie udzielonej przez
                    Ciebie zgody w celu:</br>
                    • organizacji konkursów, w których możesz wziąć udział (w zależności od rodzaju konkursu);</br>
                    • zapisywania danych w plikach cookie;</br>
                    Zgodę na przetwarzanie danych osobowych, możesz wycofać w dowolnym momencie w ten
                    sam sposób jak ją wyraziłeś. Będziemy przetwarzać Twoje dane osobowe dopóki nie
                    wycofasz zgody.</br>
                    Dane w tych celach przetwarzane będą na podstawie art. 6 ust. 1 lit. b), c) i f)
                    Rozporządzenia Parlamentu Europejskiego i Rady (UE) 2016/679 z dnia 27 kwietnia 2016
                    roku w sprawie ochrony osób fizycznych w związku z przetwarzaniem danych osobowych i w
                    sprawie swobodnego przepływu takich danych oraz uchylenia dyrektywy 95/46/WE (RODO).
                    Po wyrażeniu odrębnej zgody, na podstawie art. 6 ust. 1 lit. a) RODO dane mogą być
                    przetwarzane również w celu przesyłania informacji handlowych drogą elektroniczną lub
                    wykonywania telefonicznych połączeń w celu marketingu bezpośredniego.</br>
                    <b>5. Komu możemy przekazywać Państwa dane osobowe</b></br>
                    Twoje dane nie zostaną przekazane innym podmiotom ani też osobom fizycznym.</br>
                    <b>6. Jak długo będą przechowywane Państwa dane osobowe</b></br>
                    Dane osobowe przetwarzane w celach związanych z realizacją zakupów będą przetwarzane
                    przez okres niezbędny do realizacji zakupów, zapytań i zamówienia lub do czasu
                    zakończenia współpracy, po czym dane podlegające archiwizacji będą przechowywane
                    przez okres właściwy dla przedawnienia roszczeń, tj. 10 lat. Dane osobowe, które
                    przetwarzamy na podstawie podatkowych i rachunkowych przepisów prawnych jesteśmy
                    obowiązani przechowywać przez okres 5 lat po zakończeniu roku, w którym upłynął termin
                    płatności podatku. Dane osobowe przetwarzane w celach marketingowych objętych
                    oświadczeniem zgody będą przetwarzane do czasu odwołania zgody.</br>
                    <b>7. Jakie mają Państwo uprawnienia wobec Spółki w zakresie przetwarzania swoich
                    danych osobowych</b></br>
                    Osoba, której dane dotyczą ma prawo dostępu do treści swoich danych osobowych oraz
                    prawo ich sprostowania, usunięcia, ograniczenia przetwarzania, ma prawo do przenoszenia
                    danych, prawo wniesienia sprzeciwu, prawo do cofnięcia zgody w dowolnym momencie bez
                    wpływu na zgodność z prawem przetwarzania, którego dokonano na podstawie zgody przed
                    jej cofnięciem.</br>
                    W przypadku stwierdzenia, że przetwarzanie danych osobowych narusza przepisy RODO,
                    osoba, której dane dotyczą ma prawo wnieść skargę do Generalnego Inspektora Ochrony
                    Danych Osobowych (po 25 maja 2018 r. – Prezesa Urzędu Ochrony Danych Osobowych).</br>
                    <b>8. W jaki sposób chronimy Państwa dane</b></br>
                    Spółka zobowiązuje się stosować odpowiednie środki techniczne i organizacyjne aby chronić
                    Państwa dane.</br>
                    <b>9. Czy muszą Państwo podać nam swoje dane osobowe</b></br>
                    Podanie danych osobowych jest dobrowolne, jednak podanie danych osobowych warunkiem
                    nawiązania współpracy ze Spółką, złożenia zamówienia składania zamówień na platformie.</br>
                    Konsekwencją ich nie podania będzie brak możliwości składania zamówień przez platformę, nie mniej pozostają inne formy realizacji zamówień poprzez kontakt telefoniczny, mailowy lub osobisty w siedzibie firmy.
                </small></p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>