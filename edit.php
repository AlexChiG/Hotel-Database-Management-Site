<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Edit</title>
    <link rel="stylesheet" href="style/general.css">
    <link rel="stylesheet" href="style/insert.css">
    <link rel="stylesheet" href="style/edit.css">
</head>

<style>
    table,
    th,
    td {
        border: 1px solid black;
    }
</style>

<body>
    <form action="index.php" method="post">
        <table>
            <tr>
                <th>cod_angajat</th>
                <th>cnp</th>
                <th>nume</th>
                <th>prenume</th>
                <th>adresa</th>
                <th>telefon</th>
                <th>salariu</th>
                <th>data_angajare</th>
                <th>cod_departament</th>
            </tr>
            <?php
            try {
                $db = new PDO('mysql:host=localhost;dbname=prpaw', "root", "");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $codang = $_POST['codang'];
                $stmt = $db->query("SELECT * FROM angajat WHERE cod_angajat = '$codang'");
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
                    echo "</tr>";
                }
                echo "</tr>";
            } catch (PDOException $e) {
                echo '<a href="login.html">Back to login</a>';
                die("\nUnable to connect: " . $e->getMessage());
            }
            echo "<input type='hidden' name='edit_codang' value='$codang'>";
            ?>
            <tr>
                <th><input type="text" id="edit_cod_angajat" name="edit_cod_angajat"></th>
                <th><input type="text" id="edit_cnp" name="edit_cnp"></th>
                <th><input type="text" id="edit_nume" name="edit_nume"></th>
                <th><input type="text" id="edit_prenume" name="edit_prenume"></th>
                <th><input type="text" id="edit_adresa" name="edit_adresa"></th>
                <th><input type="text" id="edit_telefon" name="edit_telefon"></th>
                <th><input type="text" id="edit_salariu" name="edit_salariu"></th>
                <th><input type="text" id="edit_data_angajare" name="edit_data_angajare"></th>
                <th><input type="text" id="edit_cod_departament" name="edit_cod_departament"></th>
            </tr>
        </table>
        <br>
        <button type="submit">Commit Changes</button>
        <a href="index.php">Back</a>
    </form>
</body>

</html>