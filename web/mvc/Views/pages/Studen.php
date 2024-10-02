<html>
<?php
// echo 2;
?>
<style>
    .dong div {
        white-space: nowrap;
    }
    .dong {
	display: flex;
	justify-content: space-around;
	border: 1px solid #000;
	height: 30px;
    /* margin-left: -20px; */
	margin-top: 2px
	
}
.data-container {
    display: flex;
    flex-direction: column;
    
}

.dong {
    display: flex;
    justify-content: space-between;
    padding: 5px 10px 0px 10px;    
    user-select: none;

    border-bottom: 1px solid #ccc;
}

.cell {
    flex: 1;
    padding: 5px;

}

.no-data {
    padding: 10px;
}

#dataQ *{
	list-style-type: none;

}

#contentQ{
	height: 70px;
	width: 200px;
	font-size: 20px;
}

        /* CSS cho phần tử container */
        /* CSS cho container chứa danh sách Học viên */
.gv-container {
    width: 100%;
    padding: 20px;
}

/* CSS cho mỗi item Học viên */
.gv-item {
    background-color: #f0f0f0;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 20px;
}

/* CSS cho thông tin Học viên */
.gv-info {
    font-size: 16px;
}

/* CSS cho nhãn */
.gv-label {
    margin-bottom: 5px;
}

/* CSS cho checkbox */
input[type="checkbox"] {
    transdiv: scale(1.5); /* Tăng kích thước checkbox */
    margin-right: 10px; /* Khoảng cách giữa checkbox và nhãn */
}

/* CSS cho thông báo khi không có môn học */
.no-gv {
    font-size: 18px;
    color: #FF0000;
}


        /* CSS cho nút cập nhật */
        .update-button {
            display: block;
            width: 100%;
            max-width: 200px;
            margin: 0 auto;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
        }
</style>

<section class="mainContent" id="Mainpages">
    <div class="">
        <div class="cauhoi-header">
            <div class="search-container">
                <input type="text" id="searchInput" name="keyword" placeholder="Tìm kiếm Học viên...">
                <button type="button" id="searchbtn">Tìm kiếm</button>
            </div>
            <div class="chucnang">
                
                <!-- <button id="createsub" class="button"> Tạo Học viên</button> -->
                <button id="editsub" class="button" style="Display:none;"  > Phân Môn cho Học viên </button>
                <!-- <div method="post" action="SubController/remove"> 
                    <input type="hidden" name="subjectIdToDelete" id="idremove" value="" > 
                    <button style="height: 50px;" type="submit" id="removesub" name="deleteSubject" class="button">Xóa Học viên</button>
                </div> -->
            </div>

        </div>


        <div class="cross">
            <div class="horizontal-line"></div>
            <div class="vertical-line"></div>
            <div class="labels">
                <span>Thông tin học viên</span>
                
            </div>
            <div>
                <div  style="display:none" id="selectedRowInfo"></div>

                <div id="dataQ">

                    <?php
                    $html = '<table>';
                    

                    if (!empty($data["AllStuden"])) {
                        foreach ($data["AllStuden"] as $row) {
                            $html .= '<div class="dong">';
                            $html .= '<div id="ID">' . $row['ID'] . '</div>';
                            $html .= '<div>' . $row['Ten'] . '</div>';
                            $html .= '<div>' . $row['email'] . '</div>';
                            $html .= '<div>' . $row['Ngay_Sinh'] . '</div>';
                            $html .= '<div>' . $row['Gioi_Tinh'] . '</div>';
                            $html .= '</div>';
                        }
                    } else {
                        // Nếu không có kết quả, hiển thị thông báo "chưa có Học viên nào"
                        $html .= '<tr><td colspan="4">Chưa có Học viên nào</td></tr>';
                    }

                    $html .= '</table>';
                    echo $html;
                    ?>
                </div>

            </div>
        </div>
    </div>

    <div class="Sticket" id="edit" >
        <div class="modal-content">
            <div class="modalheader">
                <button id="closeedit"> x<i class="ti-close"></i> </button>
            </div>
            <form method="post" action="StudenController/confirm" id="infor">

                    
            </form>


        </div>
    </div>


