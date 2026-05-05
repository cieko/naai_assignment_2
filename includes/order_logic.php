<?php

require_once __DIR__ . '/functions.php';

session_start();
warmOrderStuff();

$curdTypes = curdListPick();
$errors = [];
$formData = blankDataBag();
$requestMethod = 'GET';

if (isset($_SERVER['REQUEST_METHOD'])) {
    $requestMethod = $_SERVER['REQUEST_METHOD'];
}

if ($requestMethod === 'POST') {
    $action = '';

    if (isset($_POST['action'])) {
        $action = $_POST['action'];
    }

    if ($action === 'save_order') {
        $formData = postBitsNow($_POST);
        $errors = checkDataMix($formData);

        if (empty($errors)) {
            $quantity = (float) $formData['quantity'];
            $totalPrice = sumAmtNow($quantity);
            $orderData = [
                'id' => $formData['order_id'] !== '' ? (int) $formData['order_id'] : $_SESSION['next_order_id'],
                'customer_name' => $formData['customer_name'],
                'mobile_number' => $formData['mobile_number'],
                'quantity' => $quantity,
                'curd_type' => $formData['curd_type'],
                'delivery_date' => $formData['delivery_date'],
                'total_price' => $totalPrice,
            ];

            if ($formData['order_id'] !== '') {
                $didUpdate = false;

                foreach ($_SESSION['orders'] as $index => $order) {
                    if ((int) $order['id'] === (int) $formData['order_id']) {
                        $_SESSION['orders'][$index] = $orderData;
                        $didUpdate = true;
                        break;
                    }
                }

                if ($didUpdate) {
                    saveFlashPop('Order updated successfully.', 'success', 'Order Updated');
                } else {
                    saveFlashPop('Order updated successfully.', 'success', 'Order Updated');
                }
            } else {
                $_SESSION['orders'][] = $orderData;
                $_SESSION['next_order_id']++;
                saveFlashPop('Order added successfully.', 'success', 'Order Added');
            }

            goHomeFastish();
        }
    }

    if ($action === 'delete_order') {
        $orderId = (int) ($_POST['order_id'] ?? 0);
        $deletedSomething = false;

        foreach ($_SESSION['orders'] as $index => $order) {
            if ((int) $order['id'] === $orderId) {
                unset($_SESSION['orders'][$index]);
                $_SESSION['orders'] = array_values($_SESSION['orders']);
                $deletedSomething = true;
                break;
            }
        }

        if ($deletedSomething) {
            saveFlashPop('Order deleted successfully.', 'success', 'Order Deleted');
        }

        goHomeFastish();
    }
}

// populate the date, when edit
if (isset($_GET['edit'])) {
    $editId = (int) $_GET['edit'];
    $order = matchOrderOne($_SESSION['orders'], $editId);

    if ($order !== null) {
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
$orders = $_SESSION['orders'];
$isEditing = $formData['order_id'] !== '';
$deleteOrder = null;

if (isset($_GET['delete'])) {
    $deleteOrder = matchOrderOne($orders, (int) $_GET['delete']);
}

$showAddModal = isset($_GET['open']) && $_GET['open'] === 'add';
$showDeleteModal = $deleteOrder !== null;
$showModal = $showDeleteModal || $showAddModal || $isEditing || !empty($errors);
