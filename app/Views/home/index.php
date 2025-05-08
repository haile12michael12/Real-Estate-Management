<?php require "../layouts/header.php"; ?>
<?php 
    $categoryController = new CategoryController();
    $categories = $categoryController->index();
?>

<div class="container mt-5">
    <h2>Categories</h2>
    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    
    <a href="<?php echo ADMINURL; ?>/categories/create.php" class="btn btn-primary mb-3">Add New Category</a>
    
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($categories as $category): ?>
                <tr>
                    <td><?php echo $category['id']; ?></td>
                    <td><?php echo $category['name']; ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $category['id']; ?>" class="btn btn-sm btn-info">Edit</a>
                        <a href="delete.php?id=<?php echo $category['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require "../includes/footer.php"; ?>