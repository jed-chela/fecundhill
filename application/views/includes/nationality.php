<?php

$nations_arr = array(
  "Nigeria",
);

for($i = 0; $i < count($nations_arr); $i++){
  echo "<option value='". $nations_arr[$i] ."'";
  if($selected_value == $nations_arr[$i]){
    echo " selected ";
  }
  echo ">" . $nations_arr[$i] . "</option>";
}

/*
$nations_arr = array(
  "Nigeria",
  "Canada",
  "Ghana",
  "USA",
  "UK"
);
*/

?>