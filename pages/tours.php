<?
include_once("functions.php");
$link = connect_to_db("localhost", "root", "", "traveldb", 3307);
?>
<div class="container">
    <h2>Tours</h2>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
        <?
        $query1 = "SELECT h.Id, h.HotelName, h.Description, h.Price, h.Stars, ci.City FROM hotels h LEFT JOIN cities ci ON ci.Id = h.CityId";
        $res = mysqli_query($link, $query1);
        $err = mysqli_errno($link);
        if ($err) {
            echo "<div class='alert alert-warning'>$err</div>";
        } else {
            while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
                $q2 = "SELECT im.ImagePath FROM Hotels h LEFT JOIN Images im ON h.Id = im.HotelId Where h.Id = ".$row[0]." LIMIT 1";
                $res2 = mysqli_query($link, $q2);

                if(mysqli_num_rows($res2) > 0){
                    $imageRow = mysqli_fetch_array($res2, MYSQLI_NUM);
                    $imagePath = $imageRow[0];
                }
                else{
                    $imagePath = "/images/sand_pebbles1.jpg";
                }
                
        ?>
                <div class="card mb-3">
                    <img src=<? echo $imagePath; ?> class="card-img-top" alt="<?php echo $row[1]; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?echo $row[1]?></h5>
                        <p class="card-text"><?echo $row[2]?></p>
                        <p class="card-text"><small class="text-body-secondary"><?echo $row[3]?>$</small></p>
                    </div>
                </div>
        <?
            }
        }
        mysqli_free_result($res); ?>

    </div>
</div>