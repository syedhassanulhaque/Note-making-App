<?php
// Creating Connection
$insert=false;
$update=false;
$delete=false;
$servername="localhost";
$username="root";
$password="";
$database="notes";


$conn=mysqli_connect($servername,$username,$password,$database);
if (!$conn) {
 die("Cannot connect to the server." . mysqli_error($conn));
}

else{
  // echo "Connection is made succssfully!";
}



?>


<?php 

if ($_SERVER['REQUEST_METHOD']=='POST') {
  if(isset($_POST['code'])){
    $sno=$_POST['code'];
    $enote=$_POST['enote'];
    $edescription=$_POST['edescription'];

    $sql="UPDATE `crud` SET `note` = '$enote', `description` = '$edescription' WHERE `crud`.`sno` ='$sno' ";
    $result=mysqli_query($conn,$sql);
    if($result){
      $update=true;
  
    }
  
  }
 else{
  $note=$_POST['note'];
  $description=$_POST['description'];
  
  // $sql="insert into crud(note,description) values(?,?)";
  // prepared_query($conn,$sql,[$note,$description]);

  // $stmt=$conn-> prepare($sql);
  // $stmt-> bind_param("ss",$note,$description);
  // $stmt->execute();

  $sql="insert into crud(note,description) values('$note','$description')";
  $result=mysqli_query($conn,$sql);
  if($result){
    $insert=true;

  }
 }

 

}


if (($_SERVER['REQUEST_METHOD']=='GET') ){

  if (isset($_GET['delete'])) {
    $sno=$_GET['delete'];

    $sql="DELETE FROM `crud` WHERE `crud`.`sno` = '$sno' ";
  
    $result=mysqli_query($conn,$sql);
    if($result){
      $delete=true;
       }
}

}
?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Data Tables css -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    
    <title>Notes- Remembering made easy </title>
  </head>
  <body>


<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Launch demo modal
</button> -->

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                  <form method="post" action="/crud/index.php">
              <div class="mb-3">
                <input type="hidden" name="code" id='code'>
                <label for="enote" class="form-label">Edit Note</label>
                <input type="text" class="form-control" id="enote" name="enote" Required >
              </div>
              <div class="mb-3">
                <label for="edescription" class="form-label">Edit Description</label>
                <textarea name="edescription" id="edescription" cols="30" rows="6" class="form-control"></textarea>
                
              </div>
              <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
      </div>
      
    </div>
  </div>
</div>






  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">iScope</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact Us</a>
        </li>
          
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
<?php

if($insert){
  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success! </strong>Your Note hasbeen inserted successfully.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}

if($update){
  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success! </strong>Your Note hasbeen updated successfully.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
if($delete){
  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success! </strong>Your Note hasbeen deleted successfully.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}


?>


    <div class="container my-4">
        <h2>Notes Making App</h2>


    <form method="post" action="/crud/index.php">
  <div class="mb-3">
    <label for="note" class="form-label">Note</label>
    <input type="text" class="form-control" id="note" name="note" Required >
  </div>
  <div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea name="description" id="description" cols="30" rows="6" class="form-control" ></textarea>
    
  </div>
  <button type="submit" class="btn btn-primary">Add Note</button>
  <button type="button" class="btn btn-primary"><a href="download.php" style="color:white; text-decoration:none; margin: 5px;">Download Excel</a></button>
</form>
    </div>






<div class="container  my-5">
<table class="table table-dark" id='myTable'>
  <thead>
    <tr>
      <th scope="col"> S.No</th>
      <th scope="col">Notes</th>
      <th scope="col">Description</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>

<?php
  $sql="Select * from crud ";
$result=mysqli_query($conn,$sql);
$sn=1;
while ($row=mysqli_fetch_assoc($result)) {
echo "<tr>
<th scope='row'>". $sn . "</th>
<td>". $row['note']."</td>
<td>". $row['description']."</td>
<td>  <button  class='btn btn-primary edit' data-bs-toggle='modal' data-bs-target='#editModal' id=".$row['sno'].">Edit</button>  <button  class='btn btn-primary deletes' id=". 2222 . $row['sno']." >Delete</button></td>

</tr>";
$sn++;
} ;

?> 
    
  </tbody>
</table>

</div>





    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
   <script>
     $(document).ready( function () {
    $('#myTable').DataTable();
} )

   </script>

   <script>
     edit= document.getElementsByClassName('edit');

    //  console.log(deletes)
     enote=document.getElementById('enote')
     edescription=document.getElementById('edescription')
    // console.log(edit)
    arr= Array.from(edit)
  // console.log(arr)
    arr.forEach((element) => {
      element.addEventListener("click",(e)=>{
        // console.log("edit" , e.target.parentNode.parentNode)
        tr=e.target.parentNode.parentNode;
        title=tr.getElementsByTagName('td')[0].innerText
        desc=tr.getElementsByTagName('td')[1].innerText
        sno=e.target.id
        // console.log(sno)
        // console.log(title, desc)


        enote.value=title
        edescription.value=desc
        code.value=sno 

      })
    });


    deletes= document.getElementsByClassName('deletes');
    // console.log(deletes)

    arr2= Array.from(deletes)
  // console.log(arr2)

    arr2.forEach((element) => {
      element.addEventListener("click",(e)=>{
        // console.log("edit" , e.target.parentNode.parentNode)
        // tr=e.target.id.su;
        // console.log(tr)
        sno=e.target.id.substr(4,)
        // console.log(sno)
        
        confirmation= confirm("Do you want to delete this note ?");
        if(confirmation){
          console.log("yes")
          window.location=`/crud/index.php?delete=${sno}`;
        }
     

      })
    });
   </script>

  </body>
</html>