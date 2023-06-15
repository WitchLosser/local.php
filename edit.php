<?php
$id=$_GET["id"];
    include $_SERVER["DOCUMENT_ROOT"] . "/connection_database.php";
    if (isset($dbh)) {
        if (!isset($_GET['id'])) {
            die('User ID not provided.');
        }
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            die('User not found.');
        }
    }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the updated data from the form submission
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];

    $image = $user['image']; // Preserve the existing image path if no new image is uploaded
    if ($_FILES['image']['tmp_name']) {
        $fileName = uniqid() . ".jpg";
        $uploadDir = $_SERVER["DOCUMENT_ROOT"] . '/uploads/'; // Directory where uploaded images will be stored
        unlink($uploadDir . $user['image']);
        $imageTemp = $_FILES["image"]["tmp_name"];
        $imagePath = $uploadDir . $fileName;

        // Move the uploaded image to the designated directory
        if (move_uploaded_file($imageTemp, $imagePath)) {

            $image = $fileName; // Set the new image path if the upload is successful
        }
    }


    // Update the user record in the database
    $sql = "UPDATE users SET name = :name, email = :email, password = :password, phone = :phone, image = :image WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([
        'name' => $name,
        'email' => $email,
        'password' => $password,
        'phone' => $phone,
        'image' => $image,
        'id' => $id,
    ]);
    $dbh = null;
    header('Location: /');
    exit;
}
?>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/head.php"; ?>

    <div class="container">
        <h1 class="text-center">Зміна</h1>
        <form class="row col-md-8 offset-md-2 g-3" method="post" enctype="multipart/form-data">
            <div class="col-md-6">
                <label for="name" class="form-label">Ім'я</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $user['name']; ?>">
            </div>
            <div class="col-md-6">
                <label for="password" class="form-label">Пароль</label>
                <input type="password" class="form-control" id="password" name="password" value="<?php echo $user['password']; ?>">
            </div>
            <div class="col-12">
                <label for="email" class="form-label">Електронна пошта</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="itstep@gmail.com" value="<?php echo $user['email']; ?>">
            </div>
            <div class="col-12">
                <label for="phone" class="form-label">Телефон</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="38(067)43 24 344" value="<?php echo $user['phone']; ?>">
            </div>
            <div class="col-12">
                <label for="image" class="form-label">Image input </label>
                <input name="image" class="form-control" type="file" id="image"  onchange="preview()" >
            </div>
            <?php if ($user['image']) : ?>
                <div class="form-group mb-3">
                    <label class="mb-3">Current Image</label>
                    <br>
                    <img id="frame" src="/uploads/<?php echo $user['image']; ?>" alt="Current Image" style="max-width: 200px;">
                </div>
            <?php endif; ?>
            <div class="row justify-content-between">

                <a href="/" class="btn btn-dark col-5 ">На головну</a>
                <button type="submit" id="acceptEdit"  class="btn btn-primary col-5 ">Змінити</button>
            </div>
        </form>
    </div>
    <script>
        function preview() {
            frame.src = URL.createObjectURL(event.target.files[0]);
        }

    </script>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/footer.php"; ?>