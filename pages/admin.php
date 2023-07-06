<?
include_once("functions.php");
$link = connect_to_db("localhost", "root", "", "traveldb", 3307);
?>

<div class="container">
    <h2>Admin panel</h2>
    <div class="row row-cols-2">
        <div class="col">
            <h3>Countries</h3>
            <?
            include_once("admin/countries.php");
            ?>
        </div>
        <div class="col">
            <h3>Cities</h3>
            <?
            include_once("admin/cities.php");
            ?>
        </div>
        <div class="col">
            <h3>Hotels</h3>
            <?
            include_once("admin/hotels.php");
            ?>
        </div>
        <div class="col">
            <h3>Images</h3>
            <?
            include_once("admin/images.php");
            ?>
        </div>
        <div class="col">
            <h3>Roles</h3>
            <?
            include_once("admin/roles.php");
            ?>
        </div>
        <div class="col">
            <h3>Users</h3>
            <?
            include_once("admin/users.php");
            ?>
        </div>
        <div class="col">

        </div>
    </div>
</div>