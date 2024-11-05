<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'Pawsitive');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle AJAX request to get the answer
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['get_answer'])) {
    $faq_id = $conn->real_escape_string($_POST['faq_id']);
    $sql = "SELECT answer FROM faqs WHERE id = $faq_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $answer = $result->fetch_assoc()['answer'];
        echo json_encode(['answer' => $answer]);
    } else {
        echo json_encode(['answer' => 'No answer available.']);
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - PAWSITIVE</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Adjusting Layout for FAQ and Chat Box side by side */
        .faq-container {
            display: flex;
            justify-content: space-between;
            gap: 20px; /* Reduce the gap between FAQ and chat box */
        }

        /* FAQ list styling - Smaller size */
        .faq-list {
            width: 40%; /* Reduce width of FAQ list */
        }

        /* Hover underline effect for question */
        .faq-item h3.question {
            cursor: pointer;
            display: inline-block;
            border-bottom: 2px solid transparent; /* No underline by default */
            transition: border-bottom 0.3s ease; /* Smooth transition for underline */
        }

        /* Add underline on hover */
        .faq-item h3.question:hover {
            border-bottom: 2px solid #d55fde; /* Underline on hover */
        }

        /* Chat box styles - Bring closer and adjust size */
        #chat-box {
            width: 45%; /* Slightly wider chat box */
            padding: 15px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            display: none; /* Hidden initially */
        }

        #chat-box h4 {
            margin: 10px 0;
        }

        #chat-box p {
            margin: 10px 0;
        }

        #chat-box button {
            background-color: #d55fde;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            margin-top: 10px;
        }

        #chat-box button:hover {
            background-color: #c04ed9;
        }
    </style>
</head>
<body>
    <?php include('templates/header.php'); ?>
    <main>
        <h2>Frequently Asked Questions</h2>

        <div class="faq-container">
            <!-- FAQ List -->
            <div class="faq-list">
                <?php
                // Fetch FAQs from the database
                $sql = "SELECT id, question FROM faqs";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output each FAQ
                    while($row = $result->fetch_assoc()) {
                        echo "<div class='faq-item' data-id='" . $row['id'] . "'>";
                        echo "<h3 class='question'>" . $row['question'] . "</h3>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No FAQs available at the moment.</p>";
                }
                ?>
            </div>

            <!-- Chat Box (beside the FAQ list) -->
            <div id="chat-box">
                <h4>Question:</h4>
                <p id="chat-question"></p>
                <h4>Answer:</h4>
                <p id="chat-answer"></p>
                <button id="close-chat">Close</button>
            </div>
        </div>
    </main>
    <?php include('templates/footer.php'); ?>

    <script>
    $(document).ready(function() {
        // Handle FAQ click to fetch and show answer
        $('.faq-item').click(function() {
            var faqId = $(this).data('id');
            var questionText = $(this).find('.question').text();

            // Show question in chat box
            $('#chat-question').text(questionText);
            
            // Fetch the answer via AJAX
            $.ajax({
                type: 'POST',
                url: 'faq.php',
                data: { faq_id: faqId, get_answer: true },
                dataType: 'json',
                success: function(response) {
                    $('#chat-answer').text(response.answer);
                    $('#chat-box').show(); // Show chat box with the answer
                }
            });
        });

        // Handle close button for chat box
        $('#close-chat').click(function() {
            $('#chat-box').hide();
        });
    });
    </script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
