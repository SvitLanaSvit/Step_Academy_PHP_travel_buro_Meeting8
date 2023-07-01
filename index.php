<?
    session_start();    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        html{
            background-image: url('/images/sand_pebbles5.jpg');
            background-size: cover;
            background-repeat: repeat;
            background-position: center center;
            height: 100%;
        }   

        body {
            background-color: transparent;
        }

        section>.container>.row>.col>.container>.row>.col>.table>thead>tr>th, section>.container>.row>.col>.container>.row>.col>.table>tbody>tr>td{
            background-color: transparent;
        }

        section>.container>.row>.col>.container>.row>.col{
            border: 1px solid black;
            border-radius: 10px;
        }
        h3{
            text-shadow: 2px 2px #ffcc00;
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        section{
            margin-top: 70px;
        }
    </style>
</head>
<body>
    <?
        if(isset($_GET["page"])){
            $page = $_GET["page"];
        }
        else{
            $page=1;
        }
        include_once("pages/menu.php")
    ?>
    
    <section>
        <div class="container">
            <div class="row">
                <div class="col">
                    <?
                        // if(isset($_GET["page"])){
                        //     $page = $_GET["page"];

                            switch($page){
                                case 1: 
                                    include_once("pages/tours.php");
                                    break;
                                case 2: 
                                    include_once("pages/comments.php");
                                    break;
                                case 3: 
                                    include_once("pages/admin.php");
                                    break;
                                case 4: 
                                    include_once("pages/registration.php");
                                    break;
                                default: echo "<h2>Page does not found!</h2>";
                            }
                            
                        //}else include_once("pages/tours.php");
                    ?>
                </div>
            </div>
        </div>
    </section>

<div class="container">
  <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
    <div class="col-md-4 d-flex align-items-center">
      <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
        <svg class="bi" width="30" height="24"><use xlink:href="#bootstrap"></use></svg>
      </a>
      <span class="mb-3 mb-md-0 text-body-secondary">© 2023 Company, Inc</span>
    </div>

    <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
      <li class="ms-3"><a class="text-body-secondary" href="#"><i class="bi bi-twitter"></i><use xlink:href="#twitter"></use></svg></a></li>
      <li class="ms-3"><a class="text-body-secondary" href="#"><i class="bi bi-instagram"></i><use xlink:href="#instagram"></use></svg></a></li>
      <li class="ms-3"><a class="text-body-secondary" href="#"><i class="bi bi-facebook"></i><use xlink:href="#facebook"></use></svg></a></li>
    </ul>
  </footer>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

</body>
</html>