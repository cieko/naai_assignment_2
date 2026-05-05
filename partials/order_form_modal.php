<?php
$modalMiniTitle = 'Create Order';
$modalTitle = 'Add New Order';
$modalText = 'Fill in the customer details and save a new curd order.';
$saveBtnText = 'Add Order';
$closeBtnText = 'Close';

if ($isEditing) {
    $modalMiniTitle = 'Update Order';
    $modalTitle = 'Edit Order';
    $modalText = 'Modify the selected curd order and save the new details.';
    $saveBtnText = 'Update Order';
    $closeBtnText = 'Cancel Edit';
}
?>
<section class="popup__layer">
    <a class="popup__back" href="index.php"></a>

    <div class="popup__card">
        <div class="popup__head">
            <div>
                <p class="popup__mini"><?= $modalMiniTitle; ?></p>
                <h2><?= $modalTitle; ?></h2>
                <p class="popup__copy">
                    <?= $modalText; ?>
                </p>
            </div>
            <a class="popup__close" href="index.php">×</a>
        </div>

        <form method="post" action="index.php" class="popup__form" novalidate>
            <input type="hidden" name="action" value="save_order">
            <input type="hidden" name="order_id" value="<?= safeTxtOut($formData['order_id']); ?>">

            <div class="formy__field">
                <label for="customer_name">Customer Name</label>
                <input
                    type="text"
                    id="customer_name"
                    name="customer_name"
                    value="<?= safeTxtOut($formData['customer_name']); ?>"
                    placeholder="Enter customer name"
                    autofocus
                >
                <?php if (isset($errors['customer_name'])): ?>
                    <span class="formy__error"><?= safeTxtOut($errors['customer_name']); ?></span>
                <?php endif; ?>
            </div>

            <div class="formy__field">
                <label for="mobile_number">Mobile Number</label>
                <input
                    type="text"
                    id="mobile_number"
                    name="mobile_number"
                    maxlength="10"
                    value="<?= safeTxtOut($formData['mobile_number']); ?>"
                    placeholder="Enter 10-digit mobile number"
                >
                <?php if (isset($errors['mobile_number'])): ?>
                    <span class="formy__error"><?= safeTxtOut($errors['mobile_number']); ?></span>
                <?php endif; ?>
            </div>

            <div class="formy__field">
                <label for="quantity">Quantity (liters)</label>
                <input
                    type="number"
                    id="quantity"
                    name="quantity"
                    min="0.5"
                    step="0.5"
                    value="<?= safeTxtOut($formData['quantity']); ?>"
                    placeholder="Enter quantity"
                >
                <?php if (isset($errors['quantity'])): ?>
                    <span class="formy__error"><?= safeTxtOut($errors['quantity']); ?></span>
                <?php endif; ?>
            </div>

            <div class="formy__field">
                <label for="curd_type">Type of Curd</label>
                <select id="curd_type" name="curd_type">
                    <option value="">Select curd type</option>
                    <?php foreach ($curdTypes as $curdType): ?>
                        <?php
                        $selectedText = '';
                        if ($formData['curd_type'] === $curdType) {
                            $selectedText = 'selected';
                        }
                        ?>
                        <option value="<?= safeTxtOut($curdType); ?>" <?= $selectedText; ?>>
                            <?= safeTxtOut($curdType); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($errors['curd_type'])): ?>
                    <span class="formy__error"><?= safeTxtOut($errors['curd_type']); ?></span>
                <?php endif; ?>
            </div>

            <div class="formy__field">
                <label for="delivery_date">Delivery Date</label>
                <input
                    type="date"
                    id="delivery_date"
                    name="delivery_date"
                    value="<?= safeTxtOut($formData['delivery_date']); ?>"
                >
                <?php if (isset($errors['delivery_date'])): ?>
                    <span class="formy__error"><?= safeTxtOut($errors['delivery_date']); ?></span>
                <?php endif; ?>
            </div>

            <div class="formy__acts">
                <button type="submit" class="clicky clicky--main">
                    <?= $saveBtnText; ?>
                </button>
                <a class="clicky clicky--lite" href="index.php"><?= $closeBtnText; ?></a>
            </div>
        </form>
    </div>
</section>

