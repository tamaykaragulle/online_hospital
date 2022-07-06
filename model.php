<?php
    class Cloth
    {
        protected string $title;
        protected string $desc;
        protected string $color;
        protected float $price;
        protected array $sizes;
        protected int $quantity;
        protected string $seller_name;
        protected string $type;

        function __construct($title, $desc, $color, $price, $sizes, $quantity, $seller_name, $type)
        {
            $this->title = $title;
            $this->desc = $desc;
            $this->color = $color;
            $this->price = $price;
            $this->sizes = $sizes;
            $this->quantity = $quantity;
            $this->seller_name = $seller_name;
            $this->type = $type;
        }

        function insertToDb():bool
        {
            $mysqli = new mysqli("localhost", "root", "#B!je?651*rK", "clothing_shop_db");
            $statement = $mysqli->prepare("INSERT INTO clothes(title,description,color,price,sizes,quantity,seller_name,type) VALUES (?,?,?,?,?,?,?,?)");
            $sizes_json = json_encode($this->sizes);
            $statement->bind_param('sssdsdss', $this->title, $this->desc, $this->color, $this->price, $sizes_json, $this->quantity, $this->seller_name, $this->type);
            $statement->execute();
            if(var_export($statement,true)) return true;
            return false;
        }

        function getTitle():string
        {
            return $this->title;
        }
        function getDescription():string
        {
            return $this->desc;
        }
        function getColor():string
        {
            return $this->color;
        }
        function getPrice():int
        {
            return $this->price;
        }
        function getSizes():array
        {
            return $this->sizes;
        }
        function getSellerName():string
        {
            return $this->seller_name;
        }
        function getQuantity():int
        {
            return $this->quantity;
        }
        function getType():string
        {
            return $this->type;
        }
    }


    class User
    {
        protected string $username = "";
        protected string $password = "";
        protected string $email = "";
        protected string $type = "";
        public string $name = "";
        protected string $surname = "";
        protected ?int $age = null;
        protected string $gender = "";
        protected $date_joined = null;
        protected int $num_products_sold = 0;
        protected int $num_products_listed = 0;
        protected int $num_products_bought = 0;

        function __construct(string $username, string $password=Null, string $email=Null, string $type=null,
                            string $name=null, string $surname=null, string $gender=null, int $age=0)
                            {
            $this->username = $username;
            if($password) $this->password = $password;
            if($email) $this->email = $email;
            if($type) $this->type = $type;
            if($name) $this->name = $name;
            if($surname) $this->surname = $surname;
            if($gender) $this->gender = $gender;
            if($age and $age> 0) $this->age = $age;
        }

        function insertToDb():bool
        {
            if (! $this->email) return false;
            if($this->userExists()) return false;
            $mysqli = new mysqli("localhost", "root", "#B!je?651*rK", "clothing_shop_db");
            $statement = $mysqli->prepare("INSERT INTO users(username,password,email) VALUES (?,?,?)");
            $hashedPw = password_hash($this->password, PASSWORD_DEFAULT);
            $statement->bind_param('sss', $this->username, $hashedPw, $this->email);
            $statement->execute();
            return true;
        }

        function userExists():bool
        {
            $mysqli = new mysqli("localhost", "root", "#B!je?651*rK", "clothing_shop_db");
            $statement = $mysqli->prepare("SELECT username FROM users WHERE username = ?");
            $statement->bind_param("s", $this->username);
            $statement->execute();
            $statement->bind_result($result);
            $statement->fetch();
            return var_export($result, true) !== 'NULL';
        }

        function completeColumns():void
        {
            $mysqli = new mysqli("localhost", "root", "#B!je?651*rK", "clothing_shop_db");
            $statement = $mysqli->prepare("select email,type,name,surname,gender,age,date_joined,items_bought from users where username = ?");
            $statement->bind_param("s", $this->username);
            $statement->execute();
            $statement->bind_result($email, $type, $name, $surname, $gender, $age, $date_joined, $num_products_bought);
            $statement->fetch();
            if(var_export($email,true) !== 'NULL') $this->email = $email;
            if(var_export($type,true) !== 'NULL') $this->type = $type;
            if(var_export($name,true) !== 'NULL') $this->name = $name;
            if(var_export($surname,true) !== 'NULL') $this->surname = $surname;
            if(var_export($gender,true) !== 'NULL') $this->gender = $gender;
            if(var_export($age,true) !== 'NULL') $this->age = $age;
            if(var_export($num_products_bought, true) !== 'NULL') $this->num_products_bought = $num_products_bought;

            if(var_export($date_joined, true) !== 'NULL'){
                $date = strtotime($date_joined);
                $date = date("m/d/y", $date);
                $this->date_joined = $date;
            }
            if($this->type == 'seller'){
                $mysqli2 = new mysqli("localhost", "root", "#B!je?651*rK", "clothing_shop_db");
                $st = $mysqli2->prepare("select num_products_sold,num_products_listed from sellers where username = ?");
                $st->bind_param("s", $this->username);
                $st->execute();
                $st->bind_result($num_products_sold, $num_products_listed);
                $st->fetch();
                if(var_export($num_products_sold, true) !== 'NULL') $this->num_products_sold = $num_products_sold;
                if(var_export($num_products_listed, true) !== 'NULL') $this->num_products_listed = $num_products_listed;
            }
        }

        public function getUsername():string
        {
            return print_r($this->username,true);
        }
        public function getEmail():string
        {
            return print_r($this->email,true);
        }
        public function getType():string
        {
            return print_r($this->type, true);
        }
        public function getName()
        {
            return $this->name;
        }
        public function getSurname():string|null
        {
            return print_r($this->surname, true);
        }
        public function getGender():string
        {
            return print_r($this->gender, true);
        }
        public function getAge()
        {
            return print_r($this->age,true);
        }
        public function getNumProductsSold():int
        {
            return $this->num_products_sold;
        }
        public function getNumProductsListed():int
        {
            return $this->num_products_listed;
        }
        public function getNumProductsBought():int
        {
            return $this->num_products_bought;
        }
        public function getDateJoined()
        {
            return $this->date_joined;
        }


        public function setEmail(string $newEmail):void
        {
            $this->email = $newEmail;
            $mysqli = new mysqli("localhost", "root", "#B!je?651*rK", "clothing_shop_db");
            $statement = $mysqli->prepare("update users set email = ? where username = ?");
            $statement->bind_param("ss", $newEmail, $this->username);
            $statement->execute();
        }
        public function setPassword(string $newPassword):void
        {
            $this->password = $newPassword;
            $mysqli = new mysqli("localhost", "root", "#B!je?651*rK", "clothing_shop_db");
            $statement = $mysqli->prepare("update users set password = ? where username = ?");
            $statement->bind_param("ss", $newPassword, $this->username);
            $statement->execute();
        }
        public function settype(string $newtype):void
        {
            $this->type = $newtype;
            $mysqli = new mysqli("localhost", "root", "#B!je?651*rK", "clothing_shop_db");
            $statement = $mysqli->prepare("update users set type = ? where username = ?");
            $statement->bind_param("ss", $newtype, $this->username);
            $statement->execute();
        }
        public function setGender(string $newGender):void
        {
            $this->gender = $newGender;
            $mysqli = new mysqli("localhost", "root", "#B!je?651*rK", "clothing_shop_db");
            $statement = $mysqli->prepare("update users set gender = ? where username = ?");
            $statement->bind_param("ss", $newGender, $this->username);
            $statement->execute();
        }
        public function setName(string $newName):void
        {
            $this->name = $newName;
            $mysqli = new mysqli("localhost", "root", "#B!je?651*rK", "clothing_shop_db");
            $statement = $mysqli->prepare("update users set name = ? where username = ?");
            $statement->bind_param("ss", $newName, $this->username);
            $statement->execute();
        }
        public function setSurname(string $newSurname):void
        {
            $this->surname = $newSurname;
            $mysqli = new mysqli("localhost", "root", "#B!je?651*rK", "clothing_shop_db");
            $statement = $mysqli->prepare("update users set surname = ? where username = ?");
            $statement->bind_param("ss", $newSurname, $this->username);
            $statement->execute();
        }
        public function setAge(int $newAge):void
        {
            $this->age = $newAge;
            $mysqli = new mysqli("localhost", "root", "#B!je?651*rK", "clothing_shop_db");
            $statement = $mysqli->prepare("update users set age = ? where username = ?");
            $statement->bind_param("ds", $newAge, $this->username);
            $statement->execute();
        }
        public function setNumProductsBought(int $newNum):void
        {
            $this->num_products_bought = $newNum;
            $mysqli = new mysqli("localhost", "root", "#B!je?651*rK", "clothing_shop_db");
            $statement = $mysqli->prepare("update users set num_products_bought = ? where username = ?");
            $statement->bind_param("ds", $$newNum, $this->username);
            $statement->execute();
        }
        public function setNumProductsSold(int $newNum):void
        {
            if($this->type !== 'seller') return;
            $this->num_products_sold = $newNum;
            $mysqli = new mysqli("localhost", "root", "#B!je?651*rK", "clothing_shop_db");
            $statement = $mysqli->prepare("update sellers set num_products_sold = ? where username = ?");
            $statement->bind_param("ds", $$newNum, $this->username);
            $statement->execute();
        }
        public function setNumProductsListed(int $newNum):void
        {
            if($this->type !== 'seller') return;
            $this->num_products_listed = $newNum;
            $mysqli = new mysqli("localhost", "root", "#B!je?651*rK", "clothing_shop_db");
            $statement = $mysqli->prepare("update sellers set num_products_listed = ? where username = ?");
            $statement->bind_param("ds", $newNum, $this->username);
            $statement->execute();
        }

        public function login():bool
        {
            $mysqli = new mysqli("localhost", "root", "#B!je?651*rK", "clothing_shop_db");
            $st = $mysqli->prepare("select password from users where username=?");
            $st->bind_param("s", $this->username);
            $st->execute();
            $st->bind_result($hashedPw);
            $st->fetch();
            return password_verify($this->password, $hashedPw);
        }
    }
?>
