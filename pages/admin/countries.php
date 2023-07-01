<?
if (isset($_SESSION['countryadderr'])) {
    echo "<div class='alert alert-warning'>" . $_SESSION["countryadderr"] . "</div>";
}
?>

<table class="table table-stripped mb-3">
    <thead>
        <tr>
            <th>Id</th>
            <th>Country name</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?
        $query1 = "SELECT * FROM countries";
        $res = mysqli_query($link, $query1);
        $err = mysqli_errno($link);
        if ($err) {
            echo "<div class='alert alert-warning'>$err</div>";
        } else {
            while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
                echo "<tr>";
                echo "<td>$row[0]</td>";
                echo "<td>$row[1]</td>";
                echo "<td><input type='checkbox' class='form-check-input' name='delcountries[]' value='" . $row[0] . "' form='countryform'/></td>";
                echo "</tr>";
            }
        }
        mysqli_free_result($res);
        ?>
    </tbody>
</table>
<form method="post" id="countryform">
    <div class="mb-3">
        <label for="countryname" class="form-label">Country name</label>
        <input type="text" class="form-control" id="countryname" placeholder="Add new country..." name="countryname">
    </div>
    <button type="submit" class="btn btn-sm btn-success" name='addcountry'>Add</button>
    <button type="submit" class="btn btn-sm btn-warning" name='deletecountry'>Delete</button>
</form>
<?
if (isset($_POST['addcountry'])) {
    $countryname = $_POST['countryname'];
    echo $countryname;
    $q2 = "INSERT INTO countries(`Country`)VALUES('$countryname')";
    $res = mysqli_query($link, $q2);
    $err = mysqli_errno($link);
    if ($err) {
        $_SESSION["countryadderr"] = "Error when adding country!";
    } else {
        unset($_SESSION["countryadderr"]);
        echo "<script>
                                location = document.URL
                            </script>";
    }
    mysqli_free_result($res);
}

if (isset($_POST['deletecountry'])) {
    $delcountries = $_POST['delcountries'];
    $count = count($delcountries);
    foreach ($delcountries as $countryId) {
        $q3 = "DELETE FROM countries WHERE id = $countryId";
        mysqli_query($link, $q3);
    }

    echo "<script>alert('$count countries were deleted!');
                                location = document.URL
                            </script>";
}
?>