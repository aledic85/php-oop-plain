<?php

class Pagamento {

  public $id;
  public $status;
  public $price;

  function __construct($id, $status, $price){

    $this->id = $id;
    $this->status = $status;
    $this->price = $price;

  }

  function printMe() {

    echo $this->id . " " . $this->status . ": " . $this->price . "$" . "<br>";
  }
}

$servername = "localhost";
$username = "root";
$password = "juventus";
$dbname = "Prova1";

$conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_errno) {

    echo ("Connection failed: " . $conn->connect_error);
    return;
  }

  $sql = "SELECT *
          FROM pagamenti";

  $result = $conn->query($sql);

  $pending = [];
  $rejected = [];
  $accepted = [];

  if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {

      $pagamento = new Pagamento($row["id"],
                            $row["status"],
                            $row["price"]);

      if ($pagamento->status == "pending") {

        $pending[] = $pagamento;
      }elseif ($pagamento->status == "rejected") {

        $rejected[] = $pagamento;
      }elseif ($pagamento->status == "accepted") {

        $accepted[] = $pagamento;
      }
    }
  } else {

    echo "0 results";
  }

  $conn->close();

  foreach ($pending as $value) {

    $value->printMe();
  }

  echo "<br>";

  foreach ($rejected as $value) {

    $value->printMe();
  }

  echo "<br>";

  foreach ($accepted as $value) {

    $value->printMe();
  }
?>
