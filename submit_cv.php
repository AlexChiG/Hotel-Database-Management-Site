<?php
  //lab3
class CV{
    private $nume;
    private $prenume;
    private $telefon;
    private $email;
    private $adresa;
    private $educatie;
    private $experienta;


    public function __construct($nume, $prenume, $telefon, $email, $adresa) {
        $this->nume = $nume;
        $this->prenume = $prenume;
        $this->telefon = $telefon;
        $this->email = $email;
        $this->adresa = $adresa;
        $this->educatie = array();
        $this->experienta = array();
      }
      public function setNume($nume) {
        $this->nume = $nume;
      }
    
      public function getNume() {
        return $this->nume;
      }
    
      public function setPrenume($prenume) {
        $this->prenume = $prenume;
      }
    
      public function getPrenume() {
        return $this->prenume;
      }
    
      public function setTelefon($telefon) {
        $this->telefon = $telefon;
      }
    
      public function getTelefon() {
        return $this->telefon;
      }
    
      public function setEmail($email) {
        $this->email = $email;
      }
    
      public function getEmail() {
        return $this->email;
      }

      public function setAdresa($adresa) {
        $this->adresa = $adresa;
      }
    
      public function getAdresa() {
        return $this->adresa;
      }
    
      public function adaugaEducatie($liceu,$facultate,$master) {
        $educatie = array(
          'liceu' => $liceu,
          'facultate' => $facultate,
          'master' => $master
        );
        array_push($this->educatie, $educatie);
      }
    
      public function getEducatie() {
        return $this->educatie;
      }
    
      public function adaugaExperienta($companie, $pozitie, $perioada) {
        $experienta = array(
          'companie' => $companie,
          'pozitie' => $pozitie,
          'perioada' => $perioada
        );
        array_push($this->experienta, $experienta);
      }

      public function getExperienta() {
        return $this->experienta;
      }
    }

    $cv = new CV($_POST['nume'], $_POST['prenume'], $_POST['telefon'], $_POST['email'],$_POST['adresa']);

    $cv->adaugaEducatie($_POST['liceu'], $_POST['facultate'], $_POST['master']);

    $cv->adaugaExperienta($_POST['companie'], $_POST['pozitie'], $_POST['perioada']);

    echo "<strong>Date Personale:</strong><br>";
    echo "- Nume: " . $cv->getNume() . "<br>";
    echo "- Prenume: " . $cv->getPrenume() . "<br>";
    echo "- Telefon: " . $cv->getTelefon() . "<br>";
    echo "- Email: " . $cv->getEmail() . "<br>";
    echo "- Adresa:" . $cv->getAdresa() . "<br>";

    echo "<br><strong>Educatie:</strong><br>";
    $educatie = $cv->getEducatie();
    foreach ($educatie as $item) {
    echo "- Liceu: " . $item['liceu'] . "<br> - Facultate: " . $item['facultate'] . "<br> - Master: " . $item['master'] . "<br>";
    }

    echo "<br><strong>Experienta:</strong><br>";
    $experienta = $cv->getExperienta();
    foreach ($experienta as $item) {
    echo "- Companie: " . $item['companie'] . "<br> - Pozitie: " . $item['pozitie'] . "<br> - Perioada: " . $item['perioada'] . "<br>";
    }
?>

