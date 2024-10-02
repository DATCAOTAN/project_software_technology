<div class="container mt-5">
    <!-- Feature Container -->
    <div class="d-flex justify-content-between mb-3">
        <h1>Danh sách Đề thi</h1>
        <button id="addExamBtn" class="btn btn-primary">Thêm đề thi</button>
    </div>

    <!-- Search Container -->
    <div class="card mb-4">
        <div class="card-body" style="padding: 5px;">
            <form class="form-inline" style="justify-content: right;">
                <div class="form-group mr-3">
                    <label for="search-input" class="mr-2">Tên đề thi:</label>
                    <input type="text" id="search-input" class="form-control" placeholder="Nhập tên đề thi...">
                </div>
                <button type="button" class="btn btn-primary" onclick="loadExams(1)">Tìm kiếm</button>
            </form>
        </div>
    </div>

    <!-- Exam Table -->
    <table id="examTable" class="table table-striped table-hover">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Tên đề thi</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <!-- Nội dung đề thi sẽ được thêm vào đây bằng JavaScript hoặc phía server -->
        </tbody>
    </table>

    <!-- Pagination -->
    <nav id="pagination" aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <!-- Các trang phân trang sẽ được thêm vào đây bằng JavaScript hoặc phía server -->
        </ul>
    </nav>
</div>

<!-- Modal -->
<div id="addExamModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Thêm đề thi mới</h5>
            <button type="button" class="close" aria-label="Close" onclick="closeModal()">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="examName">Tên đề thi:</label>
                <input type="text" id="examName" class="form-control input">
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="examType">Chọn loại loại đề thi:</label>
                        <select id="examType" class="form-control">
                            <option value="simple">Đơn giản</option>
                            <option value="advanced">Nâng cao</option>
                        </select>
                    </div>
                </div>
            </div>
            <div id="simpleExamSection">
                <div class="form-group">
                    <label for="simpleSubject">Chọn môn học:</label>
                    <select id="simpleSubject" class="form-control">
                        <?php foreach ($subjects as $subject) : ?>
                            <option value="<?php echo htmlspecialchars($subject["ID"]); ?>"><?php echo htmlspecialchars($subject["Ten"]); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="simpleQuestionCount">Số lượng câu hỏi:</label>
                    <input type="number" id="simpleQuestionCount" class="form-control  input">
                </div>
            </div>
            <div id="advancedExamSection" style="display: none;">
                <div class="form-group">
                    <label for="advancedSubject">Chọn môn học:</label>
                    <select id="advancedSubject" class="form-control" onchange="loadChapters()">
                        <?php foreach ($subjects as $subject) : ?>
                            <option value="<?php echo htmlspecialchars($subject["ID"]); ?>"><?php echo htmlspecialchars($subject["Ten"]); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="advancedChapter">Chọn chương:</label>
                    <select id="advancedChapter" class="form-control">
                    </select>
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="advancedHardCount">Số câu hỏi khó:</label>
                            <input type="number" id="advancedHardCount" class="form-control input">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="advancedEasyCount">Số câu hỏi dễ:</label>
                            <input type="number" id="advancedEasyCount" class="form-control  input">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary" onclick="addSelectedChapter()">Thêm chương</button>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h5>Danh sách chương đã chọn:</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tên chương</th>
                                    <th>Số câu khó</th>
                                    <th>Số câu dễ</th>
                                </tr>
                            </thead>
                            <tbody id="selectedChaptersTableBody">
                                <!-- Danh sách các chương đã chọn sẽ được thêm bằng JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="simpleSubmit" onclick="submitSimpleExam()">Xác nhận</button>
            <button type="button" class="btn btn-primary" id="advanceSubmit" onclick="submitAdvanceExam()">Xác nhận</button>
        </div>
    </div>
