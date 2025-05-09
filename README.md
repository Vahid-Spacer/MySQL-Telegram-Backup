# MySQL-Telegram-Backup 🤖💾

Automated MySQL database backup solution with Telegram delivery

## 🔧 Features

- Complete MySQL database backup (structure + data)
- Direct delivery to Telegram (user/channel)
- Clean file management (auto-delete after sending)
- Detailed error logging
- Supports both Gregorian and Jalali dates (commented)
- Secure connection with cURL

## ⚙️ Technical Details

- PHP 7.0+ compatible
- Uses MySQLi for database operations
- Telegram Bot API integration
- cURL for secure file transfer
- HTML-formatted captions with GitHub link

## 📦 File Structure

- `jdf.php` - Jalali date functions (included)
- Configurable database credentials
- Customizable backup filename format
- Optional logging system

## 🔄 Workflow

1. Connects to MySQL server
2. Backs up all tables with structure and data
3. Sends SQL file via Telegram bot
4. Cleans up temporary files
5. Provides detailed operation logs

```
📅 → 2025/05/09 ⏰ → 18:00
⚙️ GitHub
```

[View on GitHub](https://github.com/Vahid-Spacer/MySQL-Telegram-Backup) | [Telegram Channel](https://t.me/Dev_SpaceX) | [Donate❤️](https://www.coffeebede.com/spacex)
