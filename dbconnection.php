<?php 

try { 
$conn=new PDO('mysql:host=localhost;port=3306;dbname=foodtruckss_store_db','root','');
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}

catch(PDOException $ex)
{
echo ("Internal Login Error, Please Contact Web Site Support");

return;
}
?>