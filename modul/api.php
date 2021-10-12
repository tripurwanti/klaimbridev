<?php 
error_reporting(0);

include "../config/koneksi.php";
include "../config/query.php";

//if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) ) {
	
	/*
	if ($_POST['module'] == "askredprgkprsflpp") {
		if ($_POST['tipe'] == "Premi") {
			$q = sybase_query(askredprgkprsflpp($_POST['jkw1'], $_POST['jkw2'], $_POST['idk']), $con_op);
		} else {
			$q = sybase_query(askredprgkprsflpp_klaim($_POST['jkw1'], $_POST['jkw2'], $_POST['idk']), $con_op);
		}
	} elseif ($_POST['module'] == "askredkecil") {
		if ($_POST['tipe'] == "Premi") {
			$q = sybase_query(askredkecil($_POST['jkw1'], $_POST['jkw2'], $_POST['idk']), $con_op);
		} else {
			$q = sybase_query(askredkecil_briguna_klaim($_POST['jkw1'], $_POST['jkw2'], $_POST['idk']), $con_op);
		}
	} elseif ($_POST['module'] == "askredkonsumtif") {
		if ($_POST['tipe'] == "Premi") {
			$q = sybase_query(askredkonsumtif($_POST['jkw1'], $_POST['jkw2'], $_POST['idk']), $con_op);
		} else {
			$q = sybase_query(askredkonsumtif_klaim($_POST['jkw1'], $_POST['jkw2'], $_POST['idk']), $con_op);
		}
	} elseif ($_POST['module'] == "askredkomersial") {
		if ($_POST['tipe'] == "Premi") {
			$q = sybase_query(askredkomersial($_POST['jkw1'], $_POST['jkw2'], $_POST['idk']), $con_op);
		} else {
			$q = sybase_query(askredkomersial_klaim($_POST['jkw1'], $_POST['jkw2'], $_POST['idk']), $con_op);
		}
	} elseif ($_POST['module'] == "askredprogram") {
		if ($_POST['tipe'] == "Premi") {
			$q = sybase_query(askredkecil($_POST['jkw1'], $_POST['jkw2'], $_POST['idk']), $con_op);
		} else {
			$q = sybase_query(askredprogram_klaim($_POST['jkw1'], $_POST['jkw2'], $_POST['idk']), $con_op);
		}
	} 
	*/
	
	//POST module -> samakan dengan fungsi di query.php
	$mod = $_POST['module'];
	if ($mod == "suretyship21") {
		$q = sybase_query(suretyship($_POST['jkw1'], $_POST['jkw2'], $_POST['idk'], "21"), $con_op);
	} elseif ($mod == "suretyship22") {
		$q = sybase_query(suretyship($_POST['jkw1'], $_POST['jkw2'], $_POST['idk'], "22"), $con_op);
	} elseif ($mod == "suretyship23") {
		$q = sybase_query(suretyship($_POST['jkw1'], $_POST['jkw2'], $_POST['idk'], "23"), $con_op);
	} 
	
	elseif ($mod == "suretyship_klaim21") {
		$q = sybase_query(suretyship_klaim($_POST['jkw1'], $_POST['jkw2'], $_POST['idk'], "21"), $con_op);
	} elseif ($mod == "suretyship_klaim22") {
		$q = sybase_query(suretyship_klaim($_POST['jkw1'], $_POST['jkw2'], $_POST['idk'], "22"), $con_op);
	} elseif ($mod == "suretyship_klaim23") {
		$q = sybase_query(suretyship_klaim($_POST['jkw1'], $_POST['jkw2'], $_POST['idk'], "23"), $con_op);
	} 
	
	elseif ($mod == "suretyship_pelunasan_premi21") {
		$q = sybase_query(suretyship_pelunasan_premi($_POST['jkw1'], $_POST['jkw2'], $_POST['idk'], "21"), $con_op);
	} elseif ($mod == "suretyship_pelunasan_premi22") {
		$q = sybase_query(suretyship_pelunasan_premi($_POST['jkw1'], $_POST['jkw2'], $_POST['idk'], "22"), $con_op);
	} elseif ($mod == "suretyship_pelunasan_premi23") {
		$q = sybase_query(suretyship_pelunasan_premi($_POST['jkw1'], $_POST['jkw2'], $_POST['idk'], "23"), $con_op);
	}
	
	elseif ($mod == "suretyship_pelunasan_klaim21") {
		$q = sybase_query(suretyship_pelunasan_klaim($_POST['jkw1'], $_POST['jkw2'], $_POST['idk'], "21"), $con_op);
	} elseif ($mod == "suretyship_pelunasan_klaim22") {
		$q = sybase_query(suretyship_pelunasan_klaim($_POST['jkw1'], $_POST['jkw2'], $_POST['idk'], "22"), $con_op);
	} elseif ($mod == "suretyship_pelunasan_klaim23") {
		$q = sybase_query(suretyship_pelunasan_klaim($_POST['jkw1'], $_POST['jkw2'], $_POST['idk'], "23"), $con_op);
	}
	
	elseif ($mod == "suretyship_piutang21") {
		$q = sybase_query(suretyship_piutang($_POST['jkw1'], $_POST['jkw2'], $_POST['idk'], "21"), $con_op);
	} elseif ($mod == "suretyship_piutang22") {
		$q = sybase_query(suretyship_piutang($_POST['jkw1'], $_POST['jkw2'], $_POST['idk'], "22"), $con_op);
	} elseif ($mod == "suretyship_piutang23") {
		$q = sybase_query(suretyship_piutang($_POST['jkw1'], $_POST['jkw2'], $_POST['idk'], "23"), $con_op);
	}
	
	elseif ($mod == "suretyship21_hutang_klaim") {
		$q = sybase_query(suretyship_hutang_klaim($_POST['jkw1'], $_POST['jkw2'], $_POST['idk'], "21"), $con_op);
	} elseif ($mod == "suretyship22_hutang_klaim") {
		$q = sybase_query(suretyship_hutang_klaim($_POST['jkw1'], $_POST['jkw2'], $_POST['idk'], "22"), $con_op);
	} elseif ($mod == "suretyship23_hutang_klaim") {
		$q = sybase_query(suretyship_hutang_klaim($_POST['jkw1'], $_POST['jkw2'], $_POST['idk'], "23"), $con_op);
	}
	
	elseif ($mod == "suretyship21_outstanding_klaim") {
		$q = sybase_query(suretyship_outstanding_klaim($_POST['jkw1'], $_POST['jkw2'], $_POST['idk'], "21"), $con_op);
	} elseif ($mod == "suretyship22_outstanding_klaim") {
		$q = sybase_query(suretyship_outstanding_klaim($_POST['jkw1'], $_POST['jkw2'], $_POST['idk'], "22"), $con_op);
	} elseif ($mod == "suretyship22_outstanding_klaim") {
		$q = sybase_query(suretyship_outstanding_klaim($_POST['jkw1'], $_POST['jkw2'], $_POST['idk'], "23"), $con_op);
	}
	
	elseif ($mod == "kurgen2") {
		$p = explode("-", $_POST['jkw_kur']);
		$q = sybase_query($mod($p[0], $p[1], $_POST['idk']), $con_op);
	} else {
		$q = sybase_query($mod($_POST['jkw1'], $_POST['jkw2'], $_POST['idk']), $con_op);
	}
	
	
	$nq = sybase_num_rows($q);
	
	$i = 1;
    while ($data = sybase_fetch_array($q)) {
		array_unshift($data, $i);
		$dataz[] = $data;
		$i++;
    }
	
	$n = sybase_num_fields($q);
	for ($f=0; $f<$n; $f++){
		$info = sybase_fetch_field($q);
		$title = $info->name;
		if (strpos($title, '+') !== false) {
			$className = "sum";
			$title = str_replace("+", "", $title);
		} else {
			$className = "";
		}
		$fieldz[$f][title] = $title;
		$fieldz[$f][className] = $className;
	}
	array_unshift($fieldz, array("title" => "#"));
	
	$json_data = array(
			"draw"            => intval( 1 ),  
			"recordsTotal"    => intval( $nq ),  
			"recordsFiltered" => intval( $nq ), 
			"data"            => $dataz,
			"columns"         => $fieldz
			);
	
	function utf8ize( $mixed ) {
		if (is_array($mixed)) {
			foreach ($mixed as $key => $value) {
				$mixed[$key] = utf8ize($value);
			}
		} elseif (is_string($mixed)) {
			return mb_convert_encoding($mixed, "UTF-8", "UTF-8");
		}
		return $mixed;
	}
	
	$encoded = json_encode( utf8ize( $json_data ) );
	echo $encoded;  // send data as json format*/
	
	//echo utf8_encode(json_encode($json_data));  // send data as json format

//} else {
 //   echo '<script>window.location="404.html"</script>';
//}
?>