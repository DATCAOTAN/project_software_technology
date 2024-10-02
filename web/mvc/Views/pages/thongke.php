<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bar Chart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .table-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .table thead th {
            background-color: #007bff;
            color: white;
        }
        .table tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }
        .table tbody tr:hover {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row mb-4">
        <!-- Div hiển thị combobox chọn môn học -->
        <div class="col-md-6 offset-md-3">
            <select id="monhoc" class="form-control" onchange="getData()">
                <option value="0">All subject</option>
                <?php foreach ($monHocs as $monHoc): ?>
                    <option value="<?php echo $monHoc['ID']; ?>"><?php echo $monHoc['Ten']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    
    <div class="row">
        <!-- Div hiển thị biểu đồ -->
        <div class="col-md-8">
            <canvas id="myChart"></canvas>
        </div>

        <!-- Div hiển thị bảng dữ liệu -->
        <div class="col-md-4 table-container">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID Sinh Viên</th>
                        <th>ID Lớp Học</th>
                        <th>ID Đề Thi</th>
                        <th>Điểm</th>
                        <th>Ngày Thi</th>
                    </tr>
                </thead>
                <tbody id="data-table-body">
                    <!-- Dữ liệu sẽ được chèn vào đây -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    var myChart = null; // Biến toàn cục để lưu trữ biểu đồ

    function getData() {
        var monhoc = document.getElementById("monhoc").value;
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                try {
                    var response = JSON.parse(this.responseText);
                    var chartData = response.chartData;
                    var tableData = response.tableData;

                    // Xử lý dữ liệu biểu đồ
                    var labels = [];
                    var values = [];
                    console.log(chartData);
                    chartData.forEach(function(item) {
                        labels.push(item.Ngay_Thi);
                        values.push(item.DiemAVG);
                    });

                    // Kiểm tra và hủy biểu đồ cũ nếu tồn tại
                    if (myChart instanceof Chart) {
                        myChart.destroy();
                    }

                    // Tạo biểu đồ cột mới
                    var ctx = document.getElementById('myChart').getContext('2d');
                    myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Điểm trung bình',
                                data: values,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)', // Màu nền cột
                                borderColor: 'rgba(54, 162, 235, 1)', // Màu viền cột
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });

                    // Xử lý dữ liệu bảng
                    var tableBody = document.getElementById('data-table-body');
                    tableBody.innerHTML = ''; // Xóa dữ liệu cũ
                    tableData.forEach(function(row) {
                        var tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${row.ID_SinhVien}</td>
                            <td>${row.ID_LopHoc}</td>
                            <td>${row.ID_DeThi}</td>
                            <td>${row.Diem}</td>
                            <td>${row.ngay_thi}</td>
                        `;
                        tableBody.appendChild(tr);
                    });
                } catch (e) {
                    console.error("Could not parse JSON response: ", this.responseText);
                }
            }
        };
        console.log(monhoc);
        xhr.open("GET", "ThongkeController/viewThongke/" + monhoc, true);
        xhr.send();
    }

    // Tạo biểu đồ ban đầu với dữ liệu "All subject"
    window.onload = function() {
        getData();
    };
</script>

</body>
</html>
