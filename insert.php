<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Insert</title>
    <link rel="stylesheet" href="style/general.css">
    <link rel="stylesheet" href="style/insert.css">
    <link rel="stylesheet" href="style/LinkButoane.css">
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
                <th>cnp</th>
                <th>nume</th>
                <th>prenume</th>
                <th>adresa</th>
                <th>telefon</th>
                <th>salariu</th>
                <th>data_angajare</th>
                <th>cod_departament</th>
            </tr>
            <tr>
                <th><input type="text" id="cnp" name="cnp"></th>
                <th><input type="text" id="nume" name="nume"></th>
                <th><input type="text" id="prenume" name="prenume"></th>
                <th><input type="text" id="adresa" name="adresa"></th>
                <th><input type="text" id="telefon" name="telefon"></th>
                <th><input type="text" id="salariu" name="salariu"></th>
                <th><input type="text" id="data_angajare" name="data_angajare"></th>
                <th><input type="text" id="cod_departament" name="cod_departament"></th>
            </tr>
        </table>
        <button type="submit">Insert into table</button>
        <a href="index.php">Back</a>
    </form>
</body>

</html>