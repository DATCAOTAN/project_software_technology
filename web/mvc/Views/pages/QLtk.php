<div class="container-fluid" id="main-content">
    <div class="row justify-content-center"> <!-- Thêm justify-content-center -->
        <div class="col-lg-10 p-4 overflow-hidden"> <!-- Bỏ ms-auto -->
            <h3 class="mb-4 text-center">Quản lý tài khoản</h3> <!-- Thêm text-center -->

            <div class="text-end mb-4">
                <button type="button" class="btn btn-primary shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#add-account">
                    <i class="bi bi-plus-square"></i> Thêm tài khoản
                </button>
            </div>

            <div class="table-responsive-md mx-auto" style="height: 450px; overflow-y: scroll; max-width: 1200px;"> <!-- Thêm mx-auto và max-width -->
                <table class="table table-striped table-hover table-bordered">
                    <thead class="sticky-top">
                        <tr class="bg-dark text-light">
                            <th>ID</th>
                            <th>Tên tài khoản</th>
                            <th>Mật khẩu</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody id="account-data">
                        <?php foreach ($data as $account): ?>
                            <tr>
                                <td><?= $account['id'] ?></td>
                                <td><?= $account['ten_tai_khoan'] ?></td>
                                <td><?= $account['mat_khau'] ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" onclick="edit_account(<?= $account['id'] ?>)"
                                            class="btn btn-warning btn-sm edit-link"
                                            data-bs-toggle='modal'
                                            data-bs-target='#edit-account'>
                                            <i class="bi bi-pencil"></i> Sửa
                                        </button>
                                        <a href="javascript:void(0)" class="btn btn-danger btn-sm delete-link"
                                            data-action="delete"
                                            data-id="<?= $account['id'] ?>"
                                            onclick="deleteAccount(<?= $account['id'] ?>)">
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

<div class="modal fade" id="add-account" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="add_account_form">
                <div class="modal-header">
                    <span class="modal-title fs-5 font-weight-bold" id="staticBackdropLabel">Add Account</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold" for="name_account">Tên tài khoản</label>
                            <input type="text" id="name_account" name="name_account" class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold" for="password">Mật khẩu</label>
                            <input id="password" type="password" name="password" class="form-control shadow-none" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" onclick="addAccount()" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="edit-account" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="" id="edit_account_form" autocomplete="off">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title fs-5 font-weight-bold" id="staticBackdropLabel">Edit Account</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold" for="name_account">Tên tài khoản</label>
                            <input type="text" id="name_account" name="name_account" class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold" for="password">Mật khẩu</label>
                            <input id="password" type="password" name="password" class="form-control shadow-none" required>
                        </div>
                        <input type="hidden" name="account_id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" onclick="editAccountSubmit()" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
function addAccount() {
        let add_account_form = document.getElementById('add_account_form');
        var name = add_account_form.elements['name_account'].value;
        var pass = add_account_form.elements['password'].value;

        var data = new FormData();
        data.append('name', name);
        data.append('password', pass);

        var myModal = document.getElementById('add-account');
        var modal = bootstrap.Modal.getInstance(myModal);

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "QltkController/addAccount", true);
        // Bỏ dòng setRequestHeader khi dùng FormData

        xhr.onload = function() {
            if (this.responseText == 1) {
                alert("Added successful!");
                document.getElementById('add_account_form').reset();
                modal.hide(); // Di chuyển hide() vào đây sau khi thành công
                location.reload();
            } else {
                alert("Something wrong! " + this.responseText); // Thêm responseText để debug
            }
        }
        xhr.send(data);
    }
    function edit_account(id) {
        let edit_account_form = document.getElementById('edit_account_form');
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "QltkController/getAccountById", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
            let data = JSON.parse(this.responseText);
            edit_account_form.elements['account_id'].value = data.id;
            edit_account_form.elements['name_account'].value = data.ten_tai_khoan;
            edit_account_form.elements['password'].value = data.mat_khau;
        }
        xhr.send('get_account=' + id);
    }

    function editAccountSubmit() {
        let edit_account_form = document.getElementById('edit_account_form');
        var name = edit_account_form.elements['name_account'].value;
        var pass = edit_account_form.elements['password'].value;
        var data = new FormData();
        data.append('name', name);
        data.append('pass', pass);
        data.append('account_id', edit_account_form.elements['account_id'].value);


        var myModal = document.getElementById('edit-account');
        var modal = bootstrap.Modal.getInstance(myModal);

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "QltkController/editAccount", true);
        // Bỏ dòng setRequestHeader khi dùng FormData

        xhr.onload = function() {
            if (this.responseText == 1) {
                alert("Edited successful!");
                document.getElementById('edit_account_form').reset();
                modal.hide(); // Di chuyển hide() vào đây sau khi thành công
                location.reload();
            } else {
                alert("Something wrong! " + this.responseText); // Thêm responseText để debug
            }
        }
        xhr.send(data);
    }

    function deleteAccount(id) {
    if (confirm("Bạn có chắc chắn muốn xóa?")) {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "QltkController/deleteAccount", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
            let response = JSON.parse(this.responseText);
            if (response.status == "success") {
                alert(response.message);
                // Reload trang hoặc cập nhật giao diện sau khi xóa
            } else {
                alert(response.message);
            }
            location.reload();
        }
        xhr.send('id=' + id);
    }
}
</script>