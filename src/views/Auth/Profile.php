<?php
session_start();
require_once __DIR__ .'/../config/head.php';
require_once __DIR__ . '/../../config/DatabaseConnection.php';

$userId = $_SESSION['userId'] ?? null;
if (!$userId) {
    header("Location: ../Auth/LoginAndSignUp.php");
    exit;
}

$db = (new DatabaseConnection())->getConnection();

// Lấy thông tin user nếu đã tồn tại
$stmt = $db->prepare("SELECT * FROM USERS WHERE ACCOUNTID = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$fullname = $user['FULLNAME'] ?? '';
$address = $user['ADDRESS'] ?? '';
$phone = $user['PHONE'] ?? '';
$email = $user['EMAIL'] ?? '';
$dob = $user['DATEOFBIRTH'] ?? '';
$hasUserInfo = $user !== null;

$success = false; // Để xác định có hiển thị SweetAlert không

// Nếu form được submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];

    if ($hasUserInfo) {
        $stmt = $db->prepare("UPDATE USERS SET FULLNAME=?, ADDRESS=?, PHONE=?, EMAIL=?, DATEOFBIRTH=? WHERE ACCOUNTID=?");
        $stmt->bind_param("sssssi", $fullname, $address, $phone, $email, $dob, $userId);
    } else {
        $stmt = $db->prepare("INSERT INTO USERS (ACCOUNTID, FULLNAME, ADDRESS, PHONE, EMAIL, DATEOFBIRTH) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $userId, $fullname, $address, $phone, $email, $dob);
    }

    if ($stmt->execute()) {
        $success = true;
    } else {
        $message = "Cập nhật thất bại: " . $stmt->error;
    }
}
?>

<?php include '../layout/includes/Header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Thông tin cá nhân</h2>
    <?php if (isset($message)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post" class="card p-4 shadow">
        <div class="mb-3">
            <label class="form-label">Họ tên</label>
            <input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($fullname) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Địa chỉ</label>
            <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($address) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Số điện thoại</label>
            <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($phone) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Ngày sinh</label>
            <input type="date" name="dob" class="form-control" value="<?= htmlspecialchars($dob) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>

<?php if ($success): ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({
    title: 'Thành công!',
    text: 'Thông tin đã được cập nhật.',
    icon: 'success',
    confirmButtonText: 'OK'
}).then((result) => {
    if (result.isConfirmed) {
        window.location.href = '../Pages/Home.php';
    }
});
</script>
<?php endif; ?>