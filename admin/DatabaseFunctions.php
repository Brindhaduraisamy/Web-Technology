<?php

class Database {

    protected $connection;
    
    public function __construct($dbhost='localhost', $dbuser='root', $dbpass='', $dbname='')
    {
        global $connection;
        try {
            // $dsn = "mysql:dbname=".$dbname.";host=".$dbhost.";port=3306;";
            $dsn = "mysql:dbname=".$dbname.";host=".$dbhost.";";
            echo "hello";
            $this->$connection = new PDO($dsn, $dbuser, $dbpass);
            $this->$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e) {
            //echo "hello";
            echo $sql . "<br>" . $e->getMessage();
        }
    }
   
    public function closeDBConnection() {
        $this->connection = null;
    }

    public function getAllProducts()
    {
        global $connection;
        $allProducts = array();
        $sql = "SELECT product_name, price, product_img, product_id,available FROM product;";
        $stmt = $this->$connection->prepare($sql);
        $stmt->execute();
        $allProducts = $stmt->fetchAll();

        return $allProducts;
    }

    public function getAllUsers()
    {
        global $connection;
        $allUsers = array();
        $sql = "SELECT user_id, user_name, room, profile_pic, ext FROM user;";
        $stmt = $this->$connection->prepare($sql);
        $stmt->execute();
        $allUsers = $stmt->fetchAll();

        return $allUsers;
    }
    public function getAllCategories(){
        global $connection;
        $allCategories=array();
        $sql="select * from category";
        $stmt = $this->$connection->prepare($sql);
        $stmt->execute();
        $allCategories = $stmt->fetchAll();
        
        return $allCategories;

    }
    public function addCategory($name){
        global $connection;
        $sql="insert into category(category_name) values(?)";
        $stmt = $this->$connection->prepare($sql);
        try{       
        $val=$stmt->execute([$name]);      
        
        }
        catch (Exception $e){
          
        }
        return $val;
    }
    public function addProduct($name,$img="",$price="",$category_id){
        global $connection;
        $sql="insert into product(product_name,product_img,price,available,category_id) values(?,?,?,?,?)";
        $stmt = $this->$connection->prepare($sql);
        try{       
        $val=$stmt->execute([$name,$img,$price,"available",$category_id]);              
        }
        catch (Exception $e){
          
        }
        return $val;
    }

    public function login($email,$password){
        global $connection;
        $sql = "SELECT * FROM user where user_password=? AND email=?;"; // SQL with parameters
        $stmt = $this->$connection->prepare($sql); 
        try{       
            $stmt->execute([$password,$email]);      
           $result=$stmt->fetchAll();
           return $result;
        }
        catch (Exception $e){
             return 0;
        }
    }
       



    public function getUser($id)
    {
        global $connection;
        $sql =  "SELECT user_name, user_id, user_password, email, profile_pic, room, ext FROM user where user_id=?";
        $stmt = $this->$connection->prepare($sql);
        $stmt->execute([$id]);
        $result=$stmt->fetch();
        return $result;
    }

    public function getUsernameWthTotal($user_id)
    {
        global $connection;
        global $sql;
        global $stmt;

        $usersWthTotal = array();
        $sql;
        $stmt;

        if($user_id !== "-1")
        {
            $sql = "SELECT u.user_name, SUM(o.amount) AS total_amount, u.user_id FROM user u, orders o WHERE u.user_id = o.user_id AND u.user_id = :user_id GROUP BY u.user_id, u.user_name;";
            $stmt = $this->$connection->prepare($sql);
            $stmt->bindParam(":user_id", $user_id);
        }
        else
        {
            $sql = "SELECT u.user_name, SUM(o.amount) AS total_amount, u.user_id FROM user u, orders o WHERE u.user_id = o.user_id GROUP BY u.user_id, u.user_name;";
            $stmt = $this->$connection->prepare($sql);
        }
        $stmt->execute();
        $usersWthTotal = $stmt->fetchAll();

        return $usersWthTotal;        
    }

