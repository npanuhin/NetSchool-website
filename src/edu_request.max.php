<?php
require_once __DIR__ . '/../src/config.php';
require_once __DIR__ . '/../src/session.php';
include_once __DIR__ . '/lib/simple_html_dom.php';

//jan feb mar apr may jun jul aug sep oct nov dec
$_monthsList = array("Jan" => "января", "Feb" => "февраля", 
"Mar" => "марта", "Apr" => "апреля", "May" => "мая", "Jun" => "июня", 
"Jul" => "июля", "Aug" => "августа", "Sep" => "сентября",
"Oct" => "октября", "Nov" => "ноября", "Dec" => "декабря");


$class = urlencode(mb_convert_encoding($person['class'], 'koi8-r', 'utf-8'));


$nweek = floor(date_create($_POST['day'])->diff(date_create("2020-03-30"))->format('%a')/7) + 1;

$dayText = date_create($_POST['day'])->Format('j') .' '. $_monthsList[date_create($_POST['day'])->Format('M')];

if($_POST['courses']){
	$href = 'http://edu.school.ioffe.ru/tt_special.php';
}
else{
	$href = 'http://edu.school.ioffe.ru/tt_student.php';
}

$result = mb_convert_encoding(file_get_contents($href, false, stream_context_create(array(
    'http' => array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => "nweek={$nweek}&nclass={$class}&nteacher=-" 
    )
))), 'utf-8', 'koi8-r');


$dom = str_get_html($result)->find('table')[0]->find('tbody')[0];

echo "[";

$out = false;
$flag = false;
foreach ($dom->find('tr') as $line) {

	$tds = $line->find('td');

	if (count($tds) == 5 + $_POST['courses'])
	{

		//!== , it's important. Don't change.
		$out = strpos($tds[0]->plaintext, $dayText) !== false;
	}

	if ($out)
	{
		if($flag){
			echo ",";
		}
		else{
			$flag = true;
		}
		echo '{"time":"';
		echo $tds[count($tds)-4-$_POST['courses']]->plaintext;
		echo '","name":"';
		echo $tds[count($tds)-3]->plaintext;
		echo '","teacher":"';
		echo $tds[count($tds)-2]->plaintext;
		echo '","href":"';
		echo $tds[count($tds)-1]->find('a')[0]->href;

		echo '"}';
	}
}
?>
]