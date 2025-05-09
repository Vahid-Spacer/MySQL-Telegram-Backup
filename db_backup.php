<?php

# ===================================================================== #
# Date and Time Library :
include_once 'jdf.php';
date_default_timezone_set('Asia/Tehran');

# database information :
$servername = 'localhost';
$database_username = 'Username-db'; # Username db
$database_name = 'Name-db'; # Name db
$database_password = 'Password-db'; # Password db

# Telegram section :
$telegram_user_id = 1234567890; # Person or Channel ID (number ID expamle: 1234567890)
$telegram_bot_token = ''; # Bot Token

# Backup File Name :
$backupFile = 'MySQL-Telegram-Backup_' . time() . '.sql';
# ===================================================================== #

# Function to save log :
function log_message($message) {
    //file_put_contents('backup_log.txt', date('Y-m-d H:i:s').' - ' . $message.PHP_EOL, FILE_APPEND);
    echo $message.PHP_EOL;
}

# Create a backup of the database :
try {
    $connect = new mysqli($servername, $database_username, $database_password, $database_name);
    if ($connect->connect_error) {
        throw new Exception('Connection to database failed : ' . $connect->connect_error);
    }

    $tables = array();
    $result = $connect->query("SHOW TABLES");
    while($row = $result->fetch_array()) {
        $tables[] = $row[0];
    }

    $handle = fopen($backupFile, 'w+');
    if (!$handle) {
        throw new Exception("Unable to create backup file!");
    }

    foreach($tables as $table) {
        $create_table = $connect->query("SHOW CREATE TABLE $table");
        $row2 = $create_table->fetch_row();
        fwrite($handle, $row2[1].";\n\n");
        $result = $connect->query("SELECT * FROM $table");
        $num_fields = $result->field_count;
        while($row = $result->fetch_row()) {
            $values = array();
            for($j=0; $j<$num_fields; $j++) {
                if (is_null($row[$j])) {
                    $values[] = 'NULL';
                } else {
                    $values[] = '"'.addslashes(str_replace("\n","\\n",$row[$j])).'"';
                }
            }
            fwrite($handle, "INSERT INTO $table VALUES(".implode(',', $values).");\n");
        }
        fwrite($handle, "\n\n");
    }
    fclose($handle);
    log_message("Database backup created successfully : " . $backupFile . "<br/>");

    if (sendToTelegram($backupFile, $telegram_bot_token, $telegram_user_id)) {
        unlink($backupFile);
    }

} catch (Exception $e) {
    log_message("Error creating database backup : ".$e->getMessage());
}

function sendToTelegram($filePath, $botToken, $chatId) {
    if (!file_exists($filePath)) {
        log_message("There is no file to send : ".$filePath);
        return false;
    }
    $url = "https://api.telegram.org/bot{$botToken}/sendDocument";

    # Jalali
        //$time = jdate('H:i:s');
        //$date = jdate('Y/m/d');
    
    # Gregorian
        $time = date('H:i:s');
        $date = date('Y/m/d');

    $postFields = [
        'chat_id' => $chatId,
        'document' => new CURLFile(realpath($filePath)),
        'caption' => "📅 → " . $date . " ⏰ → " . $time . "\n" . "⚙️ <a href='https://github.com/Vahid-Spacer/MySQL-Telegram-Backup'>GitHub</a>",
        'parse_mode' => 'HTML'
    ];
    $ch = curl_init();
    curl_setopt_array(
        $ch, [
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postFields,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 30
        ]
    );
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        log_message("cURL error : " . curl_error($ch));
        curl_close($ch);
        return false;
    }
    curl_close($ch);
    $response = json_decode($result, true);
    if ($response && $response['ok']) {
        log_message("The file was successfully sent to Telegram : ". $filePath . "<br/>");
        return true;
    } else {
        $error = $response['description'] ?? 'Unknown error';
        log_message("Error sending file to Telegram : ".$error);
        return false;
    }
}
?>
<!--
GitHub Project:
https://github.com/Vahid-Spacer/MySQL-Telegram-Backup
TG:
t.me/Dev_SpaceX
-->