</div>
<!-- Exam Detail Modal -->
<div id="examDetailModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Chi tiết đề thi</h5>
            <button type="button" class="close" aria-label="Close" onclick="closeModal()">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id = "exam-detail-modal-body">
            <div id="questionNav" class="question-nav">
                <!-- Nút sẽ được thêm động vào đây -->
            </div>
            <div id="examDetailContent">
                <!-- Nội dung chi tiết đề thi sẽ được load ở đây -->
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" onclick="closeModal()">Đóng</button>
        </div>
    </div>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script>
    $(document).ready(function() {
        loadExams(1);
    });


    // document.getElementById('search-input').addEventListener('input', function() {
    //     loadExams(1);
    // });

    function loadExams(page) {
        const search = document.getElementById('search-input').value;
        $.ajax({
            url: 'index.php?url=ExamController/fetchExams',
            type: 'GET',
            dataType: 'json',
            data: {
                page: page,
                search: search,
            },
            success: function(response) {
                const exams = response.exams;
                const totalPages = response.totalPages;
                renderExams(exams);
                renderPagination(page, totalPages);
            },
        });
    }
    $(document).on('click', '.exam-item', function() {
        var examId = $(this).data('exam-id');
        loadExamDetails(examId);
    });

    function loadExamDetails(examId) {
        document.getElementById('exam-detail-modal-body').innerHTML = "";
        // Gửi yêu cầu AJAX để lấy chi tiết đề thi
        $.ajax({
            url: 'index.php?url=ExamController/examDetail', // Thay đổi đường dẫn đến API của bạn
            method: 'GET',
            data: {
                id: examId
            },
            success: function(response) {
                // Giả sử response chứa HTML của chi tiết đề thi
                document.getElementById('exam-detail-modal-body').innerHTML = response;
                document.getElementById('examDetailModal').style.display = "block";
            },
            error: function(error) {
                console.error('Error fetching exam details:', error);
                alert('Không thể tải chi tiết đề thi.');
            }
        });
    }

    function scrollToQuestion(questionIndex) {
        const questionElement = document.getElementById('question' + questionIndex);
        if (questionElement) {
            questionElement.scrollIntoView({ behavior: 'smooth' });
        }
    }

    function renderExams(exams) {
        const tbody = document.querySelector('#examTable tbody');
        tbody.innerHTML = '';
        exams.forEach(exam => {
            var row = '<tr class="exam-item" data-exam-id="' + exam.ID + '">' +
                '<td>' + exam.ID + '</td>' +
                '<td>' + exam.Ten + '</td>' +
                '<td>' +
                '<button class="delete-button" onclick="removeExam(' + exam.ID + ')">Xoá</button>' +
                '</td>' +
                '</tr>';
            $('#examTable tbody').append(row);
        });
    }

    function renderPagination(currentPage, totalPages) {
        const pagination = document.querySelector('#pagination .pagination');
        pagination.innerHTML = '';

        for (let i = 1; i <= totalPages; i++) {
            const li = document.createElement('li');
            li.classList.add('page-item');
            if (i === currentPage) {
                li.classList.add('active');
            }
            li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            li.addEventListener('click', function(event) {
                event.preventDefault();
                loadExams(i);
            });
            pagination.appendChild(li);
        }
    }

    function searchExams() {
        loadExams(1);
    }

    function removeExam(examId) {
        $.ajax({
            url: 'index.php?url=ExamController/removeExam',
            type: 'GET',
            dataType: 'json',
            data: {
                examId: examId,
            },
            success: function(response) {
                alert(response);
                loadExams(1);
            },
        });
    }
    // Show modal
    var addExamBtn = document.getElementById('addExamBtn');
    addExamBtn.addEventListener('click', function() {
        const modal = document.getElementById("addExamModal");
        const examNameInput = document.getElementById("examName");
        const examTypeSelect = document.getElementById("examType");
        const simpleSubjectSelect = document.getElementById("simpleSubject");
        const simpleQuestionCountInput = document.getElementById("simpleQuestionCount");
        const advancedSubjectSelect = document.getElementById("advancedSubject");
        const advancedChapterSelect = document.getElementById("advancedChapter");
        const advancedHardCountInput = document.getElementById("advancedHardCount");
        const advancedEasyCountInput = document.getElementById("advancedEasyCount");
        const selectedChaptersTableBody = document.getElementById("selectedChaptersTableBody");

        examNameInput.value = '';
        examTypeSelect.value = 'simple';
        simpleSubjectSelect.value = '';
        simpleQuestionCountInput.value = '';
        advancedSubjectSelect.value = '';
        advancedChapterSelect.innerHTML = '';
        advancedHardCountInput.value = '';
        advancedEasyCountInput.value = '';
        selectedChaptersTableBody.innerHTML = '';
        document.getElementById('simpleExamSection').style.display = 'block';
        document.getElementById('advancedExamSection').style.display = 'none';
        document.getElementById('simpleSubmit').style.display = 'block';
        document.getElementById('advanceSubmit').style.display = 'none';
        document.getElementById('addExamModal').style.display = 'block';
    });
    // Close modal
    function closeModal() {
        document.getElementById('addExamModal').style.display = 'none';
        document.getElementById('examDetailModal').style.display = 'none';
    };

    // Function to search exams
    function searchExams() {
        // Placeholder for actual search logic
        console.log("Searching exams...");
    }


    // Function to load chapters based on selected subject   
    function loadChapters() {
        const tableBody = document.getElementById('selectedChaptersTableBody');
        tableBody.innerHTML = ''; // Làm rỗng danh sách các chương đã chọn
        var subjectId = document.getElementById('advancedSubject').value;
        var chapterSelect = document.getElementById('advancedChapter');
        chapterSelect.innerHTML = ''; // Clear previous options
        if (subjectId !== '') {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'index.php?url=ExamController/loadChapters/' + subjectId, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        var data = JSON.parse(xhr.responseText);
                        data.forEach(function(chapter) {
                            var option = document.createElement('option');
                            option.value = chapter.ID;
                            option.textContent = chapter.Ten;
                            chapterSelect.appendChild(option);
                        });
                    } else {
                        console.error("Error loading chapters:", xhr.statusText);
                    }
                }
            };
            xhr.send();
        }

    }

    // Function to add selected chapter to the table
    function addSelectedChapter() {
        const chapterSelect = document.getElementById('advancedChapter');
        const selectedChapterId = chapterSelect.value;

        const hardCountInput = document.getElementById('advancedHardCount');
        const easyCountInput = document.getElementById('advancedEasyCount');
        const hardCount = parseInt(hardCountInput.value);
        const easyCount = parseInt(easyCountInput.value);

        if (selectedChapterId === '') {
            alert("Vui lòng chọn môn học.");
            return;
        }
        if (isNaN(hardCount) || isNaN(easyCount)) {
            alert("Vui lòng điền số câu hỏi khó và dễ.");
            return;
        }

        const selectedChapterText = chapterSelect.options[chapterSelect.selectedIndex].text;
        const tableBody = document.getElementById('selectedChaptersTableBody');
        const rows = tableBody.getElementsByTagName('tr');
        let chapterExists = false;

        for (let row of rows) {
            const chapterCell = row.getElementsByTagName('td')[0];
            if (chapterCell.dataset.chapterId === selectedChapterId) {
                const hardCell = row.getElementsByTagName('td')[1];
                const easyCell = row.getElementsByTagName('td')[2];

                hardCell.textContent = parseInt(hardCell.textContent) + hardCount;
                easyCell.textContent = parseInt(easyCell.textContent) + easyCount;
                chapterExists = true;
                break;
            }
        }

        if (!chapterExists) {
            const row = document.createElement('tr');

            row.innerHTML = `
                <td data-chapter-id="${selectedChapterId}">${selectedChapterText}</td>
                <td>${hardCount}</td>
                <td>${easyCount}</td>
            `;

            tableBody.appendChild(row);
        }

        hardCountInput.value = '';
        easyCountInput.value = '';
    }



    // Function to submit exam
    function submitSimpleExam() {
        ten = document.getElementById("examName").value;
        subjectId = document.getElementById("simpleSubject").value;
        so_luong = document.getElementById("simpleQuestionCount").value;
        if (ten === '') {
            alert("Vui lòng nhập tên đề thi");
            document.getElementById("examName").classList.add('missing-field');
            return;
        }
        if (subjectId === '') {
            alert("Vui lòng chọn môn học.");
            return;
        }
        if (so_luong === '') {
            alert("Vui lòng nhập số lượng câu hỏi");
            document.getElementById("simpleQuestionCount").classList.add('missing-field');
            return;
        }
        $.ajax({
            url: 'index.php?url=ExamController/simpleAddExam',
            type: 'POST',
            dataType: 'json',
            data: {
                ten: ten,
                subjectId: subjectId,
                so_luong: so_luong,
            },
            success: function(response) {
                // Xử lý phản hồi từ server (nếu cần)
                console.log(response);
                console.log("Exam submitted.");

                alert("Thêm đề thi thành công");
                var addExamModal = document.getElementById('addExamModal');
                addExamModal.style.display = 'none';
                loadExams(1);
            },
            error: function(error) {
                // Xử lý lỗi (nếu có)
                console.error("Error Adding Exam:", error);
            }
        });

    }
    document.querySelectorAll('.input').forEach(input => {
        input.addEventListener('input', function() {
            if (this.value !== '') {
                this.classList.remove('missing-field');
            }
        });
    });

    function submitAdvanceExam() {
        const ten = document.getElementById("examName").value;
        const tableBody = document.getElementById('selectedChaptersTableBody');
        const rows = tableBody.getElementsByTagName('tr');
        const selectedChapters = [];

        if (ten === '') {
            alert("Vui lòng nhập tên đề thi");
            document.getElementById("examName").classList.add('missing-field');
            return;
        }

        for (let row of rows) {
            const chapterId = row.getElementsByTagName('td')[0].dataset.chapterId;
            const hardCount = parseInt(row.getElementsByTagName('td')[1].textContent);
            const easyCount = parseInt(row.getElementsByTagName('td')[2].textContent);

            selectedChapters.push({
                chapterId: chapterId,
                hardCount: hardCount,
                easyCount: easyCount
            });
        }

        $.ajax({
            url: 'index.php?url=ExamController/advanceAddExam',
            type: 'POST',
            dataType: 'json',
            data: {
                ten: ten,
                selectedChapters: selectedChapters,
            },
            success: function(response) {
                // Xử lý phản hồi từ server (nếu cần)
                console.log(response);
                console.log("Exam submitted.");

                alert("Thêm đề thi thành công");
                var addExamModal = document.getElementById('addExamModal');
                addExamModal.style.display = 'none';
                loadExams(1);
            },
            error: function(error) {
                // Xử lý lỗi (nếu có)
                console.error("Error Adding Exam:", error);
            }
        });
    }

    // When the advanced exam type is selected, load chapters
    var examTypeSelect = document.getElementById('examType');
    examTypeSelect.addEventListener('change', function() {
        var examType = this.value;
        var advancedExamSection = document.getElementById('advancedExamSection');
        var simpleExamSection = document.getElementById('simpleExamSection');
        if (examType === 'advanced') {
            loadChapters();
            advancedExamSection.style.display = 'block';
            simpleExamSection.style.display = 'none';
            document.getElementById('simpleSubmit').style.display = 'none';
            document.getElementById('advanceSubmit').style.display = 'block';
        } else {
            advancedExamSection.style.display = 'none';
            simpleExamSection.style.display = 'block';
            document.getElementById('simpleSubmit').style.display = 'block';
            document.getElementById('advanceSubmit').style.display = 'none';
        }
    });
    function replaceQuestion(questionIndex) {
        // Logic to replace the question
        alert('Thay thế câu hỏi ' + questionIndex);
    }

    function deleteQuestion(questionIndex) {
        // Logic to delete the question
        alert('Xóa câu hỏi ' + questionIndex);
    }
