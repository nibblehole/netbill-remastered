<?php
session_start();
session_destroy(); 
//header("location:login.php"); // mengalihkan halaman ke login.php
echo "<meta HTTP-EQUIV='REFRESH' content='0; url=login.php'>";
?>