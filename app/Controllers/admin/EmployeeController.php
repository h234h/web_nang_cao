<?php
// app/controllers/admin/EmployeeController.php
require_once __DIR__ . "/../../models/Employee.php";
require_once __DIR__ . "/../../Core/BaseController.php";

class EmployeeController extends BaseController
{
    private $employeeModel;

    public function __construct()
    {
        $this->employeeModel = new Employee();
    }

    // 📌 Danh sách nhân viên
    public function index()
    {
        $employees = $this->employeeModel->all();
        $this->view("admin/employees/index", ["employees" => $employees]);
    }

    // 📌 Form thêm nhân viên
    public function create()
    {
        $this->view("admin/employees/form", ["employee" => null]);
    }

    // 📌 Form sửa nhân viên
    public function edit($id)
    {
        $employee = $this->employeeModel->find($id);
        $this->view("admin/employees/form", ["employee" => $employee]);
    }

    // 📌 Lưu dữ liệu (thêm mới hoặc cập nhật)
    public function save()
    {
        $id = $_POST["id"] ?? null;

        // Gom dữ liệu từ form
        $data = [
            ":username" => $_POST["username"],
            ":fullname" => $_POST["fullname"],
            ":email"    => $_POST["email"],
            ":phone"    => $_POST["phone"],
            ":address"  => $_POST["address"],
            ":status"   => $_POST["status"] ?? 1, // mặc định hoạt động
        ];

        // Nếu có nhập mật khẩu thì hash
        if (!empty($_POST["password"])) {
            $data[":password"] = password_hash($_POST["password"], PASSWORD_BCRYPT);
        }

        // 📌 Kiểm tra trùng username
        if ($this->employeeModel->existsUsername($_POST["username"], $id)) {
            $error = "⚠️ Username đã tồn tại!";
            $this->view("admin/employees/form", [
                "employee" => $id ? $this->employeeModel->find($id) : null,
                "error" => $error
            ]);
            return;
        }

        // 📌 Kiểm tra trùng email
        if ($this->employeeModel->existsEmail($_POST["email"], $id)) {
            $error = "⚠️ Email đã tồn tại!";
            $this->view("admin/employees/form", [
                "employee" => $id ? $this->employeeModel->find($id) : null,
                "error" => $error
            ]);
            return;
        }

        // Nếu có id => update
        if ($id) {
            $this->employeeModel->update($id, $data);
        }
        // Nếu không có id => insert
        else {
            if (empty($_POST["password"])) {
                $error = "⚠️ Password là bắt buộc khi thêm nhân viên mới";
                $this->view("admin/employees/form", [
                    "employee" => null,
                    "error" => $error
                ]);
                return;
            }
            $data[":password"] = password_hash($_POST["password"], PASSWORD_BCRYPT);
            $this->employeeModel->insert($data);
        }

        // Quay lại danh sách
        $this->redirect("admin/Employee/index");
    }
}
