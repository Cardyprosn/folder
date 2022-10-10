<?php  $user = 'id19666067_cardypro';
$pass = 'Mwrhv.20042004';
try
{
	$db = new PDO('mysql:host=localhost;dbname=id19666067_utilisateurs;charset=utf8', $user, $pass,
[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);
	
}
catch (PDOException $e)
{
        print('Erreur : ') . $e->getMessage() . "<br/>";
        die;
}

?>