<style>

    #selectchapterject {
        padding: 10px;
        font-size: 16px;
        /* border: 1px solid #ccc; */
        border-radius: 5px;
        background-color: #fff;
        color: #333;
        width: 200px;
    }

    /* CSS cho option trong dropdown list */
    #selectchapterject option {
        padding: 10px;
        font-size: 16px;
        background-color: #fff;
        color: #333;
    }

    /* CSS cho khi hover trên option */
    #selectchapterject option:hover {
        background-color: #f0f0f0;
    }

    /* CSS cho bảng */
    .table-container {
        width: 100%;
        height: 500px;
        max-height: 700px;
        /* Đặt chiều cao 
        tối đa */
        overflow-y: auto;
        overflow-x: hidden;
        /* Tạo thanh cuộn dọc */
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    /* CSS cho các ô trong bảng */
    td,
    th {
        /* border: 1px solid #dddddd; */
        text-align: left;
        padding: 8px;
    }

    /* CSS cho hàng chẵn */
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    /* CSS cho hover */
    tr:hover {
        background-color: #ddd;
    }

    /* CSS cho tiêu đề cột */
    th {
        background-color: #4CAF50;
        color: white;
    }

    #Mainpages {
        position: relative;
    }

    .Sticket {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 5;

    }

    .modal-content {
        top: 0%;
        background-color: white;
        margin: 8% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 90%;
        max-width: 900px;
        position: relative;
    }



    .modalheader {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .select {
        width: 200px;
        height: 40px;
    }

    .cauhoi * {
        padding: 0;
        margin: 5px;
    }

    .dapan * {
        padding: 0;
        margin: 5px;
    }

    .taonoidung {
        display: flex;
        justify-content: space-between;
    }


    .modalheader {
        justify-content: right;
    }

    #data {
        /* border-style:solid ; */
        position: absolute;
        top: 20%;
        left: 7%;
        width: 95%;
        border-collapse: collapse;
    }

    .dong {
        display: flex;
        justify-content: space-around;
        /* border: 1px solid #000; */
        height: 30px;
        margin-left: -20px;
        margin-top: 2px
    }

    .data-container {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .dong {
        display: flex;
        justify-content: space-between;
        padding: auto;
        /* border-bottom: 1px solid #ccc; */
    }

    .cell {
        flex: 1;
        padding: 5px;
    }

    .no-data {
        padding: 10px;
    }

    #dataQ * {
        list-style-type: none;

    }

    #contentQ {
        height: 70px;
        width: 200px;
        font-size: 20px;
    }

    .dong {
        display: flex;
        justify-content: space-around;
        border: 1px solid #000;
        height: 30px;
        /* margin-left: -20px; */
        width: 750px;
        margin-top: 2px
    }

    .data-container {
        display: flex;
        flex-direction: column;
    }

    .dong {
        display: flex;
        justify-content: space-between;
        padding: 5px 190px 0px 140px;
        border-bottom: 1px solid #ccc;
    }

    .cell {
        flex: 1;
        padding: 5px;
    }

    .no-data {
        padding: 10px;
    }

    #dataQ * {
        list-style-type: none;

    }

    #contentQ {
        height: 70px;
        width: 200px;
        font-size: 20px;
    }

    .input{
        height: 40px;
        width: 200px;
    }
</style>

