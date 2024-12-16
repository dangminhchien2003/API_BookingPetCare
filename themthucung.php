<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

include 'db.php'; // Kết nối đến cơ sở dữ liệu

// Lấy dữ liệu từ yêu cầu
$data = json_decode(file_get_contents("php://input"), true);

// Kiểm tra dữ liệu nhận được
if (isset($data['tenthucung'], $data['idnguoidung'], $data['loaithucung'], $data['giongloai'], $data['tuoi'], $data['cannang'], $data['suckhoe'])) {
    
    // Lấy dữ liệu từ phía client
    $tenthucung = $data['tenthucung'];
    $idnguoidung = $data['idnguoidung'];
    $loaithucung = $data['loaithucung'];
    $giongloai = $data['giongloai'];
    $tuoi = $data['tuoi'];
    $cannang = $data['cannang'];
    $suckhoe = $data['suckhoe'];

    // Tạo câu truy vấn, không cần truyền idthucung vì MySQL sẽ tự động tạo (AUTO_INCREMENT)
    $query = "INSERT INTO thucung (tenthucung, idnguoidung, loaithucung, giongloai, tuoi, cannang, suckhoe) 
              VALUES ('$tenthucung', '$idnguoidung', '$loaithucung', '$giongloai', '$tuoi', '$cannang', '$suckhoe')";

    // Thực thi câu truy vấn
    if (mysqli_query($conn, $query)) {
        echo json_encode(["success" => true, "message" => "Thêm thú cưng thành công"]);
    } else {
        // Trả về lỗi từ MySQL để dễ dàng debug
        echo json_encode(["success" => false, "message" => "Lỗi khi thêm thú cưng: " . mysqli_error($conn)]);
    }
} else {
    // Trường hợp thiếu dữ liệu từ phía client
    echo json_encode(["success" => false, "message" => "Thiếu dữ liệu đầu vào"]);
}

// Đóng kết nối
mysqli_close($conn);
?>
