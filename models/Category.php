<?php
class Category{
    // DB Stuff
    private $conn;
    private $table = 'categories';

    // Properties
    public $id;
    public $name;
    public $created_at;

    public $num;

    // Constructor with DB
    public function __construct($db){
        $this->conn = $db;
    }

    // Get categories
    public function read(){
        // Create query
        $query = 'SELECT
        id,
        name,
        created_at 
        FROM
            ' . $this->table . '
        ORDER BY 
        created_at DESC';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get Single Category
    public function read_single(){
        // Create query
        $query = 'SELECT
        id,
        name,
        created_at 
        FROM
            ' . $this->table . '
        WHERE 
        id = ?
        LIMIT 0,1';
        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1,$this->id);

        // Execute query
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if there is any rows, if id exists
        $this->num = $stmt->rowCount();

        // Set properties
        $this->name = $row['name'];
        $this->created_at = $row['created_at'];

    }

    // Create Category
    public function create(){
        // Create query
        $query = 'INSERT INTO '.
            $this->table .'
            SET
            name = :name';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));

        // Bind data
        $stmt->bindParam(':name',$this->name);

        // Execute query
        if($stmt->execute()){
            return true;
        }
        // Print error if something goes wrong
        printf("Error: %s.\n",$stmt->error);
        return false;
    }














}

?>