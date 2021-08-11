<?php
include_once 'config/database.php';
include_once 'objects/client.php';

$database = new Database();
$db = $database->getConnection();

$client = new Client($db);

if ($_POST)
{

    $client->name = $_POST['name'];
    $client->phone = $_POST['phone'];
    $client->email = $_POST['email'];

        /*$file = $_FILES["project_foto"]["tmp_name"];
        $ext = pathinfo($_FILES['project_foto']['name'], PATHINFO_EXTENSION);
        $imageName = date('HisdmY').'.'.$ext;

        move_uploaded_file($_FILES["project_foto"]["tmp_name"],
        "uploads/" . $imageName);*/


        $files = array();
          foreach($_FILES as $fields) {
          foreach($fields['name'] as $index => $file_name) {
              $files[$file_name] = array(
                  'name' => $fields['name'][$index],
                  'tmp_name' => $fields['tmp_name'][$index]);
              }
          }

          foreach($files as $value) {
            move_uploaded_file($value['tmp_name'],
            "uploads/" . $value['name']);
          }
      $client->project_foto = $files;


    if ($client->create())
    {
        echo "Успешно!";
    }

    else
    {
        echo "Ошибка!";
    }

}
