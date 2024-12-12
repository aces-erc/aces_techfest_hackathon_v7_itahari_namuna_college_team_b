<?php
include_once '../config/db.php';
include_once '../includes/session.php';

// Fetch all manual payments
$stmt = $db->prepare("SELECT mp.*, u.full_name as user_name FROM manual_pay mp JOIN users u ON mp.user_id = u.user_id");
$stmt->execute();
$payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Manual Payments</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 p-8">
    <h2 class="text-2xl font-semibold mb-6">Manual Payment Verifications</h2>
    <table class="w-full border border-gray-300 bg-white">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-3 border">ID</th>
                <th class="p-3 border">User Name</th>
                <th class="p-3 border">Full Name</th>
                <th class="p-3 border">Payee Account</th>
                <th class="p-3 border">Receipt ID</th>
                <th class="p-3 border">Amount</th>
                <th class="p-3 border">Status</th>
                <th class="p-3 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($payments as $payment): ?>
                <tr>
                    <td class="p-3 border"><?php echo $payment['id']; ?></td>
                    <td class="p-3 border"><?php echo htmlspecialchars($payment['user_name']); ?></td>
                    <td class="p-3 border"><?php echo htmlspecialchars($payment['full_name']); ?></td>
                    <td class="p-3 border"><?php echo htmlspecialchars($payment['payee_account_number']); ?></td>
                    <td class="p-3 border"><?php echo htmlspecialchars($payment['receipt_id']); ?></td>
                    <td class="p-3 border"><?php echo htmlspecialchars($payment['amount']); ?></td>
                    <td class="p-3 border"><?php echo htmlspecialchars($payment['status']); ?></td>
                    <td class="p-3 border">
                        <?php if ($payment['status'] === 'unpaid'): ?>
                            <form method="POST" action="update_manualpay_status.php">
                                <input type="hidden" name="id" value="<?php echo $payment['id']; ?>">
                                <button type="submit" name="action" value="mark_paid"
                                    class="bg-green-500 text-white px-3 py-1 rounded">Mark as Paid</button>
                            </form>
                        <?php else: ?>
                            <span class="text-green-500 font-bold">Paid</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

