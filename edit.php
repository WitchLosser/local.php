<?php
$id=$_GET["id"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include $_SERVER["DOCUMENT_ROOT"] . "/connection_database.php";
    if (isset($dbh)) {
        $stm = $dbh->query("SELECT  id, name, email, phone, image FROM users WHERE $id = ?");
        if (mysqli_num_rows($stm) > 0) {
            $user = mysqli_fetch_array($stm);
        }
    }
}
?>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/head.php"; ?>

    <div class="container">
        <h1 class="text-center">Зміна</h1>
        <form class="row col-md-8 offset-md-2 g-3" method="post" enctype="multipart/form-data">
            <div class="col-md-6">
                <label for="name" class="form-label">Ім'я</label>
                <input type="text" class="form-control" id="name" name="name" value="">
            </div>
            <div class="col-md-6">
                <label for="password" class="form-label">Пароль</label>
                <input type="password" class="form-control" id="password" name="password" value="">
            </div>
            <div class="col-12">
                <label for="email" class="form-label">Електронна пошта</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="itstep@gmail.com" value="">
            </div>
            <div class="col-12">
                <label for="phone" class="form-label">Телефон</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="38(067)43 24 344" value="">
            </div>
            <div class="col-12">
                <label for="formFile" class="form-label">Image input </label>
                <input name="imageFile" class="form-control" type="file" id="formFile" onchange="preview()">
            </div>
            <div class="col-12 mb-3" >
                <img id="frame" src="" class="img-fluid rounded" />
            </div>
            <div class="row justify-content-between">

                <a href="/" class="btn btn-dark col-5 ">На головну</a>
                <button type="submit" class="btn btn-primary col-5 ">Реєстрація</button>
            </div>
        </form>
    </div>
    <script>
        function preview() {
            frame.src = URL.createObjectURL(event.target.files[0]);
        }

    </script>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/footer.php"; ?>