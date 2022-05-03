<?php
$user = "Kaduna";
$password = "April@2022";
$database = "Fenty_database";
$table = "todo_list";

try {
  $db = new PDO("mysql:host=172.28.128.3;dbname=$database", $user, $password);
print "Success!: ";
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

?>