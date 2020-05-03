<?php
class Post {
    private $conn;
    private $table = 'posts';

    //post eigenshappen
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    //constructor met db
   public function __construct($db)
   {
       $this->conn = $db;
   }

    public function read(){
        $query = 'SELECT 
            c.name AS category_name,
                p.id,
                p.category_id,
                p.title,p.body,
                p.created_at
        FROM 
        ' .$this->table . ' p 
        LEFT JOIN 
            categories c ON p.category_id = c.id 
            ORDER BY 
                p.created_at DESC';

        //prepare statement
        $stmt = $this->conn->prepare($query);
        //exceutre
        $stmt->execute();
        return $stmt;
    }
    //get single post
    public function  read_single(){
        $query = 'SELECT 
            c.name AS category_name,
                p.id,
                p.category_id,
                p.title,p.body,
                p.created_at
        FROM 
        ' .$this->table . ' p 
        LEFT JOIN 
            categories c ON p.category_id = c.id 
            WHERE 
                p.id = ?
             LIMIT 0,1';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //bind id
        $stmt->bindParam(1, $this->id);
        //uitvoeren
        $stmt->execute();

        //fetch array
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        //toewijzen props
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];

    }
    //maak post
    public function create(){
        $query = 'INSERT INTO '. $this ->table . '
        SET 
            title = :title,
            body = :body,
            author = :author,
            category_id = :category_id';

        //voorbereiden van het statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->category_name = htmlspecialchars(strip_tags($this->category_name));

        //bind data
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);

        //execute query
        if($stmt->execute()){
            return true;
        }else{
            //print fout
            printf('Error: %s.\n',$stmt->error);
            return false;
        }

    }
}
