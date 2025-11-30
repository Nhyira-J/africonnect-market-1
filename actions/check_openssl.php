<?php
echo "OpenSSL Loaded: " . (extension_loaded('openssl') ? 'Yes' : 'No') . "<br>";
echo "DNS Resolve smtp.gmail.com: " . gethostbyname('smtp.gmail.com') . "<br>";
?>