    public function getOrdersOfUser($date_from, $date_to, $user_id)
    {
        global $connection;
        $orders = array();
        $sql = "SELECT order_id, order_date, SUM(amount) AS total_amount, user_id FROM orders WHERE user_id = :user_id AND order_date BETWEEN :datefrom AND :dateto GROUP BY user_id, order_date, order_id;";
        $stmt = $this->$connection->prepare($sql);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":datefrom", $date_from);
        $stmt->bindParam(":dateto", $date_to);
        $stmt->execute();
        $orders = $stmt->fetchAll();

        return $orders; 
    }

    public function getProductsOfOrder($order_id)
    {
        global $connection;
        $products = array();
        $sql = "SELECT p.product_img, p.price, op.quantity FROM product p, order_product op WHERE p.product_id = op.product_id AND op.order_id = :order_id;";
        $stmt = $this->$connection->prepare($sql);
        $stmt->bindParam(":order_id", $order_id);
        $stmt->execute();
        $products = $stmt->fetchAll();
        return $products; 
    }



    public function deleteUser($id)
    {
        global $connection;
        $sql = "DELETE FROM user where user_id=?";
        $stmt = $this->$connection->prepare($sql);
        $stmt->execute([$id]);
        $result=$stmt->rowCount();
        return $result;
    }

    public function resetPassword($email, $password){
        global $connection;
        $sql = "UPDATE user SET user_password=:password WHERE email=:email";
        $stmt = $this->$connection->prepare($sql);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $result=$stmt->rowCount();
        return $result;
    }
    public function updateUser($id, $username, $email, $room, $ext){
        global $connection;
        $sql = "UPDATE user SET user_name=:username, email=:email, room=:room, ext=:ext WHERE user_id=:id";
        $stmt = $this->$connection->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":room", $room);
        $stmt->bindParam(":ext", $ext);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $result=$stmt->rowCount();
        return $result;
    }
    public function updateProductStatus($id, $status){
        global $connection;
        $sql = "UPDATE product SET available=:available WHERE product_id=:product_id";
        $stmt = $this->$connection->prepare($sql);
        $stmt->bindParam(":available", $status);
        $stmt->bindParam(":product_id", $id);
        $stmt->execute();
        $result=$stmt->rowCount();
        return $result;
    }
    public function updateUserwithPasswordWithPic($id, $username, $email, $password, $room, $ext, $profilePic){
        global $connection;
        $sql = "UPDATE user SET user_name=:username, email=:email, user_password=:password, room=:room, ext=:ext, profile_pic=:profilePic WHERE user_id=:id";
        $stmt = $this->$connection->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":room", $room);
        $stmt->bindParam(":ext", $ext);
        $stmt->bindParam(":profilePifc", $profilePic);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $result=$stmt->rowCount();
        return $result;
    }
    public function updateUserWithPic($id, $username, $email, $room, $ext, $profilePic){
        global $connection;
        $sql = "UPDATE user SET user_name=:username, email=:email, user_password=:password, room=:room, ext=:ext, profile_pic=:profilePic WHERE user_id=:id";
        $stmt = $this->$connection->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":room", $room);
        $stmt->bindParam(":ext", $ext);
        $stmt->bindParam(":profilePifc", $profilePic);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $result=$stmt->rowCount();
        return $result;
    }
    public function updateUserWithPassword($id, $username, $email, $password, $room, $ext){
        global $connection;
        $sql = "UPDATE user SET user_name=:username, email=:email, user_password=:password, room=:room, ext=:ext WHERE user_id=:id";
        $stmt = $this->$connection->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":room", $room);
        $stmt->bindParam(":ext", $ext);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $result=$stmt->rowCount();
        return $result;
    }
    public function deleteProduct($id){
        global $connection;
        $sql = "DELETE FROM product where product_id=?";
        $stmt = $this->$connection->prepare($sql);
        $stmt->execute([$id]);
        $result=$stmt->rowCount();
        return $result;
    }
}

?>