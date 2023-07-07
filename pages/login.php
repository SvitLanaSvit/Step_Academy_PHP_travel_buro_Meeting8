<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<style>
    body {
        background-color: transparent;
    }
</style>

<body>
    <?
    include_once("functions.php");
    $link = connect_to_db("localhost", "root", "", "traveldb", 3307);
    if (!isset($_POST['submit'])) {
    ?>
        <div class="container">
            <h2>Log in</h2>
            <form method="POST">
                <div class="mb-3 w-25">
                    <label for="login">Login:</label>
                    <input type="login" class="form-control" id="login" name="login" required>
                </div>

                <div class="mb-3 w-25">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="btn-group">
                    <button type="submit" name="submit" class="btn btn-primary">Log in</button>
                </div>
            </form>
        </div>
    <? } else {
        include_once("functions.php");
        $isLogIn = false;
        $iaPaswordVerify = false;

        if (isset($_POST['submit'])) {
            $login = $_POST['login'];
            $password = $_POST['password'];

            $res = getUsersFromSQL("localhost", "root", "", "traveldb", 3307);
            while ($row = mysqli_fetch_array($res)) {
                $iaPaswordVerify = password_verify($password, $row[3]);
                if ($login == $row[1] && $iaPaswordVerify) {
                    $isLogIn = true;
                    break;
                }
            }

            if ($isLogIn) {
                $roleUser = getRoleUser("localhost", "root", "", "traveldb", 3307, $login);
                $idUser = getIdUser("localhost", "root", "", "traveldb", 3307, $login);
                if ($roleUser != null) {
                    session_start();
                    $_SESSION['login'] = $login;
                    $_SESSION['roleUser'] = $roleUser;
                    $_SESSION['id'] = $idUser;
                    echo "<div style='color: green; text-align: center;'>You have successfully passed the verification</div>";
                    echo "<script>
                                setTimeout(()=>{
                                    location = 'index.php?page=1';
                                }, 2000)
                            </script>";
                } else {
                    echo "<script>alert('The role of user is empty!')</script>";
                    echo "<script>
                                setTimeout(()=>{
                                    location = 'index.php?page=1';
                                }, 2000)
                            </script>";
                }
            } else {
                if (isset($_SESSION['login'])) {
                    unset($_SESSION['login']);
                    unset($_SESSION['roleUser']);
                }
                echo "<div style='color: red; text-align: center;'>Email or password are not correct!</div>";
                echo "<script>
                                setTimeout(()=>{
                                    location = 'index.php?page=5';
                                }, 2000)
                            </script>";
            }
        }
    }
    ?>
</body>

</html>