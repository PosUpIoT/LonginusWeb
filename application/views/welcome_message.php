<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<h1>Usuários</h1>
	<br>
	<?php foreach ($users as $user) {
		echo $user['name'];
	}; ?>
</body>
</html>