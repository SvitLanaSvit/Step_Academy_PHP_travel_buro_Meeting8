<?
if (isset($_SESSION['imageadderr'])) {
    echo "<div class='alert alert-warning'>" . $_SESSION["imageadderr"] . "</div>";
}
?>

<table class="table table-stripped mb-3">
    <thead>
        <tr>
            <th>Id</th>
            <th>Image path</th>
            <th>Hotel</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?
        $query12 = "SELECT img.Id, img.ImagePath, h.HotelName FROM images img LEFT JOIN hotels h ON h.Id = img.HotelId";
        $res = mysqli_query($link, $query12);
        $err = mysqli_errno($link);
        if ($err) {
            echo "<div class='alert alert-warning'>$err</div>";
        } else {
            while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
                echo "<tr>";
                echo "<td>$row[0]</td>";
                echo "<td>$row[1]</td>";
                echo "<td>$row[2]</td>";
                echo "<td><input type='checkbox' class='form-check-input' name='delimages[]' value='" . $row[0] . "' form='imgform'/></td>";
                echo "</tr>";
            }
        }
        mysqli_free_result($res);
        ?>
    </tbody>
</table>
<form method="post" id="imgform">
    <div class="mb-3">
        <label for="imagepath" class="form-label">Image path</label>
        <input type="text" class="form-control" id="imagepath" placeholder="Add new image path..." name="imagepath">
    </div>

    <div class="mb-3">
        <select class="form-select" aria-label="Default select example" name='hotelId'>
            <option value=0 selected>Choose image</option>
            <?
            $q13 = "SELECT * FROM hotels";
            $res = mysqli_query($link, $q13);
            while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
                echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
            }
            ?>
        </select>
    </div>
    <button type="submit" class="btn btn-sm btn-success" name='addimage'>Add</button>
    <button type="submit" class="btn btn-sm btn-warning" name='deleteimage'>Delete</button>
</form>
<?
if (isset($_POST['addimage'])) {
    $hotelId = $_POST['hotelId'];
    $imagepath = $_POST['imagepath'];

    $q14 = "INSERT INTO images(`ImagePath`, `HotelId`)VALUES(\"$imagepath\", $hotelId)";
    $res = mysqli_query($link, $q14);
    $err = mysqli_errno($link);
    if ($err) {
        $_SESSION["imageadderr"] = "Error when adding image!";
    } else {
        unset($_SESSION["imageadderr"]);
        echo "<script>location = document.URL</script>";
    }
    mysqli_free_result($res);
}

if (isset($_POST['deleteimage'])) {
    $delimages = $_POST['delimages'];
    $count = count($delimages);
    foreach ($delimages as $imageId) {
        $q15 = "DELETE FROM images WHERE id = $imageId";
        mysqli_query($link, $q15);
    }

    echo "<script>alert('$count images were deleted!');
                                location = document.URL
                            </script>";
}
?>