<section class="mainContent" id="Mainpages">
    <div class="">
        <div class="cauhoi-header">
            <?php
            // include("ChapterController/loadmonhoc");s
            $html = '<select id="Mainselect" name="Mainselect">';
            $html .= '<option value="0">Chọn Môn học</option>'; // Option mặc định
            if (!empty($data["Sub"])) {
                foreach ($data["Sub"] as $row) {
                    $html .= '<option value="' . $row['ID'] . '">' . $row['Ten'] . '</option>';
                }
            } else {
                // Nếu không có kết quả, hiển thị option mặc định
                $html .= '<option value="">Không có Môn học</option>';
            }
            $html .= '</select>';
            echo $html;

            ?>
            <div class="chucnang">

                <button id="createchapter" class="button"> Tạo Chương</button>
                <button id="editchapter" class="button"> Sửa Chương </button>
                <button id="removechapter" class="button"> Xóa Chương </button>

            </div>

        </div>
        <div class="table-container">
            <div class="cross">
                <div class="horizontal-line"></div>
                <div class="vertical-line"></div>
                <div class="labels">
                    <span>ID</span>
                    <span>Tên Môn Hoc</span>
                    <!-- <span>Độ khó</span> -->
                    <!-- <span>Người tạoo</span> -->
                </div>
                <div style="display: none;" id="selectedRowInfo"></div>
                <div  id="data">


                    <table>
                        <?php
                        $html = '<table>';


                        if (!empty($data["AllChapter"])) {
                            foreach ($data["AllChapter"] as $row) {
                                $html .= '<div class="dong">';
                                $html .= '<div id="ID">' . $row['ID'] . '</div>';
                                $html .= '<div id="name">' . $row['Ten'] . '</div>';
                                $html .= '</div>';
                            }
                        } else {
                            // Nếu không có kết quả, hiển thị thông báo "chưa có câu hỏi nào"
                            $html .= '<tr><td colspan="4">Chưa có câu hỏi nào</td></tr>';
                        }

                        $html .= '</table>';
                        echo $html;
                        ?>
                    </table>
                </div>
            </div>

            <div class="Sticket" id="create">
                <div class="modal-content">
                    <div class="modalheader">
                        <button id="closecreateQ"> x<i class="ti-close"></i> </button>
                    </div>
                    <div >

                        <?php
                        // include("ChapterController/loadmonhoc");s
                        $html = '<select id="selectcreate" name="selectcreate">';
                        $html .= '<option value="0">Chọn Môn học</option>'; // Option mặc định
                        if (!empty($data["Sub"])) {
                            foreach ($data["Sub"] as $row) {
                                $html .= '<option value="' . $row['ID'] . '">' . $row['Ten'] . '</option>';
                            }
                        } else {
                            // Nếu không có kết quả, hiển thị option mặc định
                            $html .= '<option value="">Không có Môn học</option>';
                        }
                        $html .= '</select>';
                        echo $html;

                        ?>

                        <div class="cauhoi">
                            <p>Tên Chương</p>
                            <input id="contentCreateChapter" type="text" class="input">
                        </div>

                        <button class="button" id="confirmcreate">Tạo môn học</button>
                    </div>


                </div>
            </div>
            <div class="Sticket" id="edit">
                <div class="modal-content">
                    <div class="modalheader">
                        <button id="closeedit"> x<i class="ti-close"></i> </button>
                    </div>
                    <div method="post" action="ChapterController/edit">

                        <input type="hidden" id="idfix" name="idfix" value="">
                        <?php
                        // include("ChapterController/loadmonhoc");s
                        $html = '<select id="selectedit" name="selectedit">';
                        $html .= '<option value="0">Chọn Môn học</option>'; // Option mặc định
                        if (!empty($data["Sub"])) {
                            foreach ($data["Sub"] as $row) {
                                $html .= '<option value="' . $row['ID'] . '">' . $row['Ten'] . '</option>';
                            }
                        } else {
                            // Nếu không có kết quả, hiển thị option mặc định
                            $html .= '<option value="">Không có Môn học</option>';
                        }
                        $html .= '</select>';
                        echo $html;

                        ?>
                        <div class="cauhoi">
                            <p>Tên Chương mới</p>
                            <input id="Newchapter" type="text" class="input">
                        </div>

                        <button  class="button" id="confirmfix">Sửa môn học</button>
                    </div>


                </div>
            </div>
</section>

