# MySQL-Telegram-Backup 🤖💾

A smart bot for automated MySQL database backups and Telegram delivery

## ✨ Key Features

- Complete backup of all MySQL database tables
- Automatic sending of backup files to Telegram (user or channel)
- Cron job scheduling capability
- Persian (Jalali) date/time display in sent messages
- Automatic season detection (Spring, Summer, Fall, Winter)
- Error logging and operation status reporting

## 🛠️ How It Works

1. Connects to MySQL database using configured credentials
2. Extracts structure and data from all tables
3. Creates SQL backup file
4. Sends file to Telegram with formatted caption including:
   - Jalali date/time
   - Current season
   - Backup status

## 🔧 Technical Implementation

- PHP-based solution
- Uses mysqli for database operations
- Telegram Bot API for file delivery
- Jalali date conversion support
- Comprehensive error handling

The bot automatically cleans up temporary files after successful delivery and provides detailed logs of all operations. Perfect for database administrators who need regular, remote backups via Telegram!
