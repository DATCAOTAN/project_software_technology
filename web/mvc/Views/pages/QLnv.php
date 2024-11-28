<div class="container-fluid" id="main-content">
    <div class="row justify-content-center"> <!-- Thêm justify-content-center -->
        <div class="col-lg-10 p-4 overflow-hidden"> <!-- Bỏ ms-auto -->
            <h3 class="mb-4 text-center">Quản lý nhân viên</h3> <!-- Thêm text-center -->

            <div class="text-end mb-4">
                <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#add-employee">
                    <i class="bi bi-plus-square"></i> Add
                </button>
            </div>

            <div class="table-responsive-md mx-auto" style="height: 450px; overflow-y: scroll; max-width: 1200px;"> <!-- Thêm mx-auto và max-width -->
                <table class="table table-striped table-hover table-bordered">
                    <thead class="sticky-top">
                        <tr class="bg-dark text-light">
                            <th scope="col">ID</th>
                            <th scope="col">Tên</th>
                            <th scope="col">SĐT</th>
                            <th scope="col">Email</th>
                            <th scope="col">Tài khoản ID</th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody id="employee-data">
                        <?php foreach ($data as $employee): ?>
                            <tr>
                                <td><?= $employee['id'] ?></td>
                                <td><?= $employee['ten'] ?></td>
                                <td><?= $employee['so_dien_thoai'] ?></td>
                                <td><?= $employee['email'] ?></td>
                                <td><?= $employee['tai_khoan_id'] ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" onclick="edit_staff(<?= $employee['id'] ?>)"
                                            class="btn btn-warning btn-sm edit-link"
                                            data-bs-toggle='modal'
                                            data-bs-target='#edit-employee'>
                                            <i class="bi bi-pencil"></i> Sửa
                                        </button>
                                        <a href="javascript:void(0)" class="btn btn-danger btn-sm delete-link"
                                            data-action="delete"
                                            data-id="<?= $employee['id'] ?>"
                                            onclick="deleteEmployee(<?= $employee['id'] ?>)">
                                            <i class="bi bi-trash"></i> Xóa
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="add-employee" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="add_employee_form">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Staff</h1>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold" for="name">Họ Và Tên</label>
                            <input type="text" id="name" name="name" class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold" for="phone">Phone</label>
                            <input id="phone" type="text" name="phone" class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold" for="email">Email</label>
                            <input id="email" type="email" name="email" class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold" for="account">Tài Khoản</label>
                            <select id="account" name="account" class="form-control shadow-none" required>
                                <option value="" selected disabled>-- Chọn tài khoản --</option>
                                <?php foreach ($dataAccountForUser as $account): ?>
                                    <option value="<?= $account['id'] ?>"><?= $account['ten_tai_khoan'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                    <button type="button" onclick="addStaff()" class="btn custom-bg text-secondary shadow-none">SUBMIT</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="edit-employee" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="" id="edit_employee_form" autocomplete="off">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Employee</h1>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold" for="name">Họ Và Tên</label>
                            <input type="text" id="name" name="name" class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold" for="phone">Phone</label>
                            <input id="phone" type="text" name="phone" class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold" for="email">Email</label>
                            <input id="email" type="email" name="email" class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold" for="account">Tài Khoản</label>
                            <select id="account" name="account" class="form-control shadow-none" required>
                                <option value="" selected disabled>-- Chọn tài khoản --</option>
                                <?php foreach ($dataAccountForUser as $account): ?>
                                    <option value="<?= $account['id'] ?>"><?= $account['ten_tai_khoan'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <input type="hidden" name="employee_id">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold" for="account">Tài Khoản Đang sử dụng: <span id="account_name" name="account_name"></span></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                    <button type="button" onclick="editStaffsubmit()" class="btn custom-bg text-secondary shadow-none">SUBMIT</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    function addStaff() {
        let add_employee_form = document.getElementById('add_employee_form');
        var name = add_employee_form.elements['name'].value;
        var phone = add_employee_form.elements['phone'].value;
        var email = add_employee_form.elements['email'].value;
        var account_id = document.getElementById("account").value;

        if (account_id == "") {
            alert("Vui lòng chọn tài khoản");
            return;
        }

        var data = new FormData();
        data.append('name', name);
        data.append('phone', phone);
        data.append('email', email);
        data.append('account_id', account_id);

        var myModal = document.getElementById('add-employee');
        var modal = bootstrap.Modal.getInstance(myModal);

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "QlnvController/addEmployee", true);
        // Bỏ dòng setRequestHeader khi dùng FormData

        xhr.onload = function() {
            if (this.responseText == 1) {
                alert("Added successful!");
                document.getElementById('add_employee_form').reset();
                modal.hide(); // Di chuyển hide() vào đây sau khi thành công
                location.reload();
            } else {
                alert("Something wrong! " + this.responseText); // Thêm responseText để debug
            }
        }
        xhr.send(data);
    }

    // function get_staffs() {
    //     let xhr = new XMLHttpRequest();
    //     xhr.open("POST", "QlnvController/getAll", true);
    //     xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    //     xhr.onload = function() {
    //         document.getElementById('employee-data').innerHTML = this.responseText;
    //     }
    //     xhr.send('get_employees');
    // }

    function edit_staff(id) {
        let edit_employee_form = document.getElementById('edit_employee_form');
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "QlnvController/getEmployeeById", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
            let data = JSON.parse(this.responseText);
            edit_employee_form.elements['employee_id'].value = data.id;
            edit_employee_form.elements['name'].value = data.ten;
            edit_employee_form.elements['phone'].value = data.so_dien_thoai;
            edit_employee_form.elements['email'].value = data.email;
            // edit_employee_form.elements['account'].value = data.tai_khoan_id;
            document.getElementById('account_name').innerHTML = data.tai_khoan_id + "-" + data.ten_tai_khoan;
        }
        xhr.send('get_employee=' + id);
    }

    function editStaffsubmit() {
        let edit_staff_form = document.getElementById('edit_staff_form');
        var name = edit_employee_form.elements['name'].value;
        var phone = edit_employee_form.elements['phone'].value;
        var email = edit_employee_form.elements['email'].value;
        var account_id = edit_employee_form.elements['account'].value
        console.log(name + " " + phone + " " + email + " " + account_id);
        if (account_id == "") {
            alert("Vui lòng chọn tài khoản");
            return;
        }

        var data = new FormData();
        data.append('name', name);
        data.append('phone', phone);
        data.append('email', email);
        data.append('account_id', account_id);
        data.append('employee_id', edit_employee_form.elements['employee_id'].value);


        var myModal = document.getElementById('edit-employee');
        var modal = bootstrap.Modal.getInstance(myModal);

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "QlnvController/editEmployee", true);
        // Bỏ dòng setRequestHeader khi dùng FormData

        xhr.onload = function() {
            if (this.responseText == 1) {
                alert("Edited successful!");
                document.getElementById('edit_employee_form').reset();
                modal.hide(); // Di chuyển hide() vào đây sau khi thành công
                location.reload();
            } else {
                alert("Something wrong! " + this.responseText); // Thêm responseText để debug
            }
        }
        xhr.send(data);
    }

    function deleteEmployee(id) {
    // Kiểm tra id hợp lệ
    if (!id || isNaN(id)) {
        alert("ID không hợp lệ!");
        return;
    }

    if (confirm("Bạn có chắc chắn muốn xóa nhân viên này?")) {
        console.log("ID cần xóa:", id); // Log ID để kiểm tra

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "./QLnvController/deleteEmployee/", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        // Hiển thị thông báo xử lý (có thể thêm spinner hoặc disable nút xóa)
        console.log("Đang gửi yêu cầu xóa...");

        xhr.onload = function() {
    console.log("Response từ server:", xhr.responseText); // Kiểm tra phản hồi

    try {
        // Tìm JSON trong phản hồi (loại bỏ văn bản thừa)
        let jsonResponse = xhr.responseText.match(/\{.*\}/s); // Tìm JSON bằng regex
        
        if (jsonResponse) {
            let response = JSON.parse(jsonResponse[0]); // Parse JSON đã làm sạch
            
            // Kiểm tra trạng thái
            if (response.status === "success") {
                alert(response.message || "Xóa thành công!");
                location.reload();  // Tải lại trang hoặc cập nhật giao diện
            } else {
                alert(response.message || "Xóa thất bại. Vui lòng thử lại.");
            }
        } else {
            throw new Error("Không tìm thấy JSON hợp lệ trong phản hồi.");
        }
    } catch (error) {
        console.error("Lỗi parse JSON:", error, "Raw response:", xhr.responseText);
        alert("Phản hồi không hợp lệ từ server. Vui lòng thử lại.");
    }
};
xhr.send('id=' + id);

}
    }




</script>