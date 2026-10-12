<?php
// views/login.php
require_once __DIR__ . '/../core/core.php';

$oldEmail = $_SESSION['old_email'] ?? '';
unset($_SESSION['old_email']);
?>
<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="content-wrapper">
    <?php require_once __DIR__ . '/layout/sidebar.php'; ?>

    <section class="main-content">
        <h2>Login</h2>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= e($_SESSION['success']) ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-error"><?= e($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form id="login-form" action="<?= BASE_URL ?>/actions/login_action.php" method="POST">
            <label>Email
                <input type="email" name="email" required value="<?= e($oldEmail) ?>">
                <span class="field-error" id="login-email-error"></span>
            </label>

            <label>Password
                <input type="password" name="password" required>
                <span class="field-error" id="login-password-error"></span>
            </label>

            <button type="submit" class="btn-primary">Login</button>
        </form>

        <p>Don't have an account?
            <a href="<?= BASE_URL ?>/views/register.php">Register here</a>.
        </p>
    </section>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>