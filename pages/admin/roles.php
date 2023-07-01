<?
if (isset($_SESSION['roleadderr'])) {
    echo "<div class='alert alert-warning'>" . $_SESSION["roleadderr"] . "</div>";
}
?>

<table class="table table-stripped mb-3">
    <thead>
        <tr>
            <th>Id</th>
            <th>Role name</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?
        $query16 = "SELECT * FROM roles";
        $res = mysqli_query($link, $query16);
        $err = mysqli_errno($link);
        if ($err) {
            echo "<div class='alert alert-warning'>$err</div>";
        } else {
            while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
                echo "<tr>";
                echo "<td>$row[0]</td>";
                echo "<td>$row[1]</td>";
                echo "<td><input type='checkbox' class='form-check-input' name='deliroles[]' value='" . $row[0] . "' form='roleform'/></td>";
                echo "</tr>";
            }
        }
        mysqli_free_result($res);
        ?>
    </tbody>
</table>
<form method="post" id="roleform">
    <div class="mb-3">
        <label for="rolename" class="form-label">Role name</label>
        <input type="text" class="form-control" id="rolename" placeholder="Add new role name..." name="rolename">
    </div>

    <button type="submit" class="btn btn-sm btn-success" name='addrole'>Add</button>
    <button type="submit" class="btn btn-sm btn-warning" name='deleterole'>Delete</button>
</form>
<?
if (isset($_POST['addrole'])) {
    $rolename = $_POST['rolename'];

    $q17 = "INSERT INTO roles(`RoleName`)VALUES(\"$rolename\")";
    $res = mysqli_query($link, $q17);
    $err = mysqli_errno($link);
    if ($err) {
        $_SESSION["roleadderr"] = "Error when adding role!";
    } else {
        unset($_SESSION["roleadderr"]);
        echo "<script>location = document.URL</script>";
    }
    mysqli_free_result($res);
}

if (isset($_POST['deleterole'])) {
    $deliroles = $_POST['deliroles'];
    $count = count($deliroles);
    foreach ($deliroles as $roleId) {
        $q18 = "DELETE FROM roles WHERE id = $roleId";
        mysqli_query($link, $q18);
    }

    echo "<script>alert('$count images were deleted!');
                                location = document.URL
                            </script>";
}
?>