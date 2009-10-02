<?php
/* we have to be a bit sneaky here, as the file we think we want is a directory
above us and the system will read things differently depending on whether we're
using javascript or php style navigation */
if (file_exists('views/index.php')) include ('views/index.php');
else include ('../index.php');
?>
