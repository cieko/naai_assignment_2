<?php

const PRICE_PER_LITER = 50;

function warmOrderStuff(): void
{
    if (!isset($_SESSION['orders'])) {
        $_SESSION['orders'] = [];
    }

    if (!isset($_SESSION['next_order_id'])) {
        $_SESSION['next_order_id'] = 1;
    }
}

function curdListPick(): array
{
    $typesList = [ 'Regular Curd', 'Low Fat Curd', 'Greek Curd', 'Homemade Curd' ];

    return $typesList;
}

function blankDataBag(): array
{
    return [
        'order_id' => '',
        'customer_name' => '', 'mobile_number' => '', 'quantity' => '',
        'curd_type' => '',
        'delivery_date' => '' ];
}

function postBitsNow(array $source): array
{
    $data = [];
    $data['order_id'] = trim($source['order_id'] ?? '');
    $data['customer_name'] = trim($source['customer_name'] ?? '');
    $data['mobile_number'] = trim($source['mobile_number'] ?? '');
    $data['quantity'] = trim($source['quantity'] ?? '');
    $data['curd_type'] = trim($source['curd_type'] ?? '');
    $data['delivery_date'] = trim($source['delivery_date'] ?? '');

    return $data;
}

function goHomeFastish(): void
{
    header('Location: index.php');
    exit;
}

function saveFlashPop(string $message, string $type = 'success', ?string $title = null): void
{
    $_SESSION['flash'] = [
        'message' => $message,
        'type' => $type,
        'title' => $title ?? ($type === 'success' ? 'Success' : 'Notice'),
    ];
}

function pullFlashOne(): ?array
{
    if (!isset($_SESSION['flash'])) {
        return null;
    }

    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);

    return $flash;
}

function safeTxtOut(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function rupeeTextMake(float $amount): string
{
    return '₹' . number_format($amount, 2);
}

function cutQtyShort($quantity): string
{
    return rtrim(rtrim((string) $quantity, '0'), '.');
}

function matchOrderOne(array $orders, int $orderId): ?array
{
    foreach ($orders as $order) {
        if ((int) $order['id'] === $orderId) {
            return $order;
        }
    }

    return null;
}

function sumAmtNow(float $quantity): float
{
    return $quantity * PRICE_PER_LITER;
}

function checkDataMix(array $data): array
{
    $errors = [];

    if ($data['customer_name'] === '') {
        $errors['customer_name'] = 'Customer name is required.';
    }

    if ($data['mobile_number'] === '') {
        $errors['mobile_number'] = 'Mobile number is required.';
    } 

    if ($data['quantity'] === '') {
        $errors['quantity'] = 'Quantity is required.';
    } 

    if ($data['curd_type'] === '') {
        $errors['curd_type'] = 'Type of curd is required.';
    }

    if ($data['delivery_date'] === '') {
        $errors['delivery_date'] = 'Delivery date is required.';
    } 

    return $errors;
}
