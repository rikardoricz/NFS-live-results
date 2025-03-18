<?php
$servername = 'localhost';
$username = 'root';
$password = 'password'; /*Bazybazy116*/
$database = 'nfs_wyscigi';

$conn = @new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die('Connection error' . $conn->connect_error);
} else {
    $noResults = 'Aby zobaczyć top 10 na danej mapie wybierz tryb, a następnie mapę.';
    $wyscigiQuery = "SELECT * FROM `wyscigi`";
    // $resultQuery .= "inner join tryby on wyscigi.id_t=tryby.id_t";
    // $resultQuery .= "inner join mapy on wyscigi.id_m=mapy.id_m";
    $wynikWierszy = $conn->query($wyscigiQuery);
    $ile_wierszy = $wynikWierszy->num_rows;
    if ($ile_wierszy === 0) {
        $noResults = "Brak wyników dla danej mapy!";
    } else {
        // $resultQuery = "select nr_stanowiska, imie, nazwisko, tryby.nazwa as tryb, mapy.nazwa as mapa, punkty, czas from `wyscigi` inner join gracze on wyscigi.id_g=gracze.id_g inner join tryby on wyscigi.id_t=tryby.id_t inner join mapy on wyscigi.id_m=mapy.id_m order by czas asc;";
        // $wynik = $conn->query($resultQuery);
        // $table = '<table class="wyniki">';
        // $table .= '<tr><th class="th1">L.p.</th><th class="th1">Nr stanowiska</th><th class="th1">Gracz</th><th class="th1">Tryb</th><th class="th1">Mapa</th><th class="th1">Punkty</th><th class="th1">Czas</th></tr>';
        // for ($i = 0; $i < $ile_wierszy; $i++) {
        //     $j = $i + 1;
        //     $wiersz = $wynik->fetch_assoc();
        //     if ($wiersz['czas'] == '00:00:00.000000') $wiersz['czas'] = 'n/a';
        //     if ($wiersz['punkty'] == 0) $wiersz['punkty'] = 'n/a';
        //     $table .= '<tr>';
        //     $table .= '<td class="td1">' . $j . '</td>';
        //     $table .= '<td class="td1">' . $wiersz['nr_stanowiska'] . '</td>';
        //     $table .= '<td class="td1">' . $wiersz['imie'] . " " . $wiersz['nazwisko'] . '</td>';
        //     $table .= '<td class="td1">' . $wiersz['tryb'] . '</td>';
        //     $table .= '<td class="td1">' . $wiersz['mapa'] . '</td>';
        //     $table .= '<td class="td1">' . $wiersz['punkty'] . '</td>';
        //     $table .= '<td class="td1">' . $wiersz['czas'] . '</td>';
        //     $table .= '</tr>';
        // }
        // $table .= '</table>';

        $bestQuery = "select nr_stanowiska, imie, nazwisko, tryby.nazwa as tryb, mapy.nazwa as mapa, punkty, czas from `wyscigi` inner join gracze on wyscigi.id_g=gracze.id_g inner join tryby on wyscigi.id_t=tryby.id_t inner join mapy on wyscigi.id_m=mapy.id_m order by nazwisko LIMIT 10;";
        $wynikWierszy1 = $conn->query($bestQuery);
        $ile_wierszy1 = $wynikWierszy1->num_rows;
        $wynikTop = $conn->query($bestQuery);
        if ($ile_wierszy1 != 0)
        $table1 = '<table class="wyniki">';
        $table1 .= '<tr><th class="th1">L.p.</th><th class="th1">Nr stanowiska</th><th class="th1">Gracz</th><th class="th1">Tryb</th><th class="th1">Mapa</th><th class="th1">Punkty</th><th class="th1">Czas</th></tr>';
        for ($i = 0; $i < $ile_wierszy1; $i++) {
            $j = $i + 1;
            $wiersz = $wynikTop->fetch_assoc();
            if ($wiersz['czas'] == '00:00:00.000000') $wiersz['czas'] = 'n/a';
            if ($wiersz['punkty'] == 0) $wiersz['punkty'] = 'n/a';
            $table1 .= '<tr>';
            $table1 .= '<td class="td1">' . $j . '</td>';
            $table1 .= '<td class="td1">' . $wiersz['nr_stanowiska'] . '</td>';
            $table1 .= '<td class="td1">' . $wiersz['imie'] . " " . $wiersz['nazwisko'] . '</td>';
            $table1 .= '<td class="td1">' . $wiersz['tryb'] . '</td>';
            $table1 .= '<td class="td1">' . $wiersz['mapa'] . '</td>';
            $table1 .= '<td class="td1">' . $wiersz['punkty'] . '</td>';
            $table1 .= '<td class="td1">' . $wiersz['czas'] . '</td>';
            $table1 .= '</tr>';
        }
        $table1 .= '</table>';

        $tryb = isset($_POST['tryb']) ? $_POST['tryb'] : false;
        $mapa = isset($_POST['mapa']) ? $_POST['mapa'] : false;
        // echo $gracz;

        $mapQuery = "SELECT * from `mapy`";
        $userQuery = "SELECT * FROM `gracze`";

        $selectedMap = isset($_POST['mapka']) ? $_POST['mapka'] : false;
        $table2 = '';
        // echo $selectedMap;



        
        
        
        if (!empty($_POST['filtruj'])) {
            
            $mapNameToMapNameQuery = "select id_m, mapy.nazwa as nazwa from mapy inner join tryby on mapy.id_t = tryby.id_t where mapy.nazwa = '" . $selectedMap . "'";
            $stmt = $conn->prepare($mapNameToMapNameQuery);
            $stmt->execute();
            $wynikMapy = $stmt->get_result();

            foreach ($wynikMapy as $row) {

                $idMapy = $row['id_m'];
                $nazwaMapy = $row['nazwa'];
            }
            if (isset($nazwaMapy)) {
                $top10Query = "select nr_stanowiska, imie, nazwisko, tryby.nazwa as tryb, mapy.nazwa as mapa, punkty, czas from `wyscigi` inner join gracze on wyscigi.id_g=gracze.id_g inner join tryby on wyscigi.id_t=tryby.id_t inner join mapy on wyscigi.id_m=mapy.id_m where mapy.nazwa = '" . $nazwaMapy . "' order by punkty,czas LIMIT 10";
                $wynikWierszy2 = $conn->query($top10Query);
                $ile_wierszy2 = $wynikWierszy2->num_rows;
                // $top10Query .= " LIMIT " . $ile_wierszy2;
                // echo $top10Query;
                $wynikTop10Mapa = $conn->query($top10Query);
                $table2 = '<table class="wyniki">';
                $table2 .= '<tr><th class="th1">L.p.</th><th class="th1">Nr stanowiska</th><th class="th1">Gracz</th><th class="th1">Tryb</th><th class="th1">Mapa</th><th class="th1">Punkty</th><th class="th1">Czas</th></tr>';
                if ($ile_wierszy2 == 0) {
                    $noResults = "Brak wyników dla danej mapy!";
                } else {
                    $noResults = '';
                    for ($i = 0; $i < $ile_wierszy2; $i++) {
                        $j = $i + 1;
                        $wiersz = $wynikTop10Mapa->fetch_assoc();
                        if ($wiersz['czas'] == '00:00:00.000000') $wiersz['czas'] = 'n/a';
                        if ($wiersz['punkty'] == 0) $wiersz['punkty'] = 'n/a';
                        $table2 .= '<tr>';
                        $table2 .= '<td class="td1">' . $j . '</td>';
                        $table2 .= '<td class="td1">' . $wiersz['nr_stanowiska'] . '</td>';
                        $table2 .= '<td class="td1">' . $wiersz['imie'] . " " . $wiersz['nazwisko'] . '</td>';
                        $table2 .= '<td class="td1">' . $wiersz['tryb'] . '</td>';
                        $table2 .= '<td class="td1">' . $wiersz['mapa'] . '</td>';
                        $table2 .= '<td class="td1">' . $wiersz['punkty'] . '</td>';
                        $table2 .= '<td class="td1">' . $wiersz['czas'] . '</td>';
                        $table2 .= '</tr>';
                    }
                    $table2 .= '</table>';
                }
            } else {
                $noResults = "Nie wybrano trybu i mapy!";
            }
            // $top10Query = "select nr_stanowiska, imie, nazwisko, tryby.nazwa as tryb, mapy.nazwa as mapa, punkty, czas from `wyscigi` inner join gracze on wyscigi.id_g=gracze.id_g inner join tryby on wyscigi.id_t=tryby.id_t inner join mapy on wyscigi.id_m=mapy.id_m where mapy.nazwa = '". $selectedMap. "' order by punkty desc LIMIT 10;";
            
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strona wyników</title>
    <link rel="icon" href="img/icon.ico" sizes="16x16" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <!-- <link rel="stylesheet" href="style-results.css"> -->
</head>

<body>
    <div id="peja">
        <a class="login" href="index.php">Powrót do logowania</a>
    </div>
    <form action="results.php" method="post">
        <select name="tryb" id="tryb">
            <option value="">Wybierz tryb</option>
            <option value="1">tor</option>
            <option value="2">sprint</option>
            <option value="3">drag</option>
            <option value="4">drift</option>
        </select>
        <select name="mapa" id="mapa">
            <option value="">Wybierz mapę</option>
            <?php
            $wynik = $conn->query($mapQuery);
            $ile_wierszy = $wynik->num_rows;
            for ($i = 0; $i < $ile_wierszy; $i++) {
                $wiersz = $wynik->fetch_assoc();
                echo '<option value="' . $wiersz['id_t'] . '">';
                echo $wiersz['nazwa'];
                echo '</option>';
            }

            ?>
        </select>
        <input id="filter" type="submit" name="filtruj" value="filtruj">
        <input type="hidden" id="mapka" name="mapka" value="">
    </form>
    

    <div id="tabelaTop10">
        <h1 class="tableHeader"><i>Top 10</i></h1>
        <span id="info"><p> <?php echo $noResults ?></p></span>
        <?php
        
        echo $table2;
        ?>
    </div>
    <div id="mainTabela">
        <h1 class="tableHeader"><i>Wszystkie wyniki</i></h1>
        <?php
        echo $table1;
        ?>
    </div>




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
    <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet" />
    <script>
        $(document).ready(function() {
            $("#tryb").change(function() {
                if ($(this).data('options') === undefined) {
                    /*Taking an array of all options-2 and kind of embedding it on the select1*/
                    $(this).data('options', $('#mapa option').clone());
                }
                var id = $(this).val();
                var options = $(this).data('options').filter('[value=' + id + ']');
                $('#mapa').html(options);

            });

            $("#tryb").change(function() {
                var selectedMode = $(this).val();
                if (this.length == 5) {
                    $('#tryb option:first').remove();
                }
            });
            $("#mapa").change(function() {
                var selectedMap = $(this).val();
                var length = $(this).length;
                console.log(length);
                if (this.length == length) {
                    $('#mapa option:first').remove();
                }
            });

            $("#mapa").change(function() {
                var selectedMap = $(this).find('option:selected').text();
                // $('#selectedMap').text(selectedMap);
                $('#mapka').val(selectedMap);
            });

            $('#mapa').focus(function() {
                $(this).toggleClass('selectBorder');
            });
            $('#mapa').blur(function() {
                $(this).toggleClass('selectBorder');
            });
            $('#tryb').focus(function() {
                $(this).toggleClass('selectBorder');
            });
            $('#tryb').blur(function() {
                $(this).toggleClass('selectBorder');
            });

        });
    </script>
    <script>
        setInterval(function() {
            location.reload();
        }, 5000);
    </script>

</body>

</html>
