<?php
include '../config.php';
$admin = new Admin();

if (isset($_GET['acc_id'])) {
    $acc_id = $_GET['acc_id'];

    // Get total CNY added
    $convert = $admin->ret("SELECT SUM(cny) as total_cny FROM `convert` WHERE acc_id = '$acc_id'");
    $converted = $convert->fetch(PDO::FETCH_ASSOC)['total_cny'] ?? 0;

    // Get total CNY spent
    $spent = $admin->ret("SELECT SUM(neg_cny) as spent_cny FROM `spend` WHERE acc_id = '$acc_id'");
    $used = $spent->fetch(PDO::FETCH_ASSOC)['spent_cny'] ?? 0;

    $balance = $converted - $used;

    echo json_encode([
        'balance' => number_format($balance, 2)
    ]);
}
?>


