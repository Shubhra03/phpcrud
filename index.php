<?php
$insert = false;
$update = false;
$delete = false;
$servername = "localhost";
$username = "root";
$password = "";
$database = "productdetail";
$conn = mysqli_connect($servername, $username, $password ,$database);
if (!$conn){
    die("Sorry we failed to connect: ". mysqli_connect_error());
}
if(isset($_GET['delete'])){
  $id = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM `productdetail` WHERE `id` = $id";
  $result = mysqli_query($conn, $sql);
}
  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset( $_POST['snoEdit'])){
      // Update the record
        $id = $_POST["snoEdit"];
        $name = $_POST["titleEdit"];
        $price = $_POST["priceEdit"];
        $description = $_POST["descriptionEdit"];
        $image=$_POST["Editimage"];
    
      // Sql query to be executed
      $sql = "UPDATE `productdetail` SET `name` = '$name',`price` = '$price' , `description` = '$description',`image` = '$image' WHERE `productdetail`.`id` = $id";
      $result = mysqli_query($conn, $sql);
      if($result){
        $update = true;
    }
    else{
        echo "We could not update the record successfully";
    }
    }
  else{
  $name = $_POST["name"];
  $price = $_POST["price"];
  $description = $_POST["description"];

  // Sql query to be executed
  $sql = "INSERT INTO `productdetail` (`name`,`price`,`description`) VALUES ('$name','$price', '$description')";
  $result = mysqli_query($conn, $sql);

   
  if($result){ 
      $insert = true;
  }
  else{
      echo "The record was not inserted successfully because of this error ---> ". mysqli_error($conn);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>CRUD</title>
  </head>
  <body>
    <!-- edit modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="/CRUD_IN_DATABASE/index.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
              <label for="price">Price</label>
              <input type="number" class="form-control" id="priceEdit" name="priceEdit" aria-describedby="emailHelp">
            </div>

            <div class="form-group">
              <label for="description">Description</label>
              <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
            </div> 
          </div>
          <div class="form-group">
  <label for="image" class="form-label">Choose image</label>
  <input class="form-control" type="file" id="Editimage" name="Editimage" multiple>
</div>

          <div class="modal-footer d-block mr-auto">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
            
      <div class="container my-4">
        <form action="/CRUD_IN_DATABASE/index.php" method="POST" enctype="multipart/form-data">
          <h1>Add product Details</h1>
          <div class="mb-3">
            <label for="name" class="form-label">product name</label>
            <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp">
            <!--aria-describedby="emailHelp"-->
          </div>
          <div class="mb-3">
            <label for="price" class="form-label">product price</label>
            <input type="number" class="form-control" id="price" name="price">
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">product Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
          </div>
    <div class="mb-3">
  <label for="image" class="form-label">Choose image</label>
  <input class="form-control" type="file" id="image" name="image" multiple>
</div>
         
          <button type="submit" class="btn btn-primary">Add Product</button>
        </form>
      </div>
  <div class="container">
     <table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">NAME</th>
      <th scope="col">PRICE</th>
      <th scope="col">Description</th>
      <th scope="col">image</th>
      <th scope="col">ACTION</th>
    </tr>
  </thead>
  <tbody>
  <?php
  $sql = "SELECT * FROM `productdetail`";
  $idno=0;
     $result = mysqli_query($conn, $sql);
  while($row = mysqli_fetch_assoc($result)){
    $idno = $idno+1;
  
         
    echo "<tr>
      <th scope='row'>".$idno."</th>
      <td>".$row['name']."</td>
      <td>".$row['price']."</td>
      <td>".$row['description']."</td>
      <td><img src=".$row['image']."></td>
     
      <td> <button class='edit btn btn-sm btn-primary' id=".$row['id'].">Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$row['id'].">Delete</button>  </td>
    </tr>";
  }
  ?>
  </tbody>
</table>
        
         
      </div>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
     <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

  
    <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        tr = e.target.parentNode.parentNode;
        name = tr.getElementsByTagName("td")[0].innerText;
        price = tr.getElementsByTagName("td")[1].innerText;
        description = tr.getElementsByTagName("td")[2].innerText;
        image = tr.getElementsByTagName("td")[3].innerText;
        console.log(name,price, description);
        titleEdit.value = name;
        priceEdit.value = price;
        descriptionEdit.value = description;
        snoEdit.value = e.target.id;
        console.log(e.target.id);
        $('#editModal').modal('toggle');
      })
    })


    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("delete ");
        sno = e.target.id.substr(1);
        console.log(sno);

        if (confirm("Are you sure you want to delete this product details!")) {
          console.log("yes");
          window.location = `/CRUD_IN_DATABASE/index.php?delete=${sno}`;
          // TODO: Create a form and use post request to submit a form
        }
        else {
          console.log("no");
        }
      })
    })
    </script>
  </body>
</html>