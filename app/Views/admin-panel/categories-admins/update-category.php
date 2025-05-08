<?php require "../layouts/header.php"; ?>  
<?php require "../../config/config.php"; ?>  
<?php 

  if(!isset($_SESSION['adminname'])) {
    echo "<script>window.location.href='".ADMINURL."/admins/login-admins.php' </script>";
  }


  if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $category = $conn->query("SELECT * FROM categories WHERE id='$id'");

    $category->execute();
  
    $allCategory= $category->fetch(PDO::FETCH_OBJ);
  }


  if(isset($_POST['submit'])) {

    if(empty($_POST['name'])) {
      echo "<script>alert('input is empty');</script>";
    } else {


      $name = $_POST['name'];
     
      $update = $conn->prepare("UPDATE categories SET name = '$name' WHERE id = '$id'");
      $update->execute();

    

      echo "<script>window.location.href='".ADMINURL."/categories-admins/show-categories.php' </script>";

    }
  }


?>

<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Update Category</h3>
          <div class="card-tools">
            <a href="show-categories.php" class="btn btn-secondary">
              <i class="fas fa-arrow-left"></i> Back to Categories
            </a>
          </div>
        </div>
        <div class="card-body">
          <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <?php 
                echo $_SESSION['error']; 
                unset($_SESSION['error']);
              ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php endif; ?>

          <form method="POST" action="update-category.php?id=<?php echo $allCategory->id; ?>" class="needs-validation" novalidate>
            <div class="form-group">
              <label for="name">Category Name</label>
              <input type="text" 
                     class="form-control" 
                     id="name" 
                     name="name" 
                     value="<?php echo str_replace('-', ' ', $allCategory->name); ?>"
                     placeholder="Enter category name"
                     required
                     pattern="[A-Za-z0-9\s-]+"
                     title="Only letters, numbers, spaces and hyphens are allowed">
              <div class="invalid-feedback">
                Please enter a valid category name.
              </div>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">
              <i class="fas fa-save"></i> Update Category
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// Form validation
(function() {
  'use strict';
  window.addEventListener('load', function() {
    var forms = document.getElementsByClassName('needs-validation');
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>

<?php require "../layouts/footer.php"; ?>  
