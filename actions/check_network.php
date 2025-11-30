<?php
$host = 'smtp.gmail.com';
$ports = [587, 465, 25];

echo "<h2>Network Connectivity Test</h2>";

foreach ($ports as $port) {
    echo "Testing connection to <b>$host:$port</b>... ";
    $connection = @fsockopen($host, $port, $errno, $errstr, 10);

    if (is_resource($connection)) {
        echo "<span style='color:green'>SUCCESS</span><br>";
        fclose($connection);
    } else {
        echo "<span style='color:red'>FAILED</span> ($errno: $errstr)<br>";
    }
}

echo "<br><h3>DNS Lookup</h3>";
$ip = gethostbyname($host);
echo "Resolved IP for $host: " . ($ip == $host ? "FAILED" : $ip);
?>
