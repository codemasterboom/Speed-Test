<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body

<?php 
// File to store the text
$file = "notes.txt";

// If form is submitted, save content
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editor"]) ) {
    $content = $_POST["editor"];
    file_put_contents($file, $content);
}

// Load existing content
$text = file_exists($file) ? file_get_contents($file) : "";


function getServerUptime() {
$input = shell_exec('uptime');

// Pattern looks for "up " followed by digits:digits
$pattern = '/up\s+(.*?),\s+load/';
if (preg_match($pattern, $input, $matches)) {
    // $matches[0] is the full match "up 19:53"
    // $matches[1] is the first capture group "19:53"
    $output = $matches[1];
} else {
    $output = "Uptime not found.";
}
return $output;
}
?>

<div class="center-text">
	<h1>Under construction</h1>
	<p><img src="/assets/images/under_construction.gif" alt="Under construction image"></p>
	<p>You are connected from: <?php echo $_SERVER['REMOTE_ADDR'] ?> <a href="https://speedtest.volia.com/"> Check your internet speed</a></p>
	<form method="post">
        <textarea name="editor"><?php echo htmlspecialchars($text); ?></textarea><br>
        <input type="submit" value="Leave your message">
    </form>
</div>

<footer>
<p>Server provided by <a href="http://t.me/codemasterboom"> Vlad Glukhov</a> and uptime: <?php echo getServerUptime(); ?></p>
</footer>

</body>
</html>