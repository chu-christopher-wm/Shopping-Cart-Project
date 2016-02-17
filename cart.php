<?php
$user = 'root';
$pass = 'root';
$name = 'JettaShop';
$dbh = null;
try {
    $dbh = new PDO('mysql:host=localhost;dbname=' .$name, $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    print"error: ". $e->getMessage() . "<br/>";
    die();
}

function addProduct($conn, $id) {
    $token = getToken();
    $sql = 'INSERT INTO orders_products (orders_id, products_id) (SELECT o.id, ? FROM users u LEFT JOIN orders o ON u.id = o.users_id AND o.status = "new" WHERE u.token = ?)';
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(array($id, $token))) {
    }
}
function deleteProduct($conn, $id) {
    $token = getToken();
    $sql = 'DELETE op FROM users u LEFT JOIN orders o ON u.id = o.users_id AND o.status = "new" LEFT JOIN orders_products op ON o.id = op.orders_id WHERE u.token = ? AND op.id = ?';
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(array($token, $id))) {
    }
}
function getProducts($conn) {
    $token = getToken();
    $sql = 'SELECT p.name, p.price, p.preview, op.id FROM users u LEFT JOIN orders o ON u.id = o.users_id AND o.status = "new" LEFT JOIN orders_products op ON o.id = op.orders_id LEFT JOIN products p ON op.products_id = p.id WHERE u.token = ?';
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(array($token))) {
        while ($row = $stmt->fetch()) {
            if ($row['id'] != null) {
                echo '<div>
                   <div class="col-sm-4 col-lg-4 col-md-4" >
                       <div class="thumbnail" style="height:550px;" >
                           <img src="'.$row["preview"].'">

                   Name: '.$row['name'].'<br>
                   Price: $'.$row['price'].'<br>
                   <form method="post" action="shoppingcart.php">
                       <input type="hidden" name="id" value="'.$row['id'].'"/>
                       <input type="submit" name="delete" value="DELETE"/>
                   </form>
                   </div></div>
                   </div>'
                ;


            }
        }
    }
}
function getToken() {
    if (isset($_COOKIE['token'])) {
        return $_COOKIE['token'];
    }
    else {
    }
}
if(isset($_POST['add'])) {
    $id = $_POST['id'];
    addProduct($dbh, $id);
}
if(isset($_POST['delete'])) {
    $id = $_POST['id'];
    deleteProduct($dbh, $id);
}
?>

Team Directory

<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
</head>
<body>
<h1>Cart Checkout</h1>
<div>
    <a href="index%20(7).php">Back</a>
</div><br><br>

<div>
    <?php
    getProducts($dbh);
    ?>
    <br>
    <form method="post" action="">
        <input type="submit" name="checkout" value="CHECKOUT"/>
    </form>
</div>
</body>
</html>