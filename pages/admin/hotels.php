<?
if (isset($_SESSION['hoteladderr'])) {
    echo "<div class='alert alert-warning'>" . $_SESSION["hoteladderr"] . "</div>";
}
?>

<table class="table table-stripped mb-3">
    <thead>
        <tr>
            <th>Id</th>
            <th>Hotel name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Stars</th>
            <th>City</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?
        $query8 = "SELECT h.Id, h.HotelName, h.Description, h.Price, h.Stars, ci.City FROM hotels h LEFT JOIN cities ci ON ci.Id = h.CityId";
        $res = mysqli_query($link, $query8);
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
                echo "<td><input type='checkbox' class='form-check-input' name='delhotels[]' value='" . $row[0] . "' form='hotelform'/></td>";
                echo "</tr>";
            }
        }
        mysqli_free_result($res);
        ?>
    </tbody>
</table>
<form method="post" id="hotelform">
    <div class="mb-3">
        <label for="hotelname" class="form-label">Hotel name</label>
        <input type="text" class="form-control" id="hotelname" placeholder="Add new hotel..." name="hotelname">
    </div>

    <div class="form-floating">
        <textarea class="form-control" placeholder="Add description..." id="description" name="description"></textarea>
        <label for="description">Description</label>
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" class="form-control" id="price" placeholder="Add price..." min="0" name="price">
    </div>

    <div class="mb-3">
        <label for="stars" class="form-label">Stars</label>
        <select class="form-select" aria-label="Default select example" name='stars'>
            <option value=0 selected>Choose count of stars</option>
            <option value=1>1</option>
            <option value=2>2</option>
            <option value=3>3</option>
            <option value=4>4</option>
            <option value=5>5</option>
        </select>
        <!-- <input type="number" class="form-control" id="stars" placeholder="Add stars from 0 to 5" name="stars" min="0" max="5"> -->
    </div>

    <div class="mb-3">
        <select class="form-select" aria-label="Default select example" name='cityId'>
            <option value=0 selected>Choose city</option>
            <?
            $q9 = "SELECT * FROM cities";
            $res = mysqli_query($link, $q9);
            while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
                echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
            }
            ?>
        </select>
    </div>
    <button type="submit" class="btn btn-sm btn-success" name='addhotel'>Add</button>
    <button type="submit" class="btn btn-sm btn-warning" name='deletehotel'>Delete</button>
</form>
<?
if (isset($_POST['addhotel'])) {
    $cityId = $_POST['cityId'];
    $hotelname = $_POST['hotelname'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stars = $_POST['stars'];

    $q10 = "INSERT INTO hotels(`HotelName`, `Description`, `Price`, `Stars`, `CityId`)VALUES('$hotelname', \"$description\", $price, $stars, $cityId)";
    $res = mysqli_query($link, $q10);
    $err = mysqli_errno($link);
    if ($err) {
        $_SESSION["hoteladderr"] = "Error when adding hotel!";
    } else {
        unset($_SESSION["hoteladderr"]);
        echo "<script>
                                location = document.URL
                            </script>";
    }
    mysqli_free_result($res);
}

if (isset($_POST['deletehotel'])) {
    $delhotels = $_POST['delhotels'];
    $count = count($delhotels);
    foreach ($delhotels as $hotelId) {
        $q11 = "DELETE FROM hotels WHERE id = $hotelId";
        mysqli_query($link, $q11);
    }

    echo "<script>alert('$count hotels were deleted!');
                                location = document.URL
                            </script>";
}
?>