<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Hotel Database Management</title>
    <link rel="stylesheet" href="style/general.css">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/LinkButoane.css">
</head>

<body>
    <h1>Hotel Database Management</h1>
    <div id="main">
    <div class="blank"></div>
        <div>Conectat la:
        <?php
        if (isset($_POST['Username'])) {
            $user = $_POST['Username'];
            $pass = $_POST['Password'];
        }
        if (empty($user)) {
            echo "Guest";
            echo "</div>";
            echo "<a href='login.html'>Login</a>";
            $user = "user";
            $pass = "pass";
        } else {
            echo $user;
            echo "</div>";
            echo '<a href="index.php">LogOut</a>';
        }

        try {
            $db = new PDO('mysql:host=localhost;dbname=prpaw', $user, $pass);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->exec("CREATE TABLE IF NOT EXISTS angajat (
                        cod_angajat int(11),
                        cnp bigint(13),
                        nume    varchar(50),
                        prenume varchar(50),
                        adresa  varchar(100),
                        telefon int(10),
                        salariu int(10),
                        data_angajare   date,
                        cod_departament int(11)
                        )");




            echo "<h3>Tabela angajat:</h3>";
            echo "<table>";
            echo "<tr>
                <th>cod_angajat</th>
                <th>cnp</th>
                <th>nume</th>
                <th>prenume</th>
                <th>adresa</th>
                <th>telefon</th>
                <th>salariu</th>
                <th>data_angajare</th>
                <th>cod_departament</th>
                <th><button onclick='window.location.href=`insert.php`;'>Insert</button></th>
            </tr>";

            $stmt = $db->query("SELECT * FROM angajat");
            $data = $stmt->fetch();

            if (!$data) {
                $db->exec("INSERT INTO angajat values(1,1234567890123,'nume','prenume','adresa',1234567890,100,'2010-10-10',2)");
                $db->exec("INSERT INTO angajat values(2,1234567890123,'nume','prenume','adresa',1234567890,100,'2010-10-10',2)");
                $db->exec("INSERT INTO angajat values(3,1234567890123,'nume','prenume','adresa',1234567890,100,'2010-10-10',2)");
            }

            if (isset($_POST['nume'])) {
                $stmt = $db->query("SELECT MAX(cod_angajat) FROM angajat");
                $codang = $stmt->fetch();
                $cnp = $_POST['cnp'];
                $nume = $_POST['nume'];
                $prenume = $_POST['prenume'];
                $adresa = $_POST['adresa'];
                $telefon = $_POST['telefon'];
                $salariu = $_POST['salariu'];
                $dataang = $_POST['data_angajare'];
                $coddep = $_POST['cod_departament'];
                $db->exec("INSERT INTO angajat values($codang[0]+1,$cnp,'$nume','$prenume','$adresa',$telefon,$salariu,'$dataang',$coddep)");
                unset($codang);
                unset($cnp);
                unset($nume);
                unset($prenume);
                unset($adresa);
                unset($telefon);
                unset($salariu);
                unset($data_angajare);
                unset($cod_departament);
            }

            if (isset($_POST['codang'])) {
                $codang = $_POST['codang'];
                $stmt = $db->prepare("DELETE FROM angajat WHERE cod_angajat = $codang")->execute();
            }

            if (isset($_POST['edit_cod_angajat']) && $_POST['edit_cod_angajat'] != "") {
                $edit_codangj = " cod_angajat = " . $_POST['edit_cod_angajat'];
            } else {
                $edit_codangj = "";
            }

            if (isset($_POST['edit_cnp']) && $_POST['edit_cnp'] != "") {
                $edit_cnp = " cnp = " . $_POST['edit_cnp'];
            } else {
                $edit_cnp = "";
            }

            if (isset($_POST['edit_nume']) && $_POST['edit_nume'] != "") {
                $edit_nume = " nume = '" . $_POST['edit_nume'] . "'";
            } else {
                $edit_nume = "";
            }

            if (isset($_POST['edit_prenume']) && $_POST['edit_prenume'] != "") {
                $edit_prenume = " prenume = '" . $_POST['edit_prenume'] . "'";
            } else {
                $edit_prenume = "";
            }

            if (isset($_POST['edit_adresa']) && $_POST['edit_adresa'] != "") {
                $edit_adresa = " adresa = '" . $_POST['edit_adresa'] . "'";
            } else {
                $edit_adresa = "";
            }

            if (isset($_POST['edit_telefon']) && $_POST['edit_telefon'] != "") {
                $edit_telefon = " telefon = " . $_POST['edit_telefon'];
            } else {
                $edit_telefon = "";
            }

            if (isset($_POST['edit_salariu']) && $_POST['edit_salariu'] != "") {
                $edit_salariu = " salariu = " . $_POST['edit_salariu'];
            } else {
                $edit_salariu = "";
            }

            if (isset($_POST['edit_data_angajare']) && $_POST['edit_data_angajare'] != "") {
                $edit_data_angajare = " data_angajare = '" . $_POST['edit_data_angajare'] . "'";
            } else {
                $edit_data_angajare = "";
            }

            if (isset($_POST['edit_cod_departament']) && $_POST['edit_cod_departament'] != "") {
                $edit_cod_departament = " cod_departament = " . $_POST['edit_cod_departament'];
            } else {
                $edit_cod_departament = "";
            }

            if (isset($_POST['edit_codang'])) {
                //editeaza coloana
                $codang = $_POST['edit_codang'];
                $stmt = $db->prepare("UPDATE angajat SET" . $edit_codangj . $edit_cnp . $edit_nume . $edit_prenume . $edit_adresa . $edit_telefon . $edit_salariu . $edit_data_angajare . $edit_cod_departament . " WHERE cod_angajat = $codang");
                $stmt->execute();
            }

            $stmt = $db->query("SELECT * FROM angajat");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $codangaj = $row['cod_angajat'];
                echo "<tr>";
                echo "<th>" . $row['cod_angajat'] . "</th>";
                echo "<th>" . $row['cnp'] . "</th>";
                echo "<th>" . $row['nume'] . "</th>";
                echo "<th>" . $row['prenume'] . "</th>";
                echo "<th>" . $row['adresa'] . "</th>";
                echo "<th>" . $row['telefon'] . "</th>";
                echo "<th>" . $row['salariu'] . "</th>";
                echo "<th>" . $row['data_angajare'] . "</th>";
                echo "<th>" . $row['cod_departament'] . "</th>";
                echo "<th><form method='post'>
                <input type='hidden' name = 'codang' value='$codangaj'>
                <input type='submit' value='Delete'>
                </form>
                <form action='edit.php' method='post'>
                <input type='hidden' name = 'codang' value='$codangaj'>
                <input type='submit' class='border' value='Edit'>
                </form></th>";
                echo "</tr>";
            }
            echo "</tr>";
            echo "</table>";
        } catch (PDOException $e) {
            echo '<a href="login.html">Back to login</a>';
            die("\nUnable to connect: " . $e->getMessage());
        }
        ?>
        <div class="blank" />
    </div>
</body>

</html>