<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        body {
            background-color: transparent;
        }

        .stars i{
            color: #e6e6e6;
            font-size: 35px;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .stars i.active{
            color: #ff9c1a;
        }

        #showListComments{
            margin-bottom: 20px;
        }

        .container .table>thead>tr>th, .container .table>tbody>tr>td{
            background-color: transparent;
        }
    </style>
</head>

<body>
    <?
    include_once("functions.php");
    ?>
        <div class="container">
            <h2>Comments</h2>
            <form method="POST">
                <div class="mb-3 w-25">
                    <input type="hidden" name="userId" value="<? echo $_SESSION['id'] ?>">
                    <select class="form-select" aria-label="Default select example" name='hotelId'>
                        <option value=0 selected>Choose hotel</option>
                        <?
                        $pdo = connect();
                        $q1 = "SELECT * FROM hotels";
                        $res = $pdo->query($q1);
                        while ($row = $res->fetch()) {
                            echo "<option value='" . $row['Id'] . "'>" . $row['HotelName'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3 w-25">
                    <label for="comment">Comment:</label>
                    <textarea class="form-control" placeholder="Leave a comment here" id="comment" name="comment"></textarea>
                </div>


                <div class="mb-3 w-25">
                    <label for="rating">Rating:</label>
                    <div class="stars">
                        <i class="fa-solid fa-star" onclick="handleChange(1)">&#9733;</i>
                        <i class="fa-solid fa-star" onclick="handleChange(2)">&#9733;</i>
                        <i class="fa-solid fa-star" onclick="handleChange(3)">&#9733;</i>
                        <i class="fa-solid fa-star" onclick="handleChange(4)">&#9733;</i>
                        <i class="fa-solid fa-star" onclick="handleChange(5)">&#9733;</i>
                        <input type="hidden" name="rating" id="rating" value="0">
                    </div>
                </div>

                <div class="btn-group">
                    <button type="submit" name="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
        <hr>
        <div class="container">
            <?
                getAllComments($_SESSION['id']);
            ?>    
        </div>
        <script>
            const stars = document.querySelectorAll(".stars i");
            stars.forEach((star,index1)=>{
                star.addEventListener("click", ()=>{
                    stars.forEach((star, index2)=>{
                        index1 >= index2 ? star.classList.add("active") : star.classList.remove("active");
                    })
                });
            });

            function handleChange(stars) {
                console.log("Selected rating: " + stars);
                document.getElementById("rating").value = stars;
            }
        </script>
    <? 
        if (isset($_POST['submit'])) {
            $userId = $_POST['userId'];
            $hotelId = $_POST['hotelId'];
            $comment = $_POST['comment'];
            $rating = $_POST['rating'];

            if($hotelId == 0){
                echo "<script>alert('Hotel was not choosed!')</script>";
                echo "<script>
                        setTimeout(()=>{
                            location = 'index.php?page=2'
                        }, 10);
                    </script>";
            }
            else if($rating == 0){
                echo "<script>alert('Rating was not choosed!')</script>";
                echo "<script>
                        setTimeout(()=>{
                            location = 'index.php?page=2'
                        }, 10);
                    </script>";
            }
            else if($hotelId == 0 && $rating == 0){
                echo "<script>alert('Hotel and rating were not choosed!')</script>";
                echo "<script>
                        setTimeout(()=>{
                            location = 'index.php?page=2'
                        }, 10);
                    </script>";
            }
            else{
                dataCommentsToSQL($userId, $hotelId, $comment, $rating);
                echo "<script>location = document.URL;</script>";
            }
        }
     ?>
</body>

</html>