<script>
    // alert(1)
    document.addEventListener("DOMContentLoaded", function() {
        /// an hien cac thong tin
        $('#createchapter').hide();
            $('#editchapter').hide();
            $('#removechapter').hide();
            const userdata = JSON.parse(localStorage.getItem("userData"));
            userID = userdata.userId;
            $.ajax({
                url: './SubController/getchucnang/' + userID+ '/Chapter',
                method: 'POST',
                success: function(response) {
                    console.log(response);
                    response.forEach(function(privilege) {
                        if (privilege.cn === 'Add') {
                            $('#createchapter').show();
                        }
                        if (privilege.cn === 'Edit') {
                            $('#editchapter').show();
                        }
                        if (privilege.cn === 'Remove') {
                            $('#removechapter').show();
                        }
                    });
                },
                error: function() {
                    console.error(error);
                }
            });  
        // alert(1);
        // select element
        // console.log(closeloggin)
        // var searchbtn = document.querySelector("#searchbtn")
        var CreateQ = document.querySelector("#createchapter")
        var Fixchapter = document.querySelector("#editchapter")
        var closecreateQ = document.querySelector("#closecreateQ");
        var closeedit = document.querySelector("#closeedit");
        var mon = document.querySelector("#Mainselect");

        var create =document.querySelector("#confirmcreate");
        var fix = document.querySelector("#confirmfix")
        var remove =document.querySelector("#removechapter")
        //show cau hoi
        CreateQ.addEventListener("click", showCreateQ)
        closecreateQ.addEventListener("click", closeQ);
        //login

        Fixchapter.addEventListener("click", showEdit);
        closeedit.addEventListener("click", closeE)
        //show de thi
        // searchbtn.addEventListener("click", searchQ);
        //
        create.addEventListener("click",Create);
        fix.addEventListener("click", Fix);

        remove.addEventListener("click", removechapter)
        mon.addEventListener("change", fillChapter)

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
        // console.log(1)

    };

    var Create =function(){
        let input =document.querySelector("#contentCreateChapter").value;
        // console.log(input);
        let mon =document.querySelector("#selectcreate").value;

        console.log(input,mon);

        if(input.trim() == "")alert(" Vui Lòng Nhập Tên Môn")
        else if(mon == 0 )alert(" Vui lòng chọn Môn cho Chương")
        else
        {
            
            let url = `./ChapterController/create/${input}/${mon}`;
            // let data = document.getElementById("dataQ");
           
    
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Hiển thị kết quả trong phần tử HTML với id là 'dataQ'
                    // data.innerHTML = this.responseText;
                    alert(this.responseText)
                }
            };
            xhttp.open("GET", url, true);
            xhttp.send();
            reload();
        }
    }

    var showEdit = function() {
        let select = document.querySelector("#selectedRowInfo").textContent;
        // console.log(select.textContent)
        let selected = select.split('/');
        let id = selected[0];
        let name =selected[1];
        console.log(select)

        document.querySelector("#Newchapter").value = name;


        if (name == undefined) alert(" chọn môn để edit ");
        else {

            modal = document.querySelector("#edit");
            modal.style.display = "block"

            //// cao data tao div
            // console.log(1)
        }


    };

    var Fix =function(){
        let input =document.querySelector("#Newchapter").value;
        // console.log(input);
        let mon =document.querySelector("#selectedit").value;
        let select = document.querySelector("#selectedRowInfo").textContent;
        // console.log(select.textContent)
        let selected = select.split('/');
        let id = selected[0];
        console.log(id,input,mon);

        
        if(input.trim() == "")alert(" Vui Lòng Nhập Tên Môn")
        if(mon ==0 )alert(" Vui Lòng Chọn môn ")
        else
        {
            
            let url = `./ChapterController/edit/${id}/${input}/${mon}`;
            // let data = document.getElementById("dataQ");
           
    
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Hiển thị kết quả trong phần tử HTML với id là 'dataQ'
                    // data.innerHTML = this.responseText;
                    alert(this.responseText)
                }
            };
            xhttp.open("GET", url, true);
            xhttp.send();
            reload();
        }

    }

    var removechapter =function(){
        let select = document.querySelector("#selectedRowInfo").textContent;
        // console.log(select.textContent)
        let selected = select.split('/');
        let id = selected[0];
        let name =selected[1];

        if(id.trim() == "")alert(" Vui Lòng chọn Chương")
        else
        {
            
            let url = `./ChapterController/remove/${id}`;
            // let data = document.getElementById("dataQ");
           
    
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Hiển thị kết quả trong phần tử HTML với id là 'dataQ'
                    // data.innerHTML = this.responseText;
                    alert(this.responseText)
                }
            };
            xhttp.open("GET", url, true);
            xhttp.send();
            reload();
        }
    }

    var fillChapter = function() {


        var selectElement = document.querySelector('#Mainselect');
        var selectedValue = selectElement.value.trim();
        console.log(selectedValue)
        // let link = "/web/ChapterController/fillChapter/"+selectedValue;
        if (selectedValue != 0) {

            let url = `./ChapterController/fillChapter/${selectedValue}`;
            let data = document.getElementById("data");
            console.log(data)
            while (data.firstChild) {
                data.removeChild(data.firstChild);
            }

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Hiển thị kết quả trong phần tử HTML với id là 'dataQ'
                    data.innerHTML = this.responseText;
                    addeventforrow();
                    // alert(this.responseText)
                }
            };
            xhttp.open("GET", url, true);
            xhttp.send();
        }
        else{
            reload();
        }

    }

    // var addeventforrow = function() {
    //     var selectedRowInfo = document.querySelector('#selectedRowInfo');
    //     var rows = document.querySelectorAll('.dong');

    //     // Lặp qua từng dòng và thêm sự kiện click
    //     rows.forEach(row => {
    //         row.addEventListener('click', function() {
    //             // Loại bỏ màu nền của tất cả các dòng
    //             rows.forEach(row => {
    //                 row.style.backgroundColor = '';
    //                 row.style.color = 'black';
    //             });

    //             // Đặt màu nền cho dòng được click
    //             this.style.backgroundColor = '#ff9900';
    //             this.style.color = 'white';

    //             // Lấy ID của dòng được chọn
    //             var selectedRowId = this.querySelector('#ID').textContent;
    //             // console.log("ID của dòng được chọn:", selectedRowId);

    //             // In ra thông tin của dòng được chọn
    //             selectedRowInfo.textContent = selectedRowId;

    //             // Đặt giá trị của input hidden là ID của dòng được chọn

    //         });
    //     });
    // };


    // Gọi hàm addeventforrow() để thêm sự kiện cho các dòng khi trang được tải









    var reload = function() {
        window.location.href = "http://localhost/Project_web2/web/ChapterController";
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
                selectedRowInfo.textContent = this.querySelector('#ID').textContent + '/' + this.querySelector('#name').textContent;
                let remove = document.querySelector("#idremove");

                // console.log(this.querySelector('#ID').textContent)
            });
        });
    }



    var loadchapter = function() {

    }

    var showdethi = function() {};
    var showHocvien = function() {};
</script>