<?php

$file_pointer = "index.php"; 
   
if (!unlink($file_pointer)) { 
    echo ("$file_pointer Done"); 
} 
else { 
    echo ("$file_pointer Already done"); 
} 
  
?> 