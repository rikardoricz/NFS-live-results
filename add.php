<?php
$servername = 'localhost';
$username = 'root';
$password = 'password'; /*Bazybazy116*/
$database = 'nfs_wyscigi';

$conn = @new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die('Connection error' . $conn->connect_error);
} else {


    $tryb = isset($_POST['tryb']) ? $_POST['tryb'] : false;
    $mapa = isset($_POST['mapa']) ? $_POST['mapa'] : false;
    $punkty = isset($_POST['punkty']) ? $_POST['punkty'] : false;
    $czas = isset($_POST['czas']) ? $_POST['czas'] : false;
    $gracz = isset($_POST['gracz']) ? $_POST['gracz'] : false;
    // echo $gracz;

    $mapQuery = "SELECT * from `mapy`";
    $userQuery = "SELECT * FROM `gracze`";

    $isEmptyWyscigi = "SELECT * FROM `wyscigi`";
    $wynikWyscigi = $conn->query($isEmptyWyscigi);
    $ile_wierszy = $wynikWyscigi->num_rows;

    $selectedMap = isset($_POST['mapka']) ? $_POST['mapka'] : false;
    // echo $selectedMap;

    if ($ile_wierszy === 0) {
        $resetIncrementation = "ALTER TABLE `wyscigi` AUTO_INCREMENT = 1";
        $reset = $conn->query($resetIncrementation);
    }

    if ($tryb && $mapa && $gracz && ($czas || $punkty)) {

        $mapNameToMapNameQuery = "select id_m, mapy.nazwa as nazwa from mapy inner join tryby on mapy.id_t = tryby.id_t where mapy.nazwa = '" . $selectedMap . "'";
        $stmt = $conn->prepare($mapNameToMapNameQuery);
        $stmt->execute();
        $wynikMapy = $stmt->get_result();

        foreach ($wynikMapy as $row) {

            $idMapy = $row['id_m'];
            $nazwaMapy = $row['nazwa'];
        }

        $insertQuery = "INSERT INTO `wyscigi`(`id_t`,`id_m`,`punkty`,`czas`, `id_g`) VALUES (?,?,?,?,?)";
        $stmtInsert = $conn->prepare($insertQuery);
        $stmtInsert->bind_param("iiisi", $tryb, $idMapy, $punkty, $czas, $gracz);
        $stmtInsert->execute();
        // echo "   dodano   ";
        // echo $tryb . " " . $idMapy . " " . $punkty . " " . $czas . " " . $gracz;
    } else {
    }
    // $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodawanie wyników</title>
    <link rel="stylesheet" href="style-add.css">
    <link rel="icon" href="img/icon.ico" sizes="16x16" type="image/x-icon">
</head>

<body>
    <div id="peja">
        <a class="login" href="index.php">Powrót do logowania</a>
    </div>
    <h1 class="header"><i>Dodawanie wyników wyścigów</i></h1>
    <span id="selectedMap"></span>

    <form action="add.php" id="addForm" method="post">
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
        <!-- <input type="time" step="0.001" id="czas" placeholder="czas" name="czas"> -->
        <select name="gracz" id="gracz">
            <?php
            $wynikGracze = $conn->query($userQuery);
            $ile_wierszy = $wynikGracze->num_rows;
            for ($i = 0; $i < $ile_wierszy; $i++) {
                $wierszGracze = $wynikGracze->fetch_assoc();
                echo '<option value="' . $wierszGracze['id_g'] . '">';
                echo $wierszGracze['nr_stanowiska'] . " " . $wierszGracze['imie'] . " " . $wierszGracze['nazwisko'];
                echo '</option>';
            }

            ?>
        </select>
        <input type="hidden" id="mapka" name="mapka" value="">

        <input id="add" type="submit" name="dodaj" value="dodaj" onclick="preventDefault()">
    </form>

    <span id="info"></span>

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script> -->
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
                if (selectedMode === '4') {
                    $('#czas').remove();
                    $('#mapa').after('<input type="number" id="punkty" placeholder="punkty" name="punkty">').show();
                }
                if (selectedMode != '4') {

                    $('#punkty').remove();
                    if (!$('#czas').length) {
                        $('#mapa').after('<input type="time" step="0.001" id="czas" placeholder="czas" name="czas" min="00:00:00.000" max="00:59:59:999">').show();
                    }
                }


            });

            $("#mapa").change(function() {
                var selectedMap = $(this).find('option:selected').text();
                // $('#selectedMap').text(selectedMap);
                $('#mapka').val(selectedMap);
            });
            $("#mapa").change(function() {
                var length = $(this).length;
                console.log(length);
                if (this.length == length) {
                    $('#mapa option:first').remove();
                }
            });

            // $('#add').click(function() {
            //     if ($('input').val()) {
            //         alert("Dodano wynik do bazy");
            //     } else {
            //         alert("Uzupełnij wszystkie pola!");
            //         return false;
            //     }
            // });
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



            //     $("#gracz").chosen({
            //         no_results_text: "Oops, nothing found!",
            //         max_selected_options: 4
            //     });
            //     $("#gracz").bind("chosen:maxselected", function() {
            //         $("#info").html('Nie można wybrać więcej niż 4 graczy!');
            //     });
        });
    </script>

</body>

</html>
