<?php 
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, "http://dev.app.shyfter.co/api/schedule/getShyfts.php"); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	$post = [
		'department_id' => 46,
		'start' => "2019-08-23T00:00:00Z",
		'end'   => "2019-08-24T00:00:00Z",
		'timezone'   => "UTC",
	];
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	$getShyfts = json_decode(curl_exec($ch))->datas; 
	
	curl_setopt($ch, CURLOPT_URL, "http://dev.app.shyfter.co/api/schedule/getResources.php"); 
	$getResources = json_decode(curl_exec($ch)); 
	
	curl_close($ch);      

// var_dump($getShyfts, $getResources);die;
// $getShyfts=json_decode( '{"result":"OK","datas":{"shifts":[{"id":"95896","approved":"1","start":"2019-08-25 13:30:00","end":"2019-08-25 19:00:00","colors":{"bg":"#efefef","text":"#333"},"dayoff":0,"dayoff_name":"","skill":[{"id":"68","0":"68","skill_name":"Cuisine","1":"Cuisine","price":"0","2":"0","color":"#edffed","3":"#edffed"}],"attributes":"","start_time":"13:30","end_time":"19:00","worktime":"5h30","pause":"","resourceId":"752","rrid":"752"},{"id":"95895","approved":"1","start":"2019-08-25 13:30:00","end":"2019-08-25 19:00:00","colors":{"bg":"#efefef","text":"#333"},"dayoff":0,"dayoff_name":"","skill":[{"id":"68","0":"68","skill_name":"Cuisine","1":"Cuisine","price":"0","2":"0","color":"#edffed","3":"#edffed"}],"attributes":"","start_time":"13:30","end_time":"19:00","worktime":"5h30","pause":"","resourceId":"1231","rrid":"1231"},{"id":"95897","approved":"1","start":"2019-08-25 13:30:00","end":"2019-08-25 19:00:00","colors":{"bg":"#efefef","text":"#333"},"dayoff":0,"dayoff_name":"","skill":[{"id":"68","0":"68","skill_name":"Cuisine","1":"Cuisine","price":"0","2":"0","color":"#edffed","3":"#edffed"}],"attributes":"","start_time":"13:30","end_time":"19:00","worktime":"5h30","pause":"","resourceId":"1204","rrid":"1204"}]},"comment":"Shyfts 100% loaded."}')->datas; 
// $getResources = json_decode('{"result":"OK","ai":{"active":true,"daynumber":"7","budget":"30.000","splits":[{"hours":0,"budget":"0","div_id":"2019-08-25T00:00:00","headcount":0,"hoursbooked":"0"},{"hours":0.41,"budget":"123","div_id":"2019-08-25T10:00:00","headcount":2,"hoursbooked":"0"},{"hours":5.02,"budget":"1.506","div_id":"2019-08-25T11:00:00","headcount":11,"hoursbooked":"0"},{"hours":17.82,"budget":"5.346","div_id":"2019-08-25T12:00:00","headcount":23,"hoursbooked":"0"},{"hours":14.63,"budget":"4.389","div_id":"2019-08-25T13:00:00","headcount":23,"hoursbooked":"0"},{"hours":7.44,"budget":"2.232","div_id":"2019-08-25T14:00:00","headcount":15,"hoursbooked":"3"},{"hours":3.71,"budget":"1.113","div_id":"2019-08-25T15:00:00","headcount":8,"hoursbooked":"3"},{"hours":3.65,"budget":"1.095","div_id":"2019-08-25T16:00:00","headcount":8,"hoursbooked":"3"},{"hours":4.98,"budget":"1.494","div_id":"2019-08-25T17:00:00","headcount":11,"hoursbooked":"3"},{"hours":10.94,"budget":"3.282","div_id":"2019-08-25T18:00:00","headcount":21,"hoursbooked":"3"},{"hours":11.93,"budget":"3.579","div_id":"2019-08-25T19:00:00","headcount":22,"hoursbooked":"0"},{"hours":8.55,"budget":"2.565","div_id":"2019-08-25T20:00:00","headcount":17,"hoursbooked":"0"},{"hours":4.42,"budget":"1.326","div_id":"2019-08-25T21:00:00","headcount":9,"hoursbooked":"0"},{"hours":3.33,"budget":"999","div_id":"2019-08-25T22:00:00","headcount":7,"hoursbooked":"0"},{"hours":3.17,"budget":"951","div_id":"2019-08-25T23:00:00","headcount":7,"hoursbooked":"0"}],"maxhead":23},"datas":[{"id":0,"title":"Shifts\nDisponibles","occupancy":5,"skill":"","skill_color":"","detail":""},{"id":"1231","title":"Tess Winter","occupancy":10,"skill":null,"skill_color":null,"detail":"5h30 - \u20ac110"},{"id":"752","title":"Hugo Antoine","occupancy":15,"skill":"livraison","skill_color":"#c0f7ff","detail":"5h30 - \u20ac55"},{"id":"1204","title":"Jules Ceulemans","occupancy":20,"skill":"livraison","skill_color":"#c0f7ff","detail":"5h30 - \u20ac60.5"}],"comment":"Resources 100% loaded."}');


    const td_width = 30;
    function calc_left($start) {
        return (time2float($start) - 14) * td_width;
    }
    function calc_width($start, $end) {
        return (time2float($end) - time2float($start)) * td_width;
    }
    function time2float($time) {
        return floatval(explode(":", $time)[0])*2 + floatval(explode(":", $time)[1])/30; 
    }

