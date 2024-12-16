<?php
include 'db.php'; // Kết nối đến cơ sở dữ liệu
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

header('Content-Type: application/json'); // Đảm bảo phản hồi là JSON

// Lấy dữ liệu từ request
$data = json_decode(file_get_contents('php://input'), true);

// Kiểm tra nếu có dữ liệu
if (isset($data['idthucung']) && isset($data['tenthucung']) && isset($data['loaithucung']) && isset($data['giongloai']) && isset($data['tuoi']) && isset($data['cannang']) && isset($data['suckhoe'])) {
    // Lấy dữ liệu thú cưng từ request
    $idthucung = $data['idthucung'];
    $tenthucung = $data['tenthucung'];
    $loaithucung = $data['loaithucung'];
    $giongloai = $data['giongloai'];
    $tuoi = $data['tuoi'];
    $cannang = $data['cannang'];
    $suckhoe = $data['suckhoe'];

    // Cập nhật thông tin thú cưng trong CSDL
    $sql = "UPDATE thucung SET tenthucung = ?, loaithucung = ?, giongloai = ?, tuoi = ?, cannang = ?, suckhoe = ? WHERE idthucung = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssiiss", $tenthucung, $loaithucung, $giongloai, $tuoi, $cannang, $suckhoe, $idthucung);

    // Kiểm tra xem câu lệnh có thành công hay không
    if ($stmt->execute()) {
        $response = array('success' => true, 'message' => 'Thông tin thú cưng đã được cập nhật');
    } else {
        $response = array('success' => false, 'message' => 'Cập nhật không thành công');
    }

    $stmt->close();
} else {
    $response = array('success' => false, 'message' => 'Thiếu thông tin');
}

// Đóng kết nối CSDL
$conn->close();

// Gửi phản hồi về client
echo json_encode($response);
?>
