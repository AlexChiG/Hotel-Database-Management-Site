<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Tabela Angajat</title>
    </head>
    <body>
        <h3>Operatii cu tabela Angajat:</h3>
        <form action="">
            <label for="operatie">Tip operatie:</label>
            <select name="operatie">
                <option value="Select">Select</option>
                <option value="Insert">Insert</option>
                <option value="Update">Update</option>
                <option value="Delete">Delete</option>
                <option value="Drop">Drop</option>
            </select>
          <br><br>
          <label for="conditie">Conditie:</label><br>
            <input type="text" name="conditie" id="conditie">
          <br><br>
            <input type="submit" value="Submit">
          </form>
          <br>
        <a href="../index.php">Back</a>
    </body>
</html>