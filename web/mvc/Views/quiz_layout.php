<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bài thi trắc nghiệm</title>
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
    .button-container {
        position: fixed;
        top: 50px;
        left: 170px;
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
    .top-bar {
        position: fixed;
        top: 0;
        right: 0;
        left: 0;
        height: 40px;
        background-color: #f8f9fa;
        border-bottom: 1px solid #ddd;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-right: 20px;
        padding-left: 20px;
    }
    #countdown {
        font-size: 18px;
    }
    #submit-btn-container {
        position: fixed;
        bottom: 10px;
        right: 20px;
        z-index: 999;
    }
</style>
</head>
<body>

<div class="container">
    <div class="button-container">
        <?php
        $button = 1;
        foreach ($noidungcauhoi as $questionIndex => $question) {
            echo "<button class='btn btn-primary button' onclick='scrollToQuestion({$questionIndex})'>Câu hỏi {$button}</button>";
            $button++;
        }
        ?>
    </div>

    <form action="http://localhost/Project_web2/web/ReviewQuizController/Review/<?php echo $ID_DeThi; ?>/<?php echo $ID_LopHoc; ?>" method="post" id="quiz-form">
        <div class="question-container">
            <?php
            $n = 1;
            foreach ($noidungcauhoi as $questionIndex => $question) {
                echo "<div class='question' id='question{$questionIndex}'>";
                echo "<p class='font-weight-bold'>Câu hỏi {$n}: {$question[0]['Noi_dung']}</p>";
                echo "<ul class='list-group options'>";
                foreach ($question as $optionIndex => $option) {
                    echo "<li class='list-group-item option'>";
                    echo "<label class='form-check-label'>";
                    $value=$optionIndex+1;
                    echo "<input type='radio' name='question{$questionIndex}' value='{ $value}' class='form-check-input' onchange='logAnswer({$questionIndex}, {$value})'>";
                    echo "{$value}. {$option['Noi_dung_dap_an']}";
                    echo "</label>";
                    echo "</li>";
                }
                echo "</ul>";
                echo "</div>";
                $n++;
            }
            ?>
        </div>

        <div id="submit-btn-container">
            <input id="submit-btn" type="submit" class="btn btn-primary" value="Nộp bài">
        </div>
    </form>
</div>

<div class="top-bar">
    <div id="countdown" class="text-center">
        Thời gian còn lại: <span id="timer"></span>
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

    function countdown() {
        var timeDo = "<?php echo $thoigianthi; ?>"; // Định dạng HH:MM:SS
        var parts = timeDo.split(':');
        var timeLeft = parseInt(parts[0]) * 3600 + parseInt(parts[1]) * 60 + parseInt(parts[2]); // Đổi thành giây
        var timerDisplay = document.getElementById('timer');

        var timerInterval = setInterval(function() {
            var hours = Math.floor(timeLeft / 3600);
            var minutes = Math.floor((timeLeft % 3600) / 60);
            var seconds = timeLeft % 60;

            // Định dạng hiển thị thời gian
            var formattedTime = padNumber(hours) + ":" + padNumber(minutes) + ":" + padNumber(seconds);

            // Hiển thị thời gian
            timerDisplay.textContent = formattedTime;

            // Giảm thời gian còn lại đi 1 giây
            timeLeft--;

            // Kết thúc khi hết thời gian
            if (timeLeft < 0) {
                clearInterval(timerInterval);
                timerDisplay.textContent = "Hết thời gian";
                document.getElementById("quiz-form").submit();
            }
        }, 1000);
    }

    function padNumber(number) {
        return (number < 10 ? '0' : '') + number;
    }

    function logAnswer(questionIndex, optionIndex) {
        console.log(`Question ${questionIndex}: Answer ${optionIndex}`);
    }
    document.getElementById('quiz-form').addEventListener('submit', function(event) {
    event.preventDefault();

    var unansweredQuestions = [];
    var totalQuestions = <?php echo count($noidungcauhoi); ?>;

    <?php $n = 1; ?>
    <?php foreach ($noidungcauhoi as $questionIndex => $question) { ?>
        if (!document.querySelector('input[name="question<?php echo $questionIndex; ?>"]:checked')) {
            unansweredQuestions.push(<?php echo $n; ?>);
        }
        <?php $n++; ?>
    <?php } ?>

    if (unansweredQuestions.length > 0) {
        var message = 'Bạn chưa trả lời các câu hỏi: ' + unansweredQuestions.join(', ') + '. Bạn có chắc chắn muốn nộp bài?';
        if (confirm(message)) {
            this.submit();
        }
    } else {
        if (confirm('Bạn có chắc chắn muốn nộp bài?')) {
            this.submit();
        }
    }
});


    countdown();
</script>

</body>
</html>
