# ConvoManage — Encrypted Conference & Real-Time Chat Suite

[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-777bb4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Encryption](https://img.shields.io/badge/OpenSSL-AES--128--CTR-blueviolet?style=for-the-badge&logo=lock)](https://openssl.org)
[![MySQL](https://img.shields.io/badge/MySQL-8.0%2B-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](LICENSE)

An enterprise-ready conference management and encrypted real-time chat platform. Built with Core PHP 8.2+ PDO, AES-128-CTR symmetric OpenSSL encryption, 6-character randomized join code protocols, and responsive collaborative breakout rooms.

---

## ?? System Architecture & Message Encryption Pipeline

```
+--------------------------------------------------------------------------+
|                             CONFERENCE SETUP                             |
|  Admin creates meeting  -->  Unique 6-char Join Code + 128-bit ENC_KEY   |
+--------------------------------------------------------------------------+
                                     |
                               Member Joins
                                     v
+--------------------------------------------------------------------------+
|                          CLIENT ENCRYPTED CHAT                           |
|   User types message  -->  POST `chat/send.php`                          |
|                                    |                                     |
|           Message encrypted in memory via OpenSSL:                       |
|           `openssl_encrypt($msg, 'AES-128-CTR', $key, 0, $random_iv)`    |
+------------------------------------|-------------------------------------+
                                     v
+--------------------------------------------------------------------------+
|                             DATABASE TIER                                |
|   - Ciphertext stored in `chat_messages` table along with Hex IV         |
|   - Zero plain-text exposed on disk or database inspection               |
+------------------------------------|-------------------------------------+
                                     v
+--------------------------------------------------------------------------+
|                         DECRYPTION ON RETRIEVAL                          |
|   AJAX Polling `chat/fetch.php` verifies room authorization              |
|   Reads Hex IV, decrypts using session key, and streams sanitized text   |
+--------------------------------------------------------------------------+
```

---

## ? Key Highlights

- **At-Rest AES-128-CTR Cryptography**: Chat messages are encrypted using room-specific cryptographic keys and per-message randomized Initialization Vectors (IVs).
- **6-Digit Alphanumeric Join Codes**: Zero-friction conference participation with instant join link resolution.
- **Role-Based Conference Management**: Full CRUD conference administration for organizers with participant rosters and timing parameters.
- **Live Auto-Scroll Chat UI**: Smooth asynchronous message polling and smart bottom-lock scrolling.
- **SQL Injection Immune**: All queries use PDO prepared statements with native type binding.

---

## ?? Tech Stack

- **Backend**: Core PHP 8.2+ (PDO, OpenSSL Cryptographic Library)
- **Frontend**: Responsive CSS Grid / Flexbox, FontAwesome 6, jQuery AJAX
- **Database**: MySQL 8.0+ / MariaDB (Normalized Relational Tables with Composite Indexes)

---

## ?? Installation & Local Development

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/RG-Creators/convomanage-event-suite.git
   cd convomanage-event-suite
   ```

2. **Database Setup**:
   - Create MySQL database `convomanage`:
     ```sql
     CREATE DATABASE convomanage CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
     ```
   - Import `includes/databasefile/convomanage.sql`.

3. **Configure Database Connection**:
   - Update `includes/db_connect.php` with your local database credentials.

4. **Launch Application**:
   ```bash
   php -S localhost:8000
   ```
   - Access Login: `http://localhost:8000/auth/login.php`

---

## ?? License
This project is open-source under the [MIT License](LICENSE).
