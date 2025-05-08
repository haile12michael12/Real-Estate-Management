<?php 
require "../layouts/header.php";
require "../config/config.php";
require_once "../Controllers/AuthController.php";

$auth = new AuthController();
$auth->register();
?>

<div class="site-wrap">
    <div class="site-blocks-cover inner-page-cover overlay" style="background-image: url(<?php echo APPURL; ?>/images/hero_bg_2.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
        <div class="container">
            <div class="row align-items-center justify-content-center text-center">
                <div class="col-md-10">
                    <h1 class="mb-2">Register</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="site-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="h4 text-black widget-title mb-3">Register</h3>
                    <?php if(isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
                    <?php endif; ?>
                    <form action="register.php" method="POST" class="form-contact-agent">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn btn-primary" value="Register">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require "../layouts/footer.php"; ?>