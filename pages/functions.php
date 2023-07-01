<?
function connect_to_db($host, $username, $password, $dbname, $port){
    $link = mysqli_connect($host, $username, $password, $dbname, $port) or die("Could not establish connection with server");
    mysqli_query($link, "set names 'utf8'");
    return $link;
}

function hashPasswor($password){
    return password_hash($password, PASSWORD_BCRYPT);
}

function validatePassword($password){
    $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d])\S{6,}$/';
    return preg_match($passwordRegex, $password);
}

function getUsersFromSQL($host, $username, $password, $dbname, $port){
    $link = connect_to_db($host, $username, $password, $dbname, $port);
    $queryText = "SELECT * FROM users";
    return mysqli_query($link, $queryText);
}

function register($host, $username, $password, $dbname, $port, $user){
    $link = connect_to_db($host, $username, $password, $dbname, $port);
    $queryText = "INSERT INTO users(`Login`, `Email`, `Passwrd`)VALUES('$user->login', '$user->email', '$user->password')";
    try{
        mysqli_query($link, $queryText);
        echo "<script>alert('Login successful!')</script>";
        echo "<script>
                setTimeout(()=>{
                    location = 'index.php?page=1'
                }, 2500);
            </script>";
    }
    catch(mysqli_sql_exception $ex){
        if($ex->getCode() == 1062){
            echo "<script>alert('Login exists alredy! You should change login!')</script>";
            echo "<script>
                    setTimeout(()=>{
                        location = 'index.php?page=4'
                    }, 2500);
                </script>";
        }
        else{
            echo "<script>alert('Error:". $ex->getMessage()."')</script>";
        }
    }
}
