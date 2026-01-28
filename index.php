<!DOCTYPE html>
<html>
<head>
    <title>AI Code Explainer</title>
    <style>
        textarea { width: 100%; height: 200px; }
        pre { background: #f4f4f4; padding: 10px; }
    </style>
</head>
<body>

<h1>AI - Code Explainer</h1>

<form method="POST" action="explain.php">
    <textarea name="code" placeholder="Write Python or JavaScript code here"></textarea><br><br>
    <button type="submit">Explain Code</button>
</form>

<?php
session_start();

if (!empty($_SESSION['history'])) {
    echo "<h2>All Explanations</h2>";
    foreach ($_SESSION['history'] as $data) {
        echo "<pre>{$data['code']}</pre>";
        echo "<p><strong>Explanation:</strong> {$data['explanation']}</p><hr>";
    }
}
?>

</body>
</html>