</script>

<style>
    * {
        box-sizing: border-box;
    }

    .container {
        background-color: #f6f6f6;
        font-size: 16px;
        padding: 15px;
    }

    .form-control,
    .btn,
    .table,
    .modal-content {
        font-size: 18px;
    }

    .modal-title {
        font-size: 24px;
    }

    .table th {
        font-size: 18px;
    }

    .table td {
        font-size: 16px;
    }

    .pagination a {
        font-size: 16px;
    }

    /* Modal */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1000;
        /* Sit on top */
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
    }

    /* Modal content */
    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        /* Could be more or less, depending on screen size */
    }

    /* Modal header */
    .modal-header {
        padding: 10px 0;
        border-bottom: 1px solid #ddd;
        text-align: center;
    }

    /* Modal body */
    .modal-body {
        padding: 20px;
    }

    /* Modal footer */
    .modal-footer {
        padding: 10px 0;
        border-top: 1px solid #ddd;
        text-align: center;
    }

    /* Close button */
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    /* Form group */
    .form-group {
        margin-bottom: 20px;
    }

    /* Form control */
    .form-control {
        width: 100%;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    /* Button */
    .btn {
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        outline: none;
        color: #fff;
        background-color: #007bff;
        border: none;
        border-radius: 4px;
        transition: background-color 0.3s;
    }

    .btn:hover {
        background-color: #0056b3;
    }

    .missing-field {
        border: 1px solid red;
        /* Đặt màu viền đỏ */
    }

    td button {
        padding: 6px 10px;
        margin: 0 1px;
        cursor: pointer;
        border: none;
        outline: none;
        background-color: #007bff;
        color: #fff;
        border-radius: 4px;
        font-size: 14px;
    }



    /* Xóa nút thứ hai (Xoá) */
    td button {
        background-color: #dc3545;
    }

    /* Hover state cho nút Xoá */
    td button:hover {
        background-color: #bd2130;
    }
/* Modal Styles for Exam Detail */
/* Modal Styles for Exam Detail */
#examDetailModal.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

#examDetailModal .modal-content {
    background-color: #fefefe;
    margin: 2% auto; /* Center the modal */
    padding: 20px;
    border: 1px solid #888;
    width: 90%; /* Increased width */
    max-width: 1200px; /* Set a max-width to prevent it from being too wide */
    display: flex;
}