?>
<!doctype html>
<html lang="en">

<head>
	<title>Title</title>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<style>
		tr:last-child > th {
            border-bottom-width: 5px; 
        }
        .fcp-lt td {
            min-width: 60px;
            height: 65px;
        }
        .fcp-rt td {
            width: <?php echo td_width; ?>px;
            height: 65px;
        }
		.table th {
			height: 42px;
		}
		.table th, .table td {
			padding: .5rem 0;
		}
	</style>
</head>

<body>
	<h2><?php echo $post['start']." ~ ".$post['end'] ?></h2>
	<div class="fc-print">
		<table class="fcp-lt table table-bordered table-striped float-left text-center" style="width: auto">
			<thead>
				<tr>
					<th colspan="2">HB / HP</th>
				</tr>
				<tr>
					<th colspan="2">Budget : €
						<?php echo $getResources->ai->budget; ?></th>
				</tr>
				<tr>
					<th>Collaborateurs</th>
					<th>H.P.</th>
				</tr>
				<tr>
					<th>
						<?php echo $getResources->datas[0]->title; ?></th>
					<th>
						<?php echo $getResources->datas[0]->occupancy; ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($getResources->datas as $key => $row) { if ($key > 0) { ?>
				<tr>
					<td>
						<?php echo $row->title; ?>
						<br><span class="fcp-lt-detail badge badge-primary"><?php echo $row->detail; ?></span>
					</td>
					<td>
						<?php echo $getResources->datas[$key]->occupancy; ?></td>
				</tr>
				<?php } } ?>
			</tbody>
		</table>
		<table class="fcp-rt table table-bordered table-striped float-left text-center" style="width: auto; overflow-x: auto;">
			<thead>
				<tr>
					<th colspan="2"></th>
					<th colspan="2"></th>
					<th colspan="2"></th>
					<?php foreach($getResources->ai->splits as $key => $row) { if ($key > 0) { ?>
					<th colspan="2">
						<?php echo $row->hoursbooked." / ".$row->headcount; ?></th>
					<?php } } ?>
				</tr>
				<tr>
					<th colspan="2"></th>
					<th colspan="2"></th>
					<th colspan="2"></th>
					<?php foreach($getResources->ai->splits as $key => $row) { if ($key > 0) { ?>
					<th colspan="2">
						<?php echo "€".$row->budget; ?></th>
					<?php } } ?>
				</tr>
				<tr>
					<?php foreach(range(7, 23) as $key=>$row) { ?>
					<th colspan="2">
						<?php echo $row. " h"; ?>
					</th>
					<?php } ?>
				</tr>
				<tr>
					<th colspan="34">-</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($getResources->datas as $key => $row) { if ($key > 0) { ?>
				<tr>
					<?php foreach(range(14, 47) as $hrk=>$hrv) { if ($hrk ==0) { ?>
					<td style="position: relative">
						<?php foreach($getShyfts->shifts as $k => $v) { if ($v->rrid == $row->id) { ?>
						<div style="position: absolute; background: #cccccc; left: <?php echo calc_left($v->start_time) ?>px; width: <?php echo calc_width($v->start_time, $v->end_time) ?>px; text-align: left; padding: 5px; top: 2px; border: 1px dotted;">
							<div style="">
								<?php echo $v->start_time." - ".$v->end_time; ?></div>
							<?php foreach($v->skill as $ks => $vs) { ?> <span class="fcp-rt-detail badge badge-success"><?php echo $vs->skill_name ?></span>
							<?php } ?>
							<?php foreach($v->attributes as $ka => $va) { ?> <span class="fcp-rt-detail badge" style="background: <?php echo $va->bgcolor; ?>"><?php echo $va->name ?></span>
							<?php } ?>
						</div>
						<?php } } ?>
					</td>
					<?php } else { ?>
					<td></td>
					<?php } } ?>
					<div class="fcp-tl"></div>
				</tr>
				<?php } } ?>
			</tbody>
		</table>
	</div>
</body>

</html>