<?php
    //lab 4
    //Stabilire conexiune
  $user = "user";
  $pass = "pass";
  try {
    $db = new PDO('mysql:host=localhost;dbname=paw', $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
     die("\nUnable to connect: " . $e->getMessage());
    }

    //Creare tabele
  $db->exec("DROP TABLE IF EXISTS date_pers");
  $db->exec("CREATE TABLE IF NOT EXISTS date_pers (
    date_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nume VARCHAR(20), 
    prenume VARCHAR(20), 
    telefon INT(10), 
    email VARCHAR(50), 
    adresa VARCHAR(100)
    )");
  $db->exec("DROP TABLE IF EXISTS educatie");
  $db->exec("CREATE TABLE IF NOT EXISTS educatie (
    educatie_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    liceu VARCHAR(20), 
    facultate VARCHAR(20), 
    master_ VARCHAR(20),
    date_id INT(6) UNSIGNED REFERENCES date_pers(date_id)
    )");
  $db->exec("DROP TABLE IF EXISTS experienta");
  $db->exec("CREATE TABLE IF NOT EXISTS experienta (
    experienta_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    companie VARCHAR(20), 
    pozitie VARCHAR(20), 
    perioada VARCHAR(20),
    date_id INT(6) UNSIGNED REFERENCES date_pers(date_id)
    )");

        //Functii de inserare si apelarea lor
     function insertDatePers($nume,$prenume,$telefon,$email,$adresa) {
        return "INSERT INTO date_pers (nume, prenume, telefon, email, adresa) VALUES ('$nume', '$prenume', $telefon, '$email', '$adresa')";
      } 

      function insertEducatie($liceu,$facultate,$master,$date_id) {
        return "INSERT INTO educatie (liceu, facultate, master_, date_id) VALUES ('$liceu', '$facultate', '$master', $date_id)";
      }

      function insertExperienta($companie,$pozitie,$perioada,$date_id) {
        return "INSERT INTO experienta (companie, pozitie, perioada, date_id) VALUES ('$companie', '$pozitie', '$perioada', $date_id)";
      }
  $query = insertDatePers($cv->getNume(),$cv->getPrenume(),$cv->getTelefon(),$cv->getEmail(),$cv->getAdresa());
  $db->exec($query);

  $SelectLastDateId = $db->query("SELECT MAX(date_id) FROM date_pers");
  $SelectLastDateIdResult = $SelectLastDateId->fetch();
  $lastDateId = $SelectLastDateIdResult[0];

  $query = insertEducatie($cv->getEducatie()[0]["liceu"],$cv->getEducatie()[0]["facultate"],$cv->getEducatie()[0]["master"],$lastDateId);
  $db->exec($query);

  $query = insertExperienta($cv->getExperienta()[0]["companie"],$cv->getExperienta()[0]["pozitie"],$cv->getExperienta()[0]["perioada"],$lastDateId);
  $db->exec($query);

    //Functii de modificare si apelarea lor
  function updateDatePers($column,$value,$nume,$prenume,$telefon,$email,$adresa) {
    $needComma = false;
    $ValuesToSet = "";
    if($nume != NULL) {
        $ValuesToSet = $ValuesToSet . "nume = '$nume'";
        $needComma = true;
      }
    if($prenume != NULL) {
      if($needComma == true)
        $ValuesToSet = $ValuesToSet . ", ";
      $ValuesToSet = $ValuesToSet . "prenume = '$prenume'";
      $needComma = true;
    }
    if($telefon != NULL) {
      if($needComma == true)
        $ValuesToSet = $ValuesToSet . ", ";
      $ValuesToSet = $ValuesToSet . "telefon = $telefon";
      $needComma = true;
    }
    if($email != NULL) {
      if($needComma == true)
        $ValuesToSet = $ValuesToSet . ", ";
      $ValuesToSet = $ValuesToSet . "email = '$email'";
      $needComma = true;
    }
    if($adresa != NULL) {
      if($needComma == true)
        $ValuesToSet = $ValuesToSet . ", ";
      $ValuesToSet = $ValuesToSet . "adresa = '$adresa'";
    }
    if(is_string($column))
      return "UPDATE date_pers SET " . $ValuesToSet . " WHERE $column = '$value'";
      else
      return "UPDATE date_pers SET " . $ValuesToSet . " WHERE $column = $value";
  }
  //$query = updateDatePers("date_id",1,"test","testare","","",""); //test functie
  //$db->exec($query);

  function updateEducatie($column,$value,$liceu,$facultate,$master,$date_id) {
    $needComma = false;
    $ValuesToSet = "";
    if($liceu != NULL) {
        $ValuesToSet = $ValuesToSet . "liceu = '$liceu'";
        $needComma = true;
      }
    if($facultate != NULL) {
      if($needComma == true)
        $ValuesToSet = $ValuesToSet . ", ";
      $ValuesToSet = $ValuesToSet . "facultate = '$facultate'";
      $needComma = true;
    }
    if($master != NULL) {
      if($needComma == true)
        $ValuesToSet = $ValuesToSet . ", ";
      $ValuesToSet = $ValuesToSet . "master_ = '$master'";
      $needComma = true;
    }
    if($date_id != NULL) {
      if($needComma == true)
        $ValuesToSet = $ValuesToSet . ", ";
      $ValuesToSet = $ValuesToSet . "email = $date_id";
      $needComma = true;
    }
    if(is_string($column))
      return "UPDATE educatie SET " . $ValuesToSet . " WHERE $column = '$value'";
      else
      return "UPDATE educatie SET " . $ValuesToSet . " WHERE $column = $value";
  }
  //$query = updateEducatie("liceu","adfgs","liceu adevarat","","master adevarat",""); //test functie
  //$db->exec($query);

  function updateExperienta($column,$value,$companie,$pozitie,$perioada,$date_id) {
    $needComma = false;
    $ValuesToSet = "";
    if($companie != NULL) {
        $ValuesToSet = $ValuesToSet . "companie = '$companie'";
        $needComma = true;
      }
    if($pozitie != NULL) {
      if($needComma == true)
        $ValuesToSet = $ValuesToSet . ", ";
      $ValuesToSet = $ValuesToSet . "pozitie = '$pozitie'";
      $needComma = true;
    }
    if($perioada != NULL) {
      if($needComma == true)
        $ValuesToSet = $ValuesToSet . ", ";
      $ValuesToSet = $ValuesToSet . "perioada = '$perioada'";
      $needComma = true;
    }
    if($date_id != NULL) {
      if($needComma == true)
        $ValuesToSet = $ValuesToSet . ", ";
      $ValuesToSet = $ValuesToSet . "email = $date_id";
      $needComma = true;
    }
    if(is_string($column))
      return "UPDATE experienta SET " . $ValuesToSet . " WHERE $column = '$value'";
      else
      return "UPDATE experienta SET " . $ValuesToSet . " WHERE $column = $value";
  }
  //$query = updateExperienta("pozitie","sdf","","Nimic","5 minute",""); //test functie
  //$db->exec($query);

        //Functii de stergere si apelarea lor
      function deleteT($tableName,$column,$value) {
        if(is_string($column))
          return "DELETE FROM $tableName WHERE $column = '$value'";
          else
          return "DELETE FROM $tableName WHERE $column = $value";
      }
      
  //$query = deleteT('date_pers','date_id',1); //test functie
  // $db->exec($query); 

        //Functii de Selectare
        function selectDatePers($id,$nume,$prenume,$telefon,$email,$adresa) {
          $needAND = false;
          $ValuesToCompare = "";
          if($id != NULL) {
            $ValuesToCompare = $ValuesToCompare . "date_id = '$id'";
            $needAND = true;
          }
          if($nume != NULL) {
            if($needAND == true)
              $ValuesToCompare = $ValuesToCompare . " AND ";
            $ValuesToCompare = $ValuesToCompare . "nume = '$nume'";
            $needAND = true;
          }
          if($prenume != NULL) {
            if($needAND == true)
              $ValuesToCompare = $ValuesToCompare . " AND ";
            $ValuesToCompare = $ValuesToCompare . "prenume = '$prenume'";
            $needAND = true;
          }
          if($telefon != NULL) {
            if($needAND == true)
              $ValuesToCompare = $ValuesToCompare . " AND ";
            $ValuesToCompare = $ValuesToCompare . "telefon = $telefon";
            $needAND = true;
          }
          if($email != NULL) {
            if($needAND == true)
              $ValuesToCompare = $ValuesToCompare . " AND ";
            $ValuesToCompare = $ValuesToCompare . "email = '$email'";
            $needAND = true;
          }
          if($adresa != NULL) {
            if($needAND == true)
              $ValuesToCompare = $ValuesToCompare . " AND ";
            $ValuesToCompare = $ValuesToCompare . "adresa = '$adresa'";
          }
            return "SELECT * FROM date_pers WHERE " . $ValuesToCompare;
        }

      $query = selectDatePers("","test","","","","");
      $stmt = $db->query($query); 
      echo "<br><strong>Tabela date_pers:</strong><br>";
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "date_id: " . $row['date_id'] . "<br>";
        echo "nume: " . $row['nume'] . "<br>";
        echo "prenume: " . $row['prenume'] . "<br>";
        echo "telefon: " . $row['telefon'] . "<br>";
        echo "email: " . $row['email'] . "<br>";
        echo "adresa: " . $row['adresa'] . "<br><br>";
    }

    function selectEducatie($id,$liceu,$facultate,$master,$date_id) {
      $needAND = false;
      $ValuesToCompare = "";
      if($id != NULL) {
          $ValuesToCompare = $ValuesToCompare . "educatie_id = '$id'";
          $needAND = true;
        }
      if($liceu != NULL) {
        if($needAND == true)
          $ValuesToCompare = $ValuesToCompare . " AND ";
        $ValuesToCompare = $ValuesToCompare . "liceu = '$liceu'";
        $needAND = true;
      }
      if($facultate != NULL) {
        if($needAND == true)
          $ValuesToCompare = $ValuesToCompare . " AND ";
        $ValuesToCompare = $ValuesToCompare . "facultate = $facultate";
        $needAND = true;
      }
      if($master != NULL) {
        if($needAND == true)
          $ValuesToCompare = $ValuesToCompare . " AND ";
        $ValuesToCompare = $ValuesToCompare . "master_ = '$master'";
        $needAND = true;
      }
      if($date_id != NULL) {
        if($needAND == true)
          $ValuesToCompare = $ValuesToCompare . " AND ";
        $ValuesToCompare = $ValuesToCompare . "date_id = '$date_id'";
      }
        return "SELECT * FROM educatie WHERE " . $ValuesToCompare;
    }

  $query = selectEducatie("","","","","1");
  $stmt = $db->query($query); 
  echo "<br><strong>Tabela Educatie:</strong><br>";
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "educatie_id: " . $row['educatie_id'] . "<br>";
    echo "liceu: " . $row['liceu'] . "<br>";
    echo "facultate: " . $row['facultate'] . "<br>";
    echo "master: " . $row['master_'] . "<br>";
    echo "date_id: " . $row['date_id'] . "<br><br>";
    }
    function selectExperienta($id,$companie,$pozitie,$perioada,$date_id) {
      $needAND = false;
      $ValuesToCompare = "";
      if($id != NULL) {
          $ValuesToCompare = $ValuesToCompare . "experienta_id = '$id'";
          $needAND = true;
        }
      if($companie != NULL) {
        if($needAND == true)
          $ValuesToCompare = $ValuesToCompare . " AND ";
        $ValuesToCompare = $ValuesToCompare . "companie = '$companie'";
        $needAND = true;
      }
      if($pozitie != NULL) {
        if($needAND == true)
          $ValuesToCompare = $ValuesToCompare . " AND ";
        $ValuesToCompare = $ValuesToCompare . "pozitie = '$pozitie'";
        $needAND = true;
      }
      if($perioada != NULL) {
        if($needAND == true)
          $ValuesToCompare = $ValuesToCompare . " AND ";
        $ValuesToCompare = $ValuesToCompare . "perioada = '$perioada'";
        $needAND = true;
      }
      if($date_id != NULL) {
        if($needAND == true)
          $ValuesToCompare = $ValuesToCompare . " AND ";
        $ValuesToCompare = $ValuesToCompare . "date_id = '$date_id'";
      }
        return "SELECT * FROM experienta WHERE " . $ValuesToCompare;
    }

    $query = selectExperienta("","sdf","","","");
    $stmt = $db->query($query); 
    echo "<br><strong>Tabela Educatie:</strong><br>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "experienta_id: " . $row['experienta_id'] . "<br>";
    echo "companie: " . $row['companie'] . "<br>";
    echo "pozitie: " . $row['pozitie'] . "<br>";
    echo "perioada: " . $row['perioada'] . "<br>";
    echo "date_id: " . $row['date_id'] . "<br><br>";
    }
  ?>