#examDetailModal .modal-header,
#examDetailModal .modal-body,
#examDetailModal .modal-footer {
    padding: 10px 20px;
}

#examDetailModal .modal-header {
    border-bottom: 1px solid #e5e5e5;
}

#examDetailModal .modal-title {
    margin: 0;
    font-size: 20px;
}

#examDetailModal .modal-footer {
    border-top: 1px solid #e5e5e5;
    text-align: right;
}

/* Close button */
#examDetailModal .close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

#examDetailModal .close:hover,
#examDetailModal .close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

/* Button styles */
#examDetailModal .btn {
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    margin-right: 10px;
    border: none;
    border-radius: 4px;
}

#examDetailModal .btn-secondary {
    background-color: #5bc0de;
    color: white;
}

#examDetailModal .btn-secondary:hover {
    background-color: #31b0d5;
}

#examDetailModal .btn-danger {
    background-color: #d9534f;
    color: white;
}

#examDetailModal .btn-danger:hover {
    background-color: #c9302c;
}

/* Question styles */
#examDetailModal .question {
    margin-bottom: 20px;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #f9f9f9;
}

#examDetailModal .font-weight-bold {
    font-weight: bold;
}

#examDetailModal .list-group-item {
    list-style-type: none;
    padding: 10px;
    border: 1px solid #ddd;
    margin-bottom: 5px;
    border-radius: 4px;
}

#examDetailModal .form-check-label {
    cursor: pointer;
}

#examDetailModal .option {
    display: flex;
    align-items: center;
}

#examDetailModal .option input {
    margin-right: 10px;
}

/* Modal Layout */
#examDetailModal .modal-layout {
    display: flex;
}

#examDetailModal .question-nav {
    max-width: 200px;
    max-height: 80vh;
    overflow-y: auto;
    padding: 10px;
    border-right: 1px solid #ddd;
    margin-right: 20px;
}

#examDetailModal #exam-detail-modal-body {
    display: flex;
    justify-content: flex-start;
    max-height: 60vh;
    
}
#examDetailModal .question-container{
    max-height: 60vh;
    overflow-y: auto;
    width: 100%;
}
#examDetailModal .question-nav .btn {
    width: 100px;
    margin: 5px;
}
</style>