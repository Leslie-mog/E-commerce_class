<?php
// views/account/my_account.php
require_once __DIR__ . '/../../core/core.php';
require_login();
?>
<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="content-wrapper">
    <?php require_once __DIR__ . '/../layout/sidebar.php'; ?>

    <section class="main-content">
        <h2>My Account</h2>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= e($_SESSION['success']) ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <p><strong>Name:</strong> <?= e($_SESSION['customer_name']) ?></p>
        <p><strong>Email:</strong> <?= e($_SESSION['customer_email']) ?></p>

        <p>More account features (edit profile, change password) coming soon.</p>
    </section>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
