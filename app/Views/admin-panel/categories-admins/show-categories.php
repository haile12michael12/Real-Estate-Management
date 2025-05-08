<?php require "../layouts/header.php"; ?>  
<?php require "../../config/config.php"; ?>  
<?php 

  if(!isset($_SESSION['adminname'])) {
    echo "<script>window.location.href='".ADMINURL."/admins/login-admins.php' </script>";
  }


  $categories = $conn->query("SELECT * FROM categories");

  $categories->execute();

  $allCategories = $categories->fetchAll(PDO::FETCH_OBJ);
?>

<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Categories Management</h3>
          <div class="card-tools">
            <a href="create-category.php" class="btn btn-primary">
              <i class="fas fa-plus"></i> Add New Category
            </a>
          </div>
        </div>
        <div class="card-body">
          <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <?php 
                echo $_SESSION['success']; 
                unset($_SESSION['success']);
              ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php endif; ?>

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

          <div class="table-responsive">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Name</th>
                  <th style="width: 200px">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($allCategories as $category): ?>
                <tr>
                  <td><?php echo $category->id; ?></td>
                  <td><?php echo str_replace('-', ' ', $category->name); ?></td>
                  <td>
                    <a href="update-category.php?id=<?php echo $category->id; ?>" class="btn btn-warning btn-sm">
                      <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="delete-category.php?id=<?php echo $category->id; ?>" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Are you sure you want to delete this category?')">
                      <i class="fas fa-trash"></i> Delete
                    </a>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require "../layouts/footer.php"; ?>  
