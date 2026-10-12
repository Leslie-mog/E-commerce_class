<?php
// views/register.php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CustomerController.php';

$old = $_SESSION['old'] ?? [];
unset($_SESSION['old']);
?>
<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="content-wrapper">
    <?php require_once __DIR__ . '/layout/sidebar.php'; ?>

    <section class="main-content">
        <h2>Create Your Account</h2>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-error"><?= e($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form id="register-form" action="<?= BASE_URL ?>/actions/register_action.php" method="POST" novalidate>

            <label>Full Name
                <input type="text" name="name" required value="<?= e($old['name'] ?? '') ?>">
                <span class="field-error" id="name-error"></span>
            </label>

            <label>Email
                <input type="email" name="email" required value="<?= e($old['email'] ?? '') ?>">
                <span class="field-error" id="email-error"></span>
            </label>

            <label>Password
                <input type="password" name="password" id="password" required>
                <span class="field-error" id="password-error"></span>
            </label>

            <label>Confirm Password
                <input type="password" name="confirm_password" id="confirm_password" required>
                <span class="field-error" id="confirm-error"></span>
            </label>

            <label>Country
                <select name="country" required>
                    <option value="">-- Select --</option>
                    <?php
                    $countries = ['Ghana', 'Nigeria', 'Kenya', 'South Africa', 'USA', 'UK', 'Canada'];
                    foreach ($countries as $c):
                        $sel = (($old['country'] ?? '') === $c) ? 'selected' : '';
                        ?>
                        <option value="<?= e($c) ?>" <?= $sel ?>><?= e($c) ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="field-error" id="country-error"></span>
            </label>

            <label>City
                <input type="text" name="city" required value="<?= e($old['city'] ?? '') ?>">
                <span class="field-error" id="city-error"></span>
            </label>

            <label>Contact Number
                <input type="text" name="contact" required value="<?= e($old['contact'] ?? '') ?>">
                <span class="field-error" id="contact-error"></span>
            </label>

            <button type="submit" class="btn-primary">Register</button>
        </form>

        <p>Already have an account?
            <a href="<?= BASE_URL ?>/views/login.php">Login here</a>.
        </p>
    </section>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>