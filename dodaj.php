<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <?php
        $indeks='';
        $obraz='';
        $nazwa='';
        $jednostka='';
        $opis='';
        $kategoria='';
        if(isset($_POST['indeks']))
        {
            $polaczenie=@mysqli_connect('localhost', 'root', '', 'duetpapier');
            $indeks=$_POST['indeks'];
            $obraz=$_POST['obraz'];
            $nazwa=$_POST['nazwa'];
            $jednostka=$_POST['jednostka'];
            $opis=$_POST['opis'];
            $kategoria=$_POST['kategoria'];
            mysqli_query($polaczenie, "INSERT INTO produkty VALUES ('$indeks', '$kategoria', '$nazwa', '$opis', '$jednostka', '$obraz');");
            echo "<p>Pomyślnie dodano $indeks</p>";
        }
        echo "<form method='post' action='' id='formularz'>
            <p><input type='text' value='$indeks' name='indeks'>Indeks</p>
            <p><input type='text' value='$obraz' name='obraz'>Obraz</p>
            <p><input type='text' value='$nazwa' name='nazwa' style='width: 400px;'>Nazwa</p>
            <p><input type='text' value='$jednostka' name='jednostka'>Jednostka</p>
            <p><input type='text' value='$kategoria' name='kategoria'>Kategoria 1-12</p>
            <p><input type='submit' value='DODAJ'></p>
        </form>
        <textarea name='opis' form='formularz';>$opis</textarea>";
    ?>
</body>
</html>