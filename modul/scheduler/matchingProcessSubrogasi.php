<?php
try {
    $result = mssql_query("Exec dbo.spRekonSubrogasiScheduler");
} catch (Exception $e) {
    echo $e;
}