</section>
<script>
    // alert(1)
    document.addEventListener("DOMContentLoaded", function() {
        /// an hien cac thong tin
        var searchbtn = document.querySelector("#searchbtn")
        // var CreateQ = document.querySelector("#createsub")
        var FixSub = document.querySelector("#editsub")
        // var closecreateQ = document.querySelector("#closecreateQ");
        var closeedit = document.querySelector("#closeedit");




        FixSub.addEventListener("click", showEdit);
        closeedit.addEventListener("click", closeE)
        //show de thi
        searchbtn.addEventListener("click", searchGV);
        //

        addeventforrow();
    });

    var closeQ = function() {
        modal = document.querySelector("#create");
        modal.style.display = "none";
        // showcauhoi();
    }
    var closeE = function() {
        modal = document.querySelector("#edit");
        modal.style.display = "none";
        // showcauhoi();
    }

    var showCreateQ = function() {
        modal = document.querySelector("#create");
        modal.style.display = "block"

        //// cao data tao div
        console.log(1)

    };
    var showEdit = function() {
        let select = document.querySelector("#selectedRowInfo");
        console.log(select.textContent)
        text = select.textContent;
        // console.log(remove)


        if (select.textContent.trim() === "") alert(" chọn Học viên để phân môn ");
        else {
            loadpanelPhanmon();
            modal = document.querySelector("#edit");
            modal.style.display = "block"

            //// cao data tao div
            console.log(1)
        }

        

    };
    var loadpanelPhanmon = function() {
        let searchValue = document.querySelector("#selectedRowInfo").textContent;
        
        // console.log(searchValue)


        let data = document.getElementById("infor");
        while (data.firstChild) {
            data.removeChild(data.firstChild);
        }

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Hiển thị kết quả trong phần tử HTML với id là 'dataQ'
                data.innerHTML = this.responseText;
                // alert(this.responseText)
            }
        };
        xhttp.open("GET", "StudenController/loadinfor/" + searchValue, true);
        xhttp.send();
    }





    var searchGV = function() {
        let searchValue = document.getElementById("searchInput").value.trim();

        if (searchValue === "") {
            alert("Nhập dữ liệu để tìm kiếm");
            reload();
            return;
        }
        // Xây dựng URL mới với searchValue được truyền qua query string
        let url = `./StudenController/search/${searchValue}`;
        let data = document.getElementById("dataQ");
        while (data.firstChild) {
            data.removeChild(data.firstChild);
        }

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Hiển thị kết quả trong phần tử HTML với id là 'dataQ'
                data.innerHTML = this.responseText;
                // alert(this.responseText)
                addeventforrow();
            }
        };
        xhttp.open("GET", url, true);
        xhttp.send();
        
    }


    var reload = function() {
        window.location.href = "http://localhost/web/StudenController";
    }

    var addeventforrow = function() {
        var selectedRowInfo = document.querySelector('#selectedRowInfo');
        var rows = document.querySelectorAll('.dong');

        // Lặp qua từng dòng và thêm sự kiện click
        rows.forEach(row => {
            row.addEventListener('click', function() {
                // Loại bỏ màu nền của tất cả các dòng
                rows.forEach(row => {
                    row.style.backgroundColor = '';
                    row.style.color = 'black';
                });

                // Đặt màu nền cho dòng được click
                this.style.backgroundColor = '#ff9900';
                this.style.color = 'white'

                // In ra thông tin của dòng được chọn
                selectedRowInfo.textContent = this.querySelector('#ID').textContent;

                console.log(this.querySelector('#ID').textContent)
            });
        });
    }



    var loadchapter = function() {

    }

    var showdethi = function() {};
    var showHocvien = function() {};
</script>

</html>