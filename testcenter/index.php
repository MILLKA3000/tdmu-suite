<?PHP 
require("auth.php");
if ($_SESSION['login_name']&&$_SESSION['role'] =="admin")
{
    
    require("header.php");
    require("menu.php"); 
    echo "<br><div style='background-color:white;'>";
    include("graf/index.html");
    echo "</div>";
}
if ($_SESSION['login_name']&&$_SESSION['role'] =="student")
{
    
    require("header.php");
    require("menu_stud.php");
    echo "<br><div style='background-color:white;'>";
    include("graf/index.html"); 
    echo "</div>";
}
include('footer.php');             
?>