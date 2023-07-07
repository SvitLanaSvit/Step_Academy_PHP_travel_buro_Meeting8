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

function getRoleUser($host, $username, $password, $dbname, $port, $login){
    $link = connect_to_db($host, $username, $password, $dbname, $port);
    $queryText = "SELECT r.RoleName FROM users u LEFT JOIN roles r ON r.Id = u.RoleId WHERE Login = '$login'";
    $res = mysqli_query($link, $queryText);

    if($res && mysqli_num_rows($res)){
        $row = mysqli_fetch_assoc($res);
        return $row['RoleName'];
    }

    return null;
}

function getIdUser($host, $username, $password, $dbname, $port, $login){
    $link = connect_to_db($host, $username, $password, $dbname, $port);
    $queryText = "SELECT Id FROM users WHERE Login = '$login'";
    $res = mysqli_query($link, $queryText);

    if($res && mysqli_num_rows($res)){
        $row = mysqli_fetch_assoc($res);
        return $row['Id'];
    }

    return null;
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

function connect($host = 'localhost:3307', $user='root', $password = '', $dbname = 'traveldb'){
    $cs = "mysql:host=$host;dbname=$dbname;charset=utf8;";
    $options = array(
        PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES UTF8"
    );

    try{
        $pdo = new PDO($cs, $user, $password, $options);
        return $pdo;
    }
    catch(PDOException $excep){
        echo $excep->getMessage();
        return false;
    }
}

function getAllComments($userId){
    $pdo = connect();
    $ps = $pdo->prepare("SELECT c.Id, h.HotelName, c.Comment, c.Rating FROM comments c LEFT JOIN hotels h ON c.HotelId = h.Id WHERE c.UserId = ?");
    $ps->bindParam(1, $userId);
    $ps->execute();
    $ps->setFetchMode(PDO::FETCH_NUM);
    echo "<table class='table table-stripped'><thead><tr><th>#</th><th>Hotel name</th><th>Comment</th></th><th>Rating</th></tr></thead>";
    echo "<tbody>";
    while($row = $ps->fetch()){
        echo "<tr>";
        echo "<td>".$row[0]."</td>";
        echo "<td>".$row[1]."</td>";
        echo "<td>".$row[2]."</td>";
        echo "<td>".$row[3]."</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
}

function dataCommentsToSQL($userId, $hotelId, $comment, $rating){
    $pdo = connect();
    $ps = $pdo->prepare("INSERT INTO comments(`UserId`, `HotelId`, `Comment`, `Rating`)VALUES(:UserId, :HotelId, :Comment, :Rating)");
    $ps->execute(array("UserId"=>$userId, "HotelId"=>$hotelId, "Comment"=>$comment, "Rating"=>$rating));
}
