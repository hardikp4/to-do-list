<?php
$insert = false;
$update = false;
$delete = false;
//connect to database
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

//crate a connection

$conn = mysqli_connect($servername,$username,$password,$database);

//die if connection is not successfull
if(!$conn){
  die("Sorry connection failed : ".mysqli_conect_error());

}
//take data after clicking add button and insert

//exit();

if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $delete = true;

  $sql="DELETE FROM `notes` WHERE `sno` = $sno";
  $result = mysqli_query($conn,$sql);
}
if($_SERVER['REQUEST_METHOD']== 'POST'){
  if(isset($_POST['snoEdit'])){
   // echo "yes";
   //update the record 
   $sno = $_POST["snoEdit"];
   $title = $_POST["titleEdit"];    //take title
  $description = $_POST["descriptionEdit"];  // take description
  //sql querry to be executed
  $sql="UPDATE `notes` SET `title` = '$title' , `description` = '$description' WHERE `notes`.`sno` = $sno";
  //$sql = "INSERT INTO 'notes' ('title', 'description') VALUES ('$title','$description')";
  $result = mysqli_query($conn,$sql);
  if($result){
    $update = true;
  }
  else{
    echo "could not update ";
  }
  }
  else{
  $title = $_POST["title"];    //take title
  $description = $_POST["description"];  // take description
  //sql querry to be executed
  $sql="INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES ('', '$title', '$description', current_timestamp())";
  //$sql = "INSERT INTO 'notes' ('title', 'description') VALUES ('$title','$description')";
  $result = mysqli_query($conn,$sql);

  //add a new task

  if($result){
    //echo"the record has been inserted ";
    $insert = true;
  }
  else{
    echo"The record has not been inserted error : ".mysqli_error($conn);
  }
  }
}


?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>To-Do-System</title>
  

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous">
    </script>
  <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();
    });
  </script>
</head>

<body style = "background-color:#f1f7f7">

  <!-- Edit modal 
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
  Edit modal
</button>

 Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/crud/index.php" method="post">
          <div class="modal-body">

            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="mb-3">
              <label for="title" class="form-label">Note Title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">

            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Note Description</label>
              <textarea class="form-control" id="descriptionEdit" name="descriptionEdit"></textarea>

            </div>
            

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">NoteBook : A digital place to keep your notes !</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      

    </div>
  </nav>

  <?php
  if($insert){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success</strong> Your note has been inserted successfully.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
  }

  ?>

  <?php
  if($update){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success</strong> Your note has been updated successfully.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
  }

  ?>

  <?php
  if($delete){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success</strong> Your note has been deleted successfully.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
  }

  ?>

  <div class="container my-4">
    <h2>Add a note</h2>
    <form action="/crud/index.php" method="post">
      <div class="mb-3">
        <label for="title" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">

      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Note Description</label>
        <textarea class="form-control" id="description" name="description"></textarea>

      </div>
      <button type="submit" class="btn btn-primary my-3">Add Note</button>
    </form>
  </div>

  <div class="container my-4">



    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.No</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        //get data and print 
        $sql="SELECT * FROM `notes`";
        $result = mysqli_query($conn,$sql);
        $sno=0;
        while($row=mysqli_fetch_assoc($result)){
          $sno= $sno+1;

        echo "  <tr>
          <th scope='row'>" . $sno . "</th>
          <td>". $row['title'] ."</td>
          <td>". $row['description'] ."</td>
          <td> <button class='edit btn btn-sm btn-primary' id=".$row['sno'].">Edit</button>
          <button class='delete btn btn-sm btn-primary' id=d".$row['sno'].">Delete</button></td>
        </tr>";
         
        }

        ?>




      </tbody>
    </table>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
    crossorigin="anonymous"></script>

  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit",);
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        console.log(title, description);
        titleEdit.value = title;
        descriptionEdit.value = description;
        snoEdit.value = e.target.id;
        console.log(e.target.id);
        $('#editModal').modal('toggle');


      })

    })

    //delete
    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("delete",);
        sno = e.target.id.substr(1,);
        if (confirm("Are you sure you want to delete this note ? ")) {
          console.log("yes");
          window.location = `/crud/index.php?delete=${sno}`;
        }
        else {
          console.log("no");
        }



      })

    })

  </script>
</body>

</html>