<?php

session_start();
$db = new PDO('mysql:host=localhost;dbname=yoga;charset=UTF8', "ktranskz_ktrans", "1qaZXsw2", array(PDO::ATTR_PERSISTENT => true));
//$db = new PDO('mysql:host=srv-pleskdb15.ps.kz:3306;dbname=yogkz1_wp_57pw3;charset=UTF8', "yogkz_wp_j409e", "3qKD#Hd5x1", array(PDO::ATTR_PERSISTENT => true));

function mres($value){
	$search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
	$replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");

	return str_replace($search, $replace, $value);
}
function has_rights($perm_string){
	global $db;
	$stt = $db->prepare('SELECT COUNT(*) FROM auth_user_user_permissions WHERE permission_id = (SELECT id FROM auth_permission WHERE codename = ?) AND user_id = ?');
	$stt->bindParam(1, $perm_string);
	$stt->bindParam(2, $_SESSION["id"]);
	$stt->execute();
	$perm_id = $stt->fetch();
	if($perm_id[0] > 0){
		return true;
	}
	return false;
}

function get_month_name($num){
	switch($num){
		case '01':
		return "января";
		break;
		case '02':
		return "Февраля";
		break;
		case '03':
		return "марта";
		break;
		case '04':
		return "апреля";
		break;
		case '05':
		return "мая";
		break;
		case '06':
		return "июня";
		break;
		case '07':
		return "июля";
		break;
		case '08':
		return "августа";
		break;
		case '09':
		return "сентября";
		break;
		case '10':
		return "октября";
		break;
		case '11':
		return "ноября";
		break;
		case '12':
		return "декабря";
		break;
		default:
		break;
	}
}
	function dayWeek($num){
		switch($num){
			case 1:
			return "Понедельник ";
			break;
			case 2:
			return "Вторник ";
			break;
			case 3:
			return "Среда ";
			break;
			case 4:
			return "Четверг ";
			break;
			case 5:
			return "Пятница ";
			break;
			case 6:
			return "Суббота ";
			break;
			case 7:
			return "Воскресенье ";
			break;
		}
	}
	function month($num){
		switch($num){
			case '01':
			return "Январь";
			break;
			case '02':
			return "Февраль";
			break;
			case '03':
			return "Март";
			break;
			case '04':
			return "Апрель";
			break;
			case '05':
			return "Май";
			break;
			case '06':
			return "Июнь";
			break;
			case '07':
			return "Июль";
			break;
			case '08':
			return "Август";
			break;
			case '09':
			return "Сентябрь";
			break;
			case '10':
			return "Октябрь";
			break;
			case '11':
			return "Ноябрь";
			break;
			case '12':
			return "Декабрь";
			break;
			default:
			break;
		}
	}
?>