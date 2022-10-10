<?php
// Creating Connection
$insert=false;
$servername="localhost";
$username="root";
$password="";
$database="farhan";


$conn=mysqli_connect($servername,$username,$password,$database);
if (!$conn) {
 die("Cannot connect to the server." . mysqli_error($conn));
}

else{
  // echo "Connection is made succssfully!";
}

$output='';

  $sql="Select * from crud ";

$result=mysqli_query($conn,$sql);
$sn=1;
$output.='<table class="table">
<thead>
  <tr>
    <th scope="col">S. No.</th>
    <th scope="col" >Note</th>
    <th scope="col">Description</th>
   
  </tr>
</thead>
<tbody>';


while ($row=mysqli_fetch_assoc($result)) {

  $output.='<tr>
  <th scope="row"> '. $sn++ .' </th>
  <td>  '. $row['note'] .' </td>
  <td>   '. $row['description'] .' </td>
</tr>' ;



header('Content-type:Application/xls');
header('Content-disposition:attachment;filename=data.xls');

} ;
 
$output.='</tbody><table>';
echo $output;

?>
