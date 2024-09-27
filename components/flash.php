<?php
if(isset($_SESSION['flash'])){
	echo "<script>alert('".$_SESSION['flash']."');</script>";
	unset($_SESSION['flash']);
}
?>