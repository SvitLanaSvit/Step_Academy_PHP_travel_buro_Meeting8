<?
include_once("functions.php");
$link = connect_to_db("localhost", "root", "", "traveldb", 3307);
$ct1 = "CREATE TABLE countries(
    Id int primary key not null auto_increment,
    Country varchar(50) not null) default charset = 'utf8'";

$ct2 = "CREATE TABLE cities(
    Id int primary key not null auto_increment,
    City varchar(50) not null,
    CountryId int not null,
    FOREIGN KEY (CountryId) REFERENCES countries(Id) ON DELETE CASCADE) default charset = 'utf8'";

$ct3 = "CREATE TABLE hotels(
    Id int primary key not null auto_increment,
    HotelName varchar(64) not null,
    Description text,
    Price double,
    Stars int,
    CityId int not null,
    FOREIGN KEY (CityId) REFERENCES cities(Id) ON DELETE CASCADE,
    Constraint CHK_Hotel_HotelsStars CHECK (Stars >0 AND Stars < 6)) default charset = 'utf8'";

$ct4 = "CREATE TABLE images(
    Id int primary key not null auto_increment,
    ImagePath varchar(255) not null,
    HotelId int not null,
    FOREIGN KEY (HotelId) REFERENCES hotels(Id) ON DELETE CASCADE) default charset = 'utf8'";

$ct5 = "CREATE TABLE roles(
    Id int primary key not null auto_increment,
    RoleName varchar(64) not null unique) default charset = 'utf8'";

$ct6 = "CREATE TABLE users(
    Id int primary key not null auto_increment,
    Login varchar(64) not null unique,
    Email varchar(255) not null,
    Passwrd varchar(64) not null,
    Photo mediumblob,
    Discount double default 0,
    RoleId int not null default 2,
    FOREIGN KEY (RoleId) REFERENCES roles(Id)) default charset = 'utf8'";

    mysqli_query($link, $ct1);
    $err = mysqli_errno($link);
    if($err){
        echo "<div class='alert alert-danger' role='alert'>Db error $err. Table countries.</div>";
    }

    mysqli_query($link, $ct2);
    $err = mysqli_errno($link);
    if($err){
        echo "<div class='alert alert-danger' role='alert'>Db error $err. Table sities.</div>";
    }

    mysqli_query($link, $ct3);
    $err = mysqli_errno($link);
    if($err){
        echo "<div class='alert alert-danger' role='alert'>Db error $err. Table hotels.</div>";
    }

    mysqli_query($link, $ct4);
    $err = mysqli_errno($link);
    if($err){
        echo "<div class='alert alert-danger' role='alert'>Db error $err. Table images.</div>";
    }

    mysqli_query($link, $ct5);
    $err = mysqli_errno($link);
    if($err){
        echo "<div class='alert alert-danger' role='alert'>Db error $err. Table roles.</div>";
    }

    mysqli_query($link, $ct6);
    $err = mysqli_errno($link);
    if($err){
        echo "<div class='alert alert-danger' role='alert'>Db error $err. Table users.</div>";
    }
