<div class="listy listy--table">
    <div class="listy__bar">
        <div class="listy__head">
            <h2>Order List</h2>
            <p>All saved curd orders are shown below.</p>
        </div>
        <a class="clicky clicky--main" href="index.php?open=add">Add Order</a>
    </div>

 <?php if (empty($orders)): ?>
   <div class="listy__empty">
        <h3>No orders yet</h3> <p>See all the curd orders here.</p>
   </div>
<?php else: ?>
   <div class="listy__wrap">
    <table>
       <thead>
      <tr>
                <th>ID</th><th>Customer</th>
            <th>Mobile</th>
                    <th>Quantity</th> <th>Curd Type</th>
                <th>Delivery Date</th>
          <th>Total Price</th>
                <th>Actions</th>
      </tr>
       </thead>
          <tbody>
      <?php foreach ($orders as $order): ?>
    <?php
      $qtyText = cutQtyShort($order['quantity']);
            $priceText = rupeeTextMake((float) $order['total_price']);
    ?>
             <tr>
          <td><?= safeTxtOut((string) $order['id']); ?></td>
                    <td><?= safeTxtOut($order['customer_name']); ?></td><td><?= safeTxtOut($order['mobile_number']); ?></td>
               <td><?= safeTxtOut($qtyText); ?> L</td>
        <td><?= safeTxtOut($order['curd_type']); ?></td>
                    <td><?= safeTxtOut($order['delivery_date']); ?></td> <td><?= safeTxtOut($priceText); ?></td>
                  <td class="listy__acts">
                           <a class="listy__action listy__action--edit" href="index.php?edit=<?= safeTxtOut((string) $order['id']); ?>">Edit</a>
                        <a class="listy__action listy__action--blast" href="index.php?delete=<?= safeTxtOut((string) $order['id']); ?>">Delete</a> </td>
             </tr>
       <?php endforeach; ?>
          </tbody>
    </table>
   </div>
<?php endif; ?>
</div>

