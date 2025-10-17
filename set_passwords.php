<?php
require __DIR__ . '/conn.php';

function setPassword(mysqli $conn, string $username, string $plain) {
	$hash = password_hash($plain, PASSWORD_DEFAULT);
	$stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
	$stmt->bind_param('ss', $hash, $username);
	$stmt->execute();
	echo $username . " => " . ($stmt->affected_rows > 0 ? "OK" : "NO CHANGE") . PHP_EOL;
	$stmt->close();
}

setPassword($conn, 'admin', 'NewPass123!');
setPassword($conn, 'leroux', 'SuperPass123!');
setPassword($conn, 'les', 'UserPass123!');

echo "Done\n";