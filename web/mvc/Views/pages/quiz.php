

<title>Xem lại bài thi</title>
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
    .button-container {
        position: fixed;
        top: 50px;
        left: 300px;
        z-index: 999;
        overflow-y: auto;
        max-height: calc(100vh - 150px);
        width: 1200px;
        padding-right: 15px;
    }
    .question {
        margin-bottom: 20px;
        padding: 20px;
        border: 1px solid #ccc;
    }
    .question-container {
        overflow-y: auto;
        max-height: calc(100vh - 150px);
        margin-top: 130px;
    }
    .button {
        margin-bottom: 5px;
    }
    .correct {
        background-color: #d4edda;
    }
    .incorrect {
        background-color: #f8d7da;
    }
</style>
</head>
<body>

<div class="container">
    <div class="button-container">
        <?php
        // Thay thế bằng ID_DeThi thực tế
        $ID_DeThi = 2;
        echo "<p>Điểm của bạn: {$Score}/10</p>";
        $button = 1;
        foreach ($noidungcauhoi as $questionIndex => $question) {
            echo "<button class='btn btn-primary button' onclick='scrollToQuestion({$questionIndex})'>Câu hỏi {$button}</button>";
            $button++;
        }
        ?>
    </div>

    <div class="question-container">
        <?php
        $questionKeys = array_keys($noidungcauhoi);
        foreach ($questionKeys as $questionIndex => $key) {
            // Lấy đáp án của người dùng cho câu hỏi hiện tại
            $userAnswer = isset($dapandachon[$questionIndex]) ? $dapandachon[$questionIndex] : null;
            // Lấy đáp án đúng cho câu hỏi hiện tại
            $correctAnswer = null;
            foreach ($noidungcauhoi[$key] as $option) {
                if ($option['dung_sai'] == 1) {
                    $correctAnswer = $option['lua_chon'];
                    break;
                }
            }

            echo "<div class='question' id='question{$key}'>";
            echo "<p class='font-weight-bold'>Câu hỏi " . ($questionIndex + 1) . ": {$noidungcauhoi[$key][0]['Noi_dung']}</p>";
            echo "<ul class='list-group options'>";
            foreach ($noidungcauhoi[$key] as $option) {
                $value = $option['lua_chon'];
                $optionClass = '';
                if ($value == $userAnswer) {
                    if ($userAnswer == $correctAnswer) {
                        $optionClass = 'correct';
                    } else {
                        $optionClass = 'incorrect';
                    }
                } elseif ($value == $correctAnswer) {
                    $optionClass = 'correct';
                }
                echo "<li class='list-group-item option {$optionClass}'>";
                echo "<label class='form-check-label'>";
                echo "<input type='radio' disabled " . ($userAnswer == $value ? "checked" : "") . ">";
                echo "{$value}. {$option['Noi_dung_dap_an']}";
                echo "</label>";
                echo "</li>";
            }
            echo "</ul>";
            echo "</div>";
        }
        ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function scrollToQuestion(questionIndex) {
        var element = document.getElementById('question' + questionIndex);
        if (element) {
            element.scrollIntoView({ behavior: 'smooth' });
        }
    }
</script>



