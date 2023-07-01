<?
if (isset($_SESSION['useradderr'])) {
    echo "<div class='alert alert-warning'>" . $_SESSION["useradderr"] . "</div>";
}
?>

<table class="table table-stripped mb-3">
    <thead>
        <tr>
            <th>Id</th>
            <th>Login</th>
            <th>Email</th>
            <th>Password</th>
            <th>Discount</th>
            <th>Role</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?
        $query18 = "SELECT u.Id, u.Login, u.Email, u.Passwrd, u.Discount, r.RoleName FROM users u LEFT JOIN roles r ON r.Id = u.RoleId";
        $res = mysqli_query($link, $query18);
        $err = mysqli_errno($link);
        if ($err) {
            echo "<div class='alert alert-warning'>$err</div>";
        } else {
            while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
                echo "<tr>";
                echo "<td>$row[0]</td>";
                echo "<td>$row[1]</td>";
                echo "<td>$row[2]</td>";
                echo "<td>$row[3]</td>";
                echo "<td>$row[4]</td>";
                echo "<td>$row[5]</td>";
                echo "<td><input type='checkbox' class='form-check-input' name='delusers[]' value='" . $row[0] . "' form='userform'/></td>";
                echo "</tr>";
            }
        }
        mysqli_free_result($res);
        ?>
    </tbody>
</table>
<form method="post" id="userform" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="login" class="form-label">Login</label>
        <input type="text" class="form-control" id="login" placeholder="Add new login..." name="login">
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" placeholder="Add new email..." name="email">
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" placeholder="Add new password..." name="password">
    </div>

    <div class="mb-3">
        <label for="formFile" class="form-label">Photo</label>
        <input type="file" class="form-control" id="formFile" placeholder="Add new photo..." name="photo">
    </div>

    <div class="mb-3">
        <label for="discount" class="form-label">Discount</label>
        <input type="number" class="form-control" id="discount" placeholder="Add new discount..." name="discount" min="0">
    </div>

    <div class="mb-3">
        <select class="form-select" aria-label="Default select example" name='roleId'>
            <option value=0 selected>Choose role</option>
            <?
            $q19 = "SELECT * FROM roles";
            $res = mysqli_query($link, $q19);
            while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
                echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
            }
            ?>
        </select>
    </div>
    <button type="submit" class="btn btn-sm btn-success" name='adduser'>Add</button>
    <button type="submit" class="btn btn-sm btn-warning" name='deleteuser'>Delete</button>
</form>
<?
if (isset($_POST['adduser'])) {
    include_once("functions.php");

    $roleId = $_POST['roleId'];
    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $discount = $_POST['discount'];
    $blobData = null;

    if (!validatePassword($password)) {
        echo "<script>alert('Password should be at least 6 characters long and contain at least one lowercase character, one uppercase character, and one symbol.')</script>";
        echo "<script>
                            setTimeout(()=>{
                                location = 'index.php?page=3'
                            }, 2500);
                        </script>";
    } else {
        if ($_FILES && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
            $uploadPhoto = $_FILES['photo'];
            $fileTmpPath = $uploadPhoto['tmp_name'];
            $fileSize = $uploadPhoto['size'];
            $fileType = $uploadPhoto['type'];

            $maxFileSize = 500 * 1024; // 500 kB = 500 * 1024;
            if ($fileSize > $maxFileSize) {
                echo "<script>alert('Error: The file size exceeds the maximum limit of 50 kB. You have photo with size $fileSize')</script>";
                echo "<script>
                            setTimeout(()=>{
                                        location = 'index.php?page=3'
                                    }, 2500);
                                </script>";
            } else {
                // Read the file content as binary data
                $fileData = file_get_contents($fileTmpPath);

                // Prepare the binary data as a parameter for database insertion
                $blobData = mysqli_real_escape_string($link, $fileData);
            }
        }

        $passwordHash = hashPasswor($password);

        $q20 = "INSERT INTO users(`Login`, `Email`, `Passwrd`, `Photo`, `Discount`, `RoleId`)VALUES('$login', '$email', '$passwordHash', \"$blobData\", $discount, $roleId)";
        $res = mysqli_query($link, $q20);
        $err = mysqli_errno($link);
        if ($err) {
            $_SESSION["useradderr"] = "Error when adding user!";
        } else {
            unset($_SESSION["useradderr"]);
            echo "<script>location = document.URL</script>";
        }
        mysqli_free_result($res);
    }
}

if (isset($_POST['deleteuser'])) {
    $delusers = $_POST['delusers'];
    $count = count($delusers);
    foreach ($delusers as $userId) {
        $q20 = "DELETE FROM users WHERE id = $userId";
        mysqli_query($link, $q20);
    }

    echo "<script>alert('$count users were deleted!');
                                location = document.URL
                            </script>";
}
?>