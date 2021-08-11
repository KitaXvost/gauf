<?php
class Client
{

    private $conn;
    private $table_name = "users";

    public $name;
    public $phone;
    public $email;
    public $project_foto;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    function create()
    {

      foreach($this->project_foto as $project_foto) {
      $query = "INSERT INTO uploads (project_foto) VALUES (:project_foto)";
      $params = [
          ':project_foto' => $project_foto['name']
      ];
      $stmt = $this->conn->prepare($query);
      $stmt->execute($params);
      }




        $query = "INSERT INTO " . $this->table_name . " (name, phone, email)
                VALUES (:name, :phone, :email)";

        //защита от инъекций
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->email = htmlspecialchars(strip_tags($this->email));
        //$this->project_foto = htmlspecialchars(strip_tags($this->project_foto));


        $stmt = $this
            ->conn
            ->prepare($query);

        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":email", $this->email);
        //$stmt->bindParam(":project_foto", $this->project_foto);

        if ($stmt->execute())
        {
            return true;
        }
        else
        {
            return false;
        }



    }


}
