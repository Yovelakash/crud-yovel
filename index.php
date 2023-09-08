<!DOCTYPE html>
<html>
<head>
    <title>Data from Database</title>
</head>
<body>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Type</th>
            <th>Action</th>
        </tr>
        
        <?php
            $host = "localhost";
            $database = "product-management";
            $username = "root";
            $password = "";

            try {
                // Create a new PDO instance
                $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
 
                // Set PDO to throw exceptions for error handling
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                if (isset($_GET['delete'])) {
                    $deleteId = $_GET['delete'];
                    $deleteQuery = "DELETE FROM product WHERE id = :id";
                    $deleteStmt = $pdo->prepare($deleteQuery);
                    $deleteStmt->bindParam(':id', $deleteId, PDO::PARAM_INT);
                    $deleteStmt->execute();
                }
                   if(isset($_POST['add'] )){
                    $newName = $_POST['new_name'];
                    $newPrice = $_POST['new_price'];
                    $newQuantity = $_POST['new_quantity'];
                    $newType = $_POST['new_type'];
                    $insertQuery = "INSERT INTO product (NAME, price, quantity, type) VALUES (:name, :price, :quantity, :type)";
                    $insertStmt = $pdo->prepare($insertQuery);
                    $insertStmt->bindParam(':name', $newName, PDO::PARAM_STR);
                    $insertStmt->bindParam(':price', $newPrice, PDO::PARAM_INT);
                    $insertStmt->bindParam(':quantity', $newQuantity, PDO::PARAM_INT);
                    $insertStmt->bindParam(':type', $newType, PDO::PARAM_STR);
                    
                    // Execute the update query
                    if ($insertStmt->execute()) {
                        echo "Record inseted successfully!";
                    } else {
                        echo "Error updating record: " . $updateStmt->errorInfo()[2];
                    }
        
        
                
                   }

                // Handle record update if form data is submitted
                if (isset($_POST['update'])) {
                    $updateId = $_POST['id'];
                    $newName = $_POST['new_name'];
                    $newPrice = $_POST['new_price'];
                    $newQuantity = $_POST['new_quantity'];
                    $newType = $_POST['new_type'];
                    
                    // Create an SQL query to update the record
                    $updateQuery = "UPDATE product SET NAME = :name, price = :price, quantity = :quantity, type = :type WHERE id = :id";
                    $updateStmt = $pdo->prepare($updateQuery);
                    $updateStmt->bindParam(':name', $newName, PDO::PARAM_STR);
                    $updateStmt->bindParam(':price', $newPrice, PDO::PARAM_INT);
                    $updateStmt->bindParam(':quantity', $newQuantity, PDO::PARAM_INT);
                    $updateStmt->bindParam(':type', $newType, PDO::PARAM_STR);
                    $updateStmt->bindParam(':id', $updateId, PDO::PARAM_INT);
                    
                    // Execute the update query
                    if ($updateStmt->execute()) {
                        echo "Record updated successfully!";
                    } else {
                        echo "Error updating record: " . $updateStmt->errorInfo()[2];
                    }
                }

                $query = "SELECT * FROM product";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    echo '<form method="post" action="">';
                    echo '<tr>';
                    echo '<td>' . $row['id'] . '</td>';
                    echo '<td><input type="text" name="new_name" value="' . $row['NAME'] . '"></td>';
                    echo '<td><input type="text" name="new_price" value="' . $row['price'] . '"></td>';
                    echo '<td><input type="text" name="new_quantity" value="' . $row['quantity'] . '"></td>';
                    echo '<td><input type="text" name="new_type" value="' . $row['type'] . '"></td>';
                    echo '<td>';
                    echo '<a href="?delete=' . $row['id'] . '">Delete</a>';
                    echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
                    echo '<input type="submit" name="update" value="Update">';
                    echo '</td>';
                    echo '</tr>';
                    echo '</form>';
                }

            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }

            // Close the connection when you're done
            $pdo = null;
        ?>
    </table>

    <!-- Add a button for some purpose -->
    <button type="button">Click Me</button>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <title>Data from Database</title>
</head>
<body>
    <h2>Add a New Product</h2>
    <form method="post" action="">
        <label for="new_name">Name:</label>
        <input type="text" name="new_name" required><br>

        <label for="new_price">Price:</label>
        <input type="text" name="new_price" required><br>

        <label for="new_quantity">Quantity:</label>
        <input type="text" name="new_quantity" required><br>

        <label for="new_type">Type:</label>
        <input type="text" name="new_type" required><br>


        <input type="submit" name="add" value="Add Product">
    </form>

    <!-- Rest of your code -->
</body>
</html>

