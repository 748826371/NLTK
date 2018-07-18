<?php
	$b = '2017-8-10';
	$a = '2017-9-10';

	$begin = strtotime($b);
	$end = strtotime($a);
	$data = [];
	while($end > $begin) {
		$begin = $begin + 86400;
		$data[] = date('Y-m-d', $begin);
		
	}
	echo gettype($data[0]);


	exit;
function prDates($start,$end){
    $dt_start = strtotime($start);
    $dt_end = strtotime($end);
    while ($dt_start<=$dt_end){
        echo date('Y-m-d',$dt_start)."\n";
        $dt_start = strtotime('+1 day',$dt_start);
    }
}
prDates('2017-8-10','2017-9-10');
echo "----------\n";
prDates('2005-01-29','2005-02-02');


?>