<div class="container">
    <div class="feature-container">
        <button id="addQuestionBtn">Thêm câu hỏi</button>
    </div>
    <div class="search-container">
        <select id="subject">
            <option value="">Tất cả môn học</option>
            <?php foreach ($subjects as $subject) : ?>
                <option value="<?php echo htmlspecialchars($subject["ID"]); ?>"><?php echo htmlspecialchars($subject["Ten"]); ?></option>
            <?php endforeach; ?>
        </select>
        <select id="chapter">
            <option value="">Tất cả chương</option>
        </select>
        <select id="difficulty">
            <option value="">Tất cả độ khó</option>
            <option value="1">Dễ</option>
            <option value="2">Khó</option>
        </select>
        <input type="text" id="search-input" placeholder="Nhập nội dung câu hỏi...">
        <button onclick="searchQuestions(1)">Tìm kiếm</button>
    </div>

    <div>
        <table id="questionTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nội dung</th>
                    <th>Độ khó</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div id="pagination" class="pagination-container"></div>
</div>
<!-- Modal -->
<div id="questionModal" class="modal" style="display:none;">
    <div class="question-modal-content">
        <span class="close">&times;</span>
        <div>
            <label for="questionModalSubject" class="questionLabel">Môn học:</label>
            <select id="questionModalSubject" class="questionSelect">
                <?php foreach ($subjects as $subject) : ?>
                    <option value="<?php echo htmlspecialchars($subject["ID"]); ?>"><?php echo htmlspecialchars($subject["Ten"]); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="questionModalChapter" class="questionLabel">Chương:</label>
            <select id="questionModalChapter" class=" questionSelect">
            </select>
        </div>
        <div>
            <label for="questionModalDifficulty" class="questionLabel">Độ khó:</label>
            <select id="questionModalDifficulty" class="questionSelect">
                <option value="1">Dễ</option>
                <option value="2">Khó</option>
            </select>
        </div>
        <div>
            <label for="questionModalContent" class="questionLabel">Nội dung câu hỏi:</label>
            <textarea id="questionModalContent" class="questionTextArea" rows="5"></textarea>
        </div>
        <div>
            <label for="questionAnswer1" class="questionLabel">Đáp án 1:</label>
            <div class="answer-input">
                <input type="text" id="questionAnswer1" class="questionInput">
                <input type="radio" name="correctAnswer" value="1">
            </div>
        </div>
        <div>
            <label for="questionAnswer2" class="questionLabel">Đáp án 2:</label>
            <div class="answer-input">
                <input type="text" id="questionAnswer2" class="questionInput">
                <input type="radio" name="correctAnswer" value="2">
            </div>
        </div>
        <div>
            <label for="questionAnswer3" class="questionLabel">Đáp án 3:</label>
            <div class="answer-input">
                <input type="text" id="questionAnswer3" class="questionInput">
                <input type="radio" name="correctAnswer" value="3">
            </div>
        </div>
        <div>
            <label for="questionAnswer4" class="questionLabel">Đáp án 4:</label>
            <div class="answer-input">
                <input type="text" id="questionAnswer4" class="questionInput">
                <input type="radio" name="correctAnswer" value="4">
            </div>
        </div>

        <button id="questionSubmit" class="questionButton">Xác nhận</button>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    var subjectSelect = document.getElementById("subject");
    var chapterSelect = document.getElementById("chapter");
    subjectSelect.addEventListener('change', function() {
        var subjectId = subjectSelect.value;
        if (subjectId === '') {
            chapterSelect.innerHTML = "<option value=''>Tất cả chương</option>";
        } else {
            chapterSelect.innerHTML = "<option value=''>Tất cả chương</option>";
            loadChapter(subjectId, chapterSelect);
        }
    });

    function loadChapter(subjectId, chapterSelect) {
        return new Promise((resolve, reject) => { // trả về một Promise.  Promise này sẽ được giải quyết (resolve) khi dữ liệu được tải xong, và sẽ bị từ chối (reject) nếu có lỗi xảy ra
            $.ajax({
                url: 'index.php?url=QuestionController/loadChapter/' + subjectId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    data.forEach(function(chapter) {
                        var option = document.createElement("option");
                        option.value = chapter.ID; // Giả sử ID của chương được trả về là chapter.ID
                        option.text = chapter.Ten; // Giả sử 'Ten' là tên chương
                        chapterSelect.appendChild(option);
                    });
                    resolve(); // Resolve the promise after loading chapters
                },
                error: function(error) {
                    console.error("Error loading chapters:", error);
                    reject(error); // Reject the promise if there's an error
                }
            });
        });
    }


    // Hàm tìm kiếm câu hỏi
    function searchQuestions(currentPage) {
        var subjectId = document.getElementById('subject').value;
        var chapterId = document.getElementById('chapter').value;
        var difficulty = document.getElementById('difficulty').value;
        var searchInput = document.getElementById('search-input').value;

        // Gửi yêu cầu tìm kiếm đến máy chủ
        $.ajax({
            url: 'index.php?url=QuestionController/searchQuestions/' + currentPage,
            type: 'GET',
            dataType: 'json',
            data: {
                subjectId: subjectId,
                chapterId: chapterId,
                difficulty: difficulty,
                searchInput: searchInput
            },
            success: function(data) {
                // Cập nhật giao diện người dùng với kết quả tìm kiếm
                displayQuestions(data.questions);
                displayPagination(data.totalPages, currentPage);
            },
            error: function(error) {
                console.error("Error searching questions:", error);
            }
        });
    }

    // Hàm để hiển thị câu hỏi lên trang web
    function displayQuestions(questions) {
        // Xóa nội dung câu hỏi cũ
        $('#questionTable tbody').empty();

        // Thêm các câu hỏi mới vào bảng
        questions.forEach(function(question) {
            var row = '<tr class="question-item" data-question-id="' + question.ID + '">' +
                '<td>' + question.ID + '</td>' +
                '<td>' + question.Noi_dung + '</td>' +
                '<td>' + ((question.Do_kho === "2") ? "Khó" : "Dễ") + '</td>' +
                '<td>' +
                '<button class="delete-btn" onclick="removeQuestion(' + question.ID + ')">Xoá</button>' +
                '</td>' +
                '</tr>';
            $('#questionTable tbody').append(row);
        });
        const questionItems = document.querySelectorAll('.question-item');
        questionItems.forEach(item => {
            item.addEventListener('click', function() {
                if (!event.target.classList.contains('delete-btn')) {
                    const questionId = item.getAttribute('data-question-id');
                    detail(questionId);
                }
            });
        });
    }

    // Hàm để hiển thị liên kết phân trang
    function displayPagination(totalPages, currentPage) {
        var paginationContainer = $('#pagination');
        paginationContainer.empty();
        for (var i = 1; i <= totalPages; i++) {
            var link = '<a href="#" onclick="searchQuestions(' + i + ')"';
            if (i === currentPage) {
                link += ' class="active"';
            }
            link += '>' + i + '</a>';
            paginationContainer.append(link);
        }
    }

    // Đoạn mã để tải câu hỏi cho trang đầu tiên khi trang được tải
    $(document).ready(function() {
        searchQuestions(1);
    });
    



    function removeQuestion(questionId){
        $.ajax({
                    url: 'index.php?url=QuestionController/removeQuestion',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        questionId: questionId
                    },
                    success: function(response) {
                        // Xử lý phản hồi từ server (nếu cần)
                        console.log(response);
                        alert(response);
                        // Load lại danh sách câu hỏi hoặc thực hiện hành động khác
                        searchQuestions(1);
                    },
                    error: function(error) {
                        // Xử lý lỗi (nếu có)

                        console.error("Error removing question:", error);
                    }
                });
    }
    


    async function detail(questionId) {
        try {
            let response = await $.ajax({ //sử dụng async/await để xử lý quá trình bất đồng bộ
                url: 'index.php?url=QuestionController/detail/' + questionId,
                type: 'GET',
                dataType: 'json'
            });
            let data = response;

            // Populate modal with question details
            document.getElementById('questionModalSubject').value = data['detail-subject'];
            let id_chuong = data['detail-chapter'];

            document.getElementById('questionModalChapter').innerHTML = "";

            // Await the loading of chapters
            await loadChapter(data['detail-subject'], document.getElementById('questionModalChapter'));

            // Set the value after chapters are loaded

            document.getElementById('questionModalChapter').value = id_chuong;

            document.getElementById('questionModalDifficulty').value = data['detail-difficulty'];
            document.getElementById('questionModalContent').value = data['detail-content'];
            document.getElementById('questionAnswer1').value = data['answer-1'];
            document.getElementById('questionAnswer2').value = data['answer-2'];
            document.getElementById('questionAnswer3').value = data['answer-3'];
            document.getElementById('questionAnswer4').value = data['answer-4'];

            document.querySelectorAll('.questionInput, .questionTextArea').forEach(input => {
                input.classList.remove('missing-field');
                input.classList.remove('selected-answer');
            });

            let correctAnswer = data['correctAnswer'];
            let radioButtons = document.querySelectorAll('input[name="correctAnswer"]');
            radioButtons.forEach(function(radio) {
                if (radio.value === correctAnswer) {
                    radio.checked = true;
                    let parentDiv = radio.closest('.answer-input');
                    if (parentDiv) {
                        // Tìm input bên cạnh radio button và thêm lớp cho nó
                        let input = parentDiv.querySelector('input[type="text"]');
                        if (input) {
                            input.classList.add('selected-answer');
                        }
                    }
                }
            });

            let creatorId = data['detail-creator'];
            document.getElementById('questionSubmit').id = 'editQuestionSubmit';

            // Display the modal
            document.getElementById('questionModal').style.display = 'block';

            // Lắng nghe sự kiện click trên nút "Xác nhận" để sửa câu hỏi
            document.getElementById('editQuestionSubmit').addEventListener('click', function() {
                // Lấy giá trị từ các trường input
                var subjectId = document.getElementById('questionModalSubject').value;
                var chapterId = document.getElementById('questionModalChapter').value;
                var difficulty = document.getElementById('questionModalDifficulty').value;
                var content = document.getElementById('questionModalContent').value;
                var answer1 = document.getElementById('questionAnswer1').value;
                var answer2 = document.getElementById('questionAnswer2').value;
                var answer3 = document.getElementById('questionAnswer3').value;
                var answer4 = document.getElementById('questionAnswer4').value;
                var correctAnswer = document.querySelector('input[name="correctAnswer"]:checked');


                // Kiểm tra xem có trường nào trống không
                // Kiểm tra từng trường một
                if (content === '') {
                    alert("Vui lòng nhập nội dung câu hỏi.");
                    document.getElementById('questionModalContent').classList.add('missing-field');
                    return;
                }
                if (answer1 === '') {
                    alert("Vui lòng nhập đáp án 1.");
                    document.getElementById('questionAnswer1').classList.add('missing-field');
                    return;
                }
                if (answer2 === '') {
                    alert("Vui lòng nhập đáp án 2.");
                    document.getElementById('questionAnswer2').classList.add('missing-field');
                    return;
                }
                if (answer3 === '') {
                    alert("Vui lòng nhập đáp án 3.");
                    document.getElementById('questionAnswer3').classList.add('missing-field');
                    return;
                }
                if (answer4 === '') {
                    alert("Vui lòng nhập đáp án 4.");
                    document.getElementById('questionAnswer4').classList.add('missing-field');
                    return;
                }
                if (!correctAnswer) {
                    alert("Vui lòng chọn đáp án đúng.");
                    return;
                }

                // Gửi dữ liệu thông qua AJAX
                $.ajax({
                    url: 'index.php?url=QuestionController/editQuestion',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        questionId: questionId,
                        subjectId: subjectId,
                        chapterId: chapterId,
                        difficulty: difficulty,
                        content: content,
                        answer1: answer1,
                        answer2: answer2,
                        answer3: answer3,
                        answer4: answer4,
                        correctAnswer: parseInt(correctAnswer.value)
                    },
                    success: function(response) {
                        // Xử lý phản hồi từ server (nếu cần)
                        console.log(response);

                        // Đóng modal sau khi sửa câu hỏi thành công
                        document.getElementById('editQuestionSubmit').id = 'questionSubmit';
                        document.getElementById('questionModal').style.display = 'none';
                        alert("Đã sửa câu hỏi mới");
                        // Load lại danh sách câu hỏi hoặc thực hiện hành động khác
                        searchQuestions(1);
                    },
                    error: function(error) {
                        // Xử lý lỗi (nếu có)
                        console.error("Error editing question:", error);
                    }
                });
            });
        } catch (error) {
            console.error("Error fetching question details:", error);
        }
    }

    // Lắng nghe sự kiện click trên nút "Thêm câu hỏi"
    document.getElementById('addQuestionBtn').addEventListener('click', function() {
        // Đặt giá trị của các trường nhập liệu thành rỗng
        document.getElementById('questionModalSubject').value = '<?php echo htmlspecialchars($subjects[0]["ID"]); ?>';
        document.getElementById('questionModalChapter').innerHTML = "";
        loadChapter(<?php echo htmlspecialchars($subjects[0]["ID"]); ?>, document.getElementById('questionModalChapter'));
        document.getElementById('questionModalDifficulty').value = '1';
        document.getElementById('questionModalContent').value = '';
        document.getElementById('questionAnswer1').value = '';
        document.getElementById('questionAnswer2').value = '';
        document.getElementById('questionAnswer3').value = '';
        document.getElementById('questionAnswer4').value = '';
        document.querySelectorAll('.questionInput, .questionTextArea').forEach(input => {
            input.classList.remove('missing-field');
            input.classList.remove('selected-answer');
        });
        var radioButtons = document.querySelectorAll('input[name="correctAnswer"]');
        radioButtons.forEach(function(radio) {
            radio.checked = false;
        });
        document.getElementById('questionSubmit').id = 'addQuestionSubmit';

        // Hiển thị modal
        document.getElementById('questionModal').style.display = 'block';

        // Lắng nghe sự kiện click trên nút "Xác nhận" để thêm câu hỏi
        document.getElementById('addQuestionSubmit').addEventListener('click', function() {
            // Lấy giá trị từ các trường input
            var subjectId = document.getElementById('questionModalSubject').value;
            var chapterId = document.getElementById('questionModalChapter').value;
            var difficulty = document.getElementById('questionModalDifficulty').value;
            var content = document.getElementById('questionModalContent').value;
            var answer1 = document.getElementById('questionAnswer1').value;
            var answer2 = document.getElementById('questionAnswer2').value;
            var answer3 = document.getElementById('questionAnswer3').value;
            var answer4 = document.getElementById('questionAnswer4').value;
            var correctAnswer = document.querySelector('input[name="correctAnswer"]:checked');


            // Kiểm tra xem có trường nào trống không
            // Kiểm tra từng trường một
            if (content === '') {
                alert("Vui lòng nhập nội dung câu hỏi.");
                document.getElementById('questionModalContent').classList.add('missing-field');
                return;
            }
            if (answer1 === '') {
                alert("Vui lòng nhập đáp án 1.");
                document.getElementById('questionAnswer1').classList.add('missing-field');
                return;
            }
            if (answer2 === '') {
                alert("Vui lòng nhập đáp án 2.");
                document.getElementById('questionAnswer2').classList.add('missing-field');
                return;
            }
            if (answer3 === '') {
                alert("Vui lòng nhập đáp án 3.");
                document.getElementById('questionAnswer3').classList.add('missing-field');
                return;
            }
            if (answer4 === '') {
                alert("Vui lòng nhập đáp án 4.");
                document.getElementById('questionAnswer4').classList.add('missing-field');
                return;
            }
            if (!correctAnswer) {
                alert("Vui lòng chọn đáp án đúng.");
                return;
            }

            // Gửi dữ liệu thông qua AJAX
            $.ajax({
                url: 'index.php?url=QuestionController/addQuestion',
                type: 'POST',
                dataType: 'json',
                data: {
                    subjectId: subjectId,
                    chapterId: chapterId,
                    difficulty: difficulty,
                    content: content,
                    answer1: answer1,
                    answer2: answer2,
                    answer3: answer3,
                    answer4: answer4,
                    correctAnswer: parseInt(correctAnswer.value)
                },
                success: function(response) {
                    // Xử lý phản hồi từ server (nếu cần)
                    console.log(response);

                    // Đóng modal sau khi thêm câu hỏi thành công
                    document.getElementById('addQuestionSubmit').id = 'questionSubmit';
                    document.getElementById('questionModal').style.display = 'none';
                    alert("Đã thêm câu hỏi mới");
                    // Load lại danh sách câu hỏi hoặc thực hiện hành động khác
                    searchQuestions(1);
                },
                error: function(error) {
                    // Xử lý lỗi (nếu có)
                    console.error("Error adding question:", error);
                }
            });
        });
    });
    // Đóng modal
    document.querySelector('.close').addEventListener('click', function() {
        if (document.getElementById('addQuestionSubmit')) {
            document.getElementById('addQuestionSubmit').id = 'questionSubmit';
        }
        if (document.getElementById('editQuestionSubmit')) {
            document.getElementById('editQuestionSubmit').id = 'questionSubmit';
        }
        document.getElementById('questionModal').style.display = 'none';
    });

    var addModalSubjectSelect = document.getElementById('questionModalSubject');
    var addModalChapterSelect = document.getElementById('questionModalChapter');
    var subjectId = addModalSubjectSelect.value;
    loadChapter(subjectId, addModalChapterSelect);
    addModalSubjectSelect.addEventListener("change", function() {
        var subjectId = addModalSubjectSelect.value;
        addModalChapterSelect.innerHTML = "";
        loadChapter(subjectId, addModalChapterSelect);
    });

    // Xóa lớp 'missing-field' khi người dùng nhập vào trường bị thiếu
    document.querySelectorAll('.questionInput, .questionTextArea').forEach(input => {
        input.addEventListener('input', function() {
            if (this.value !== '') {
                this.classList.remove('missing-field');
            }
        });
    });
    $('input[type="radio"][name="correctAnswer"]').change(function() {
        // Xóa lớp .selected-answer khỏi tất cả các ô nhập
        $('.questionInput').removeClass('selected-answer');

        // Thêm lớp .selected-answer cho ô nhập đáp án tương ứng
        $(this).siblings('.questionInput').addClass('selected-answer');
    });

