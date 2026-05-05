<?php

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/db.php';

session_start();
initial();

$curdTypes = curdListPick();
$errors = [];
$formData = blankDataBag();
$requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if ($requestMethod === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'save_order') {
        $formData = postBitsNow($_POST);
        $errors = checkDataMix($formData);

        if (empty($errors)) {
            $quantity = (float) $formData['quantity'];
            $totalPrice = sumAmtNow($quantity);

            if ($formData['order_id'] !== '') {

                $stmt = $conn->prepare("UPDATE orders SET 
                    customer_name=?, 
                    mobile_number=?, 
                    quantity=?, 
                    curd_type=?, 
                    delivery_date=?, 
                    total_price=? 
                    WHERE id=?");

                $stmt->bind_param(
                    "ssdssdi",
                    $formData['customer_name'],
                    $formData['mobile_number'],
                    $quantity,
                    $formData['curd_type'],
                    $formData['delivery_date'],
                    $totalPrice,
                    $formData['order_id']
                );

                $stmt->execute();

                saveFlashPop('Order updated successfully.', 'success', 'Order Updated');

            } else {

                $stmt = $conn->prepare("INSERT INTO orders 
                    (customer_name, mobile_number, quantity, curd_type, delivery_date, total_price) 
                    VALUES (?, ?, ?, ?, ?, ?)");

                $stmt->bind_param(
                    "ssdssd",
                    $formData['customer_name'],
                    $formData['mobile_number'],
                    $quantity,
                    $formData['curd_type'],
                    $formData['delivery_date'],
                    $totalPrice
                );

                $stmt->execute();

                saveFlashPop('Order added successfully.', 'success', 'Order Added');
            }

            goHomeFastish();
        }
    }

    if ($action === 'delete_order') {
        $orderId = (int) ($_POST['order_id'] ?? 0);

        $stmt = $conn->prepare("DELETE FROM orders WHERE id=?");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();

        saveFlashPop('Order deleted successfully.', 'success', 'Order Deleted');

        goHomeFastish();
    }
}

if (isset($_GET['edit'])) {
    $editId = (int) $_GET['edit'];

    $stmt = $conn->prepare("SELECT * FROM orders WHERE id=?");
    $stmt->bind_param("i", $editId);
    $stmt->execute();

    $result = $stmt->get_result();
    $order = $result->fetch_assoc();

    if ($order) {
        $formData = [
            'order_id' => (string) $order['id'],
            'customer_name' => $order['customer_name'],
            'mobile_number' => $order['mobile_number'],
            'quantity' => cutQtyShort($order['quantity']),
            'curd_type' => $order['curd_type'],
            'delivery_date' => $order['delivery_date'],
        ];
    }
}

$flash = pullFlashOne();

$result = $conn->query("SELECT * FROM orders ORDER BY id DESC");

$orders = [];
if ($result && $result->num_rows > 0) {
    $orders = $result->fetch_all(MYSQLI_ASSOC);
}

$isEditing = $formData['order_id'] !== '';
$deleteOrder = null;

if (isset($_GET['delete'])) {
    foreach ($orders as $order) {
        if ((int)$order['id'] === (int)$_GET['delete']) {
            $deleteOrder = $order;
            break;
        }
    }
}

$showAddModal = isset($_GET['open']) && $_GET['open'] === 'add';
$showDeleteModal = $deleteOrder !== null;
$showModal = $showDeleteModal || $showAddModal || $isEditing || !empty($errors);