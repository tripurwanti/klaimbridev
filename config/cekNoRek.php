<?php

//koneksi DB AOS PROD sementara
$server 	= "10.20.10.16";
$user 		= "askrindo";
$password 	= "p@ssw0rd";
$database 	= "aos_kur_bri";
$db1 = mssql_connect($server,$user,$password, true);
mssql_select_db($database, $db1) or die ("Database tidak ditemukan");

$query1 = mssql_query("SELECT no_rekening from mapping_rc_bri mrb WHERE id = 17", $db1);
$query2 = mssql_query("SELECT no_rekening from mapping_rc_bri mrb WHERE id = 2", $db1);
$array1 = array();
$array2 = array();
$i = 1;
while ($a = mssql_fetch_array($query1)) {
    // echo $a['no_rekening'];
    array_push($array1, $a['no_rekening']);
        // echo "<br>";
    // $i++;  
}
while ($b = mssql_fetch_array($query2)) {
    // echo "ini id = 2";
    //     echo $b['no_rekening'];
    //     echo "<br>";
    array_push($array2, $b['no_rekening']);
}
// foreach($array1 as $a1){
//     foreach($array2 as $a2){
//     echo $a1;
//     echo "<br>";    
//     //     // if($a1 != $a2){
//             // echo $a2;
//             // echo "<br>";
//     //     // }
//     }
    
// }
$tampungArray = array_diff($array1, $array2);
print_r($tampungArray);