</script>

<style>
    * {
        box-sizing: border-box;
    }

    .container {
        background-color: #f6f6f6;
        padding: 15px;
    }

    /* Định dạng cho các phần tử select */
    .search-container select {
        padding: 8px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-right: 10px;
    }

    /* Định dạng cho ô nhập liệu input */
    .search-container input[type="text"] {
        padding: 8px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-right: 10px;
        flex: 1;
        /* Cho phép ô nhập liệu mở rộng để điền đầy không gian còn lại */
    }

    /* Định dạng cho nút button */
    .search-container button,
    .feature-container button {
        padding: 8px 16px;
        margin-bottom: 5px;
        font-size: 14px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    /* Định dạng cho phần tử button khi rê chuột vào */
    .search-container button:hover,
    .feature-container button:hover {
        background-color: #0056b3;
    }

    /* Định dạng cho container chứa các phần tử tìm kiếm */
    .search-container {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    /* Phần chính bảng */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-size: 16px;
    }

    /* Tiêu đề cột */
    th {
        background-color: #d2d2d2;
        padding: 12px;
        text-align: left;
        font-weight: bold;
        font-size: 18px;
    }

    /* Ô dữ liệu */
    td {
        padding: 8px;
        font-size: 16px;
    }

    /* Nút hành động */
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

    .question-item:hover {
        background-color: #eeeeee;
        border: 1px solid;
    }

    .question-item .question-id {
        font-weight: bold;
    }

    .question-item .question-content,
    .question-item .question-difficulty {
        margin-top: 5px;
    }

    /* Phân trang */
    .pagination-container {
        margin-top: 20px;
        text-align: center;
    }

    .pagination-container a {
        display: inline-block;
        padding: 5px 10px;
        margin-right: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
        text-decoration: none;
        color: #333;
    }

    .pagination-container a.active,
    .pagination-container a:hover,
    .pagination-container a.active:hover {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        padding-top: auto;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 600px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        animation-name: animatetop;
        animation-duration: 0.4s;
    }

    @keyframes animatetop {
        from {
            top: -300px;
            opacity: 0
        }

        to {
            top: 0;
            opacity: 1
        }
    }

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


    #questionModal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    /* Định dạng cho nội dung của modal */
    .question-modal-content {
        background-color: #fefefe;
        margin: 2.5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 600px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    }


    /* Định dạng cho các label */
    .questionLabel {
        display: block;
        margin-bottom: 5px;
    }

    /* Định dạng cho các combobox và input */
    .questionSelect,
    .questionTextArea,
    .questionInput {
        padding: 8px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 10px;
        width: 100%;
        box-sizing: border-box;
    }

    /* Định dạng cho nút xác nhận */
    .questionButton {
        padding: 8px 16px;
        font-size: 14px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 20%;
        margin: 0 40%;
    }

    .questionButton:hover {
        background-color: #0056b3;
    }

    .missing-field {
        border: 1px solid red;
        /* Đặt màu viền đỏ */
    }

    .answer-input {
        display: flex;
    }

    .answer-input input[type="radio"] {
        margin: 0px 10px 10px 10px;
        /* Khoảng cách giữa ô nhập và radiobutton */
        vertical-align: middle;
        /* Đảm bảo radiobutton được căn giữa theo chiều dọc */
    }

    .selected-answer {
        border: 2px solid #65B741;
    }
</style>