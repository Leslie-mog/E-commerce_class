<?php
// views/home.php
// Called by index.php. Core is already loaded.
?>
<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="content-wrapper">
    <?php require_once __DIR__ . '/layout/sidebar.php'; ?>

    <section class="main-content">
        <h2>Welcome to Shoppn</h2>
        <p>Your one-stop shop for everything.</p>

        <!-- Product grid will be added in Task 10 -->
        <div class="product-grid">
            <p><em>Products coming soon…</em></p>
        </div>
    </section>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>