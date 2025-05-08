<?php require "../layouts/header.php"; ?>  
<?php require "../../config/config.php"; ?>  
<?php 

  if(!isset($_SESSION['adminname'])) {
    echo "<script>window.location.href='".ADMINURL."/admins/login-admins.php' </script>";
  }


  if(isset($_POST['submit'])) {

    if(empty($_POST['name'])) {
      echo "<script>alert('some inputs are empty');</script>";
    } else {


      $name = $_POST['name'];
      $final_name = str_replace(' ', '-', trim($name)); 

      $insert = $conn->prepare("INSERT INTO categories (name) VALUES
      (:name)");

      $insert->execute([
        ':name' => $final_name,
       
      ]);

      echo "<script>window.location.href='".ADMINURL."/categories-admins/show-categories.php' </script>";

    }
  }


?>

<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Create New Category</h3>
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

          <form method="POST" action="create-category.php" class="needs-validation" novalidate>
            <div class="form-group">
              <label for="name">Category Name</label>
              <input type="text" 
                     class="form-control" 
                     id="name" 
                     name="name" 
                     placeholder="Enter category name"
                     required
                     pattern="[A-Za-z0-9\s-]+"
                     title="Only letters, numbers, spaces and hyphens are allowed">
              <div class="invalid-feedback">
                Please enter a valid category name.
              </div>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">
              <i class="fas fa-save"></i> Create Category
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
