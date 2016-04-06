<?php
$arr = array(1, 2, 3, 4);
$ok = false;
foreach ($arr as &$value) {
    if($value ==9)
    	$ok=true;
}
echo $ok;
print_r($arr);
// $arr vaut maintenant array(2, 4, 6, 8)
unset($value); // Détruit la référence sur le dernier élément
?>