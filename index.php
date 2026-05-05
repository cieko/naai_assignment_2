<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/order_logic.php';

$pageTitle = 'Curd Order Admin Portal';
$bodyClass = 'screen';

if ($showModal) {  # this is for the modal 
    $bodyClass = 'screen screen--freeze';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="<?= $bodyClass; ?>">
    <main class="pagy__shell">
        <section class="pagy__hero">
            <h1>Curd Order Management System</h1>
            <p class="pagy__copy">Manage customer curd orders.</p>
        </section>

        <?php require __DIR__ . '/partials/flash_toast.php'; ?>

        <section class="pagy__stack">
            <?php require __DIR__ . '/partials/order_table.php'; ?>
        </section>
    </main>

    <?php if ($showDeleteModal): ?>
        <?php require __DIR__ . '/partials/delete_modal.php'; ?>
    <?php elseif ($showModal): ?>
        <?php require __DIR__ . '/partials/order_form_modal.php'; ?>
    <?php endif; ?>
</body>
</html>

