<?php 
set_time_limit(300);
ini_set('max_execution_time', 300);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title>vgbackup - создание и восстановление резервных копий сайта</title>
</head>
<body>



<h2>vgbackup - Создание резервной копии сайта</h2>

<form method="post">
<?php $name = 'ACTION_TYPE'; ?>
<p class="val-row">
<span>Действие:</span> <select name="<?= $name ?>">
<option <?= (!empty($data[$name]) && $data[$name]=='save')?'selected':'' ?> value="save">Создать</option>
<option <?= (!empty($data[$name]) && $data[$name]=='save')?'reestablish':'' ?> value="reestablish">Восстановить</option>
</select>
</p>
<?php 
$data = $_POST;

$path=__DIR__;
$pathArr = explode('/',__DIR__);
array_pop($pathArr);
$path = implode('/',$pathArr);

$name = 'path'; ?>
<p class="val-row"><span>Путь к файлу vgbackup.sh:</span> <input name="<?= $name ?>" type="text" value="<?= (!empty($data[$name]))?$data[$name]:$path.'/vgbackup.sh' ?>" placeholder=""></p>
<?php $name = 'SITE_NAME'; ?>
<p class="val-row"><span>Имя сайта:</span> <input name="<?= $name ?>" type="text" value="<?= (!empty($data[$name]))?$data[$name]:$_SERVER['HTTP_HOST'] ?>" placeholder=""></p>
<?php $name = 'BACKUP_FOLDER'; ?>
<p class="val-row"><span>Имя папки сайта:</span> <input name="<?= $name ?>" type="text" value="<?= (!empty($data[$name]))?$data[$name]:$_SERVER['HTTP_HOST'] ?>" placeholder=""></p>
<?php $name = 'DB_SERVER'; ?>
<p class="val-row"><span>Сервер БД:</span> <input name="<?= $name ?>" type="text" value="<?= (!empty($data[$name]))?$data[$name]:'localhost' ?>" placeholder=""></p>
<?php $name = 'DB_NAME'; ?>
<p class="val-row"><span>Имя БД:</span> <input name="<?= $name ?>" type="text" value="<?= (!empty($data[$name]))?$data[$name]:'' ?>" placeholder=""></p>
<?php $name = 'DB_USER'; ?>
<p class="val-row"><span>Имя пользователя БД:</span> <input name="<?= $name ?>" type="text" value="<?= (!empty($data[$name]))?$data[$name]:'' ?>" placeholder=""></p>
<?php $name = 'DB_PASS'; ?>
<p class="val-row"><span>Пароль пользователя БД:</span> <input name="<?= $name ?>" type="text" value="<?= (!empty($data[$name]))?$data[$name]:'' ?>" placeholder=""></p>
<?php $name = 'BACKUP_DATE'; ?>
<p class="val-row"><span>Дата (для восстановления формат: гггг-мм-дд)</span> <input name="<?= $name ?>" type="text" value="<?= (!empty($data[$name]))?$data[$name]:'' ?>" placeholder=""></p>
<input class="val-submit" type="submit" value="Выполнить" >
</form>

<?php
$error=false;
if(!empty($data)){

if(empty($data['ACTION_TYPE'])){
	$error = true;
	echo('<p class="error">Введите действие</p>');
}
if($data['ACTION_TYPE']!='save' && $data['ACTION_TYPE']!='reestablish'){
	$error = true;
	echo('<p class="error">Введите действие save или reestablish</p>');
}
if(empty($data['SITE_NAME'])){
	$error = true;
	echo('<p class="error">Введите Имя сайта</p>');
}
if(empty($data['BACKUP_FOLDER'])){
	$error = true;
	echo('<p class="error">Введите Имя папки сайта</p>');
}
if(empty($data['DB_SERVER'])){
	$error = true;
	echo('<p class="error">Введите Сервер БД</p>');
}
if(empty($data['DB_NAME'])){
	$error = true;
	echo('<p class="error">Введите Имя БД</p>');
}
if(empty($data['DB_USER'])){
	$error = true;
	echo('<p class="error">Введите Имя пользователя БД</p>');
}
if(empty($data['DB_PASS'])){
	$error = true;
	echo('<p class="error">Введите Пароль пользователя БД</p>');
}
if(empty($data['DB_PASS'])){
	$error = true;
	echo('<p class="error">Введите Пароль пользователя БД</p>');
}
if($data['ACTION_TYPE']=='reestablish' && empty($data['BACKUP_DATE'])){
	$error = true;
	echo('<p class="error">Введите дату восстановления</p>');
}

$save_command = 'sh /../../../../../../vgbackup.sh "save" "SITE_NAME" "BACKUP_FOLDER" "DB_NAME" "DB_SERVER" "DB_USER" "DB_PASS"';
$reestablish_command = 'sh /../../../../../../vgbackup.sh "reestablish" "SITE_NAME" "BACKUP_FOLDER" "DB_NAME" "DB_SERVER" "DB_USER" "DB_PASS" "2020-05-05"';

if(!$error){
	if($data['ACTION_TYPE']=='save'){
		$save_command = 'sh '.$data['path'].' "save" "'.$data['SITE_NAME'].'" "'.$data['BACKUP_FOLDER'].'" "'.$data['DB_NAME'].'" "'.$data['DB_SERVER'].'" "'.$data['DB_USER'].'" "'.$data['DB_PASS'].'"';
		$output = shell_exec($save_command);
	}
	if($data['ACTION_TYPE']=='reestablish'){
		$reestablish_command = 'sh '.$data['path'].' "reestablish" "'.$data['SITE_NAME'].'" "'.$data['BACKUP_FOLDER'].'" "'.$data['DB_NAME'].'" "'.$data['DB_SERVER'].'" "'.$data['DB_USER'].'" "'.$data['DB_PASS'].'" "'.$data['BACKUP_DATE'].'"';
		$output = shell_exec($reestablish_command);
	}

echo '<p class="succes">Результат: '.$output.'</p>';	
}


}
?>

<h2>Примеры для крона</h2>
<p>Для создания ежедневных резервных копий в автоматическом режиме, поставьте команду на cron:</p>
<p><?= $save_command ?></p>
<p>Для восстановления резервной копии через консоль:</p>
<p><?= $reestablish_command ?></p>

<style>
body {
	background: #f4f4f4;
	color: #686868;
}
.val-row span {
	width: 200px;
    display: block;
    float: left;
}
.val-row {
	
}
.val-row input, .val-row select {
	    width: 300px;
    border: 1px solid #f1efef;
    font-weight: 400;
    font-size: 14px;
    height: auto;
    padding: 1rem 1rem;
}
.val-submit {
	
}
.val-submit {
	    padding: 15px;
}
.error {
	    color: #bc0909;
}
.succes {
	
}
</style>
</body>
</html>