<?
if (isset($_SESSION['cityadderr'])) {
    echo "<div class='alert alert-warning'>" . $_SESSION["cityadderr"] . "</div>";
}
?>

<table class="table table-stripped mb-3">
    <thead>
        <tr>
            <th>Id</th>
            <th>City name</th>
            <th>Country</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?
        $query4 = "SELECT ci.Id, ci.City, co.Country FROM cities ci LEFT JOIN countries co ON ci.CountryId = co.Id";
        $res = mysqli_query($link, $query4);
        $err = mysqli_errno($link);
        if ($err) {
            echo "<div class='alert alert-warning'>$err</div>";
        } else {
            while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
                echo "<tr>";
                echo "<td>$row[0]</td>";
                echo "<td>$row[1]</td>";
                echo "<td>$row[2]</td>";
                echo "<td><input type='checkbox' class='form-check-input' name='delcities[]' value='" . $row[0] . "' form='cityform'/></td>";
                echo "</tr>";
            }
        }
        mysqli_free_result($res);
        ?>
    </tbody>
</table>
<form method="post" id="cityform">
    <div class="mb-3">
        <label for="cityname" class="form-label">City name</label>
        <input type="text" class="form-control" id="cityname" placeholder="Add new city..." name="cityname">
    </div>

    <div class="mb-3">
        <select class="form-select" aria-label="Default select example" name='countryId'>
            <option value=0 selected>Choose country</option>
            <?
            $q5 = "SELECT * FROM countries";
            $res = mysqli_query($link, $q5);
            while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
                echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
            }
            ?>
        </select>
    </div>
    <button type="submit" class="btn btn-sm btn-success" name='addcity'>Add</button>
    <button type="submit" class="btn btn-sm btn-warning" name='deletecity'>Delete</button>
</form>
<?
if (isset($_POST['addcity'])) {
    $countryId = $_POST['countryId'];
    $cityname = $_POST['cityname'];
    echo $cityname;
    $q6 = "INSERT INTO cities(`City`, `CountryId`)VALUES('$cityname', $countryId)";
    $res = mysqli_query($link, $q6);
    $err = mysqli_errno($link);
    if ($err) {
        $_SESSION["cityadderr"] = "Error when adding city!";
    } else {
        unset($_SESSION["cityadderr"]);
        echo "<script>location = document.URL</script>";
    }
    mysqli_free_result($res);
}

if (isset($_POST['deletecity'])) {
    $delcities = $_POST['delcities'];
    $count = count($delcities);
    foreach ($delcities as $cityId) {
        $q7 = "DELETE FROM cities WHERE id = $cityId";
        mysqli_query($link, $q7);
    }

    echo "<script>alert('$count cities were deleted!');
                                location = document.URL
                            </script>";
}
?>