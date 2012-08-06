<?php
$fileoutput = "last-post-received.txt";
$postfile = file_get_contents ("php://input");
$handle = fopen ($fileoutput, "w");
fwrite ($handle, $postfile);
fclose ($handle);

?>
