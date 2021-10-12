<?php
  header('Content-Type: application/download');
  header('Content-Disposition: attachment; filename="templateRC.xlsx"');
  header("Content-Length: " . filesize("templateRC.xlsx"));
  $fp = fopen("templateRC.xlsx", "r");
  fpassthru($fp);
  fclose($fp);
?>