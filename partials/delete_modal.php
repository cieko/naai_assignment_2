<?php
  $deleteQtyText = cutQtyShort($deleteOrder['quantity']);
?>
<section class="popup__layer">
  <a class="popup__back" href="index.php"></a>

    <div class="popup__card popup__card--danger">
        <div class="popup__head">
            <div>
                <p class="popup__mini popup__mini--danger">Delete Order</p>
      <h2>Confirm Delete</h2>
                <p class="popup__copy">This action will remove the selected curd order from the list. Review the details below before deleting it.</p>
            </div>
            <a class="popup__close" href="index.php">×</a>
        </div>

      <div class="popup__sum">
            <div class="popup__sum-row">
              <span class="popup__sum-label">Customer</span>
                <span class="popup__sum-value"><?= safeTxtOut($deleteOrder['customer_name']); ?></span></div>
            <div class="popup__sum-row">
                <span class="popup__sum-label">Mobile</span> <span class="popup__sum-value"><?= safeTxtOut($deleteOrder['mobile_number']); ?></span>
            </div>
            <div class="popup__sum-row">
                <span class="popup__sum-label">Quantity</span>
       <span class="popup__sum-value"><?= safeTxtOut($deleteQtyText); ?> L</span>
            </div>
            <div class="popup__sum-row">
                <span class="popup__sum-label">Delivery Date</span>
                <span class="popup__sum-value"><?= safeTxtOut($deleteOrder['delivery_date']); ?></span>
            </div>
        </div>

   <form method="post" action="index.php" class="popup__form">
            <input type="hidden" name="action" value="delete_order">
            <input type="hidden" name="order_id" value="<?= safeTxtOut((string) $deleteOrder['id']); ?>">

         <div class="formy__acts">
                <button type="submit" class="clicky clicky--danger">Delete Order</button> <a class="clicky clicky--lite" href="index.php">Cancel</a>
            </div>
        </form>
    </div>
</section>

