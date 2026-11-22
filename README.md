# ConvoManage — Encrypted Conference & Real-Time Chat Suite

[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-777bb4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)

> [!IMPORTANT]
> **Commercial Intellectual Property Notice & Source Code Sale:**
> This repository contains a production-ready, proprietary software solution engineered by **Ronit Goswami (RG Creators)**. It is available for commercial acquisition, full IP buyout, or custom enterprise licensing.
> 
> - **Asset Classification:** Event Tech & Secure Collaboration
> - **Commercial Valuation / Fair Market Estimate:** **₹35,000 – ₹55,000 INR** *(Full Source Code & Commercial Rights)*
> - **Full IP Buyout & Exclusive Ownership:** **₹75,000 INR**
> - **Target Industry:** Event Management, Corporate Summits, Tech Conferences & Secure Networking
> - **Handover Deliverables:**
>   - Complete ConvoManage platform source code featuring AES-128 end-to-end encrypted chat
>   - Dynamic event join codes, multi-role attendee badges, and session schedules
>   - Interactive conference dashboard with real-time attendee roster
>   - Database schemas, seeders, API endpoints, and production runbook
>   - 30 days of dedicated technical handover support
> - **Official Portfolio:** [https://rgcreators.netlify.app](https://rgcreators.netlify.app)
> - **Acquisition & Licensing Inquiries:** [rgcreatorsofficial@gmail.com](mailto:rgcreatorsofficial@gmail.com)

---

[![Encryption](https://img.shields.io/badge/OpenSSL-AES--128--CTR-blueviolet?style=for-the-badge&logo=lock)](https://openssl.org)
[![MySQL](https://img.shields.io/badge/MySQL-8.0%2B-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](LICENSE)

An enterprise-ready conference management and encrypted real-time chat platform. Built with Core PHP 8.2+ PDO, AES-128-CTR symmetric OpenSSL encryption, 6-character randomized join code protocols, and responsive collaborative breakout rooms.

---

## 🏗️ System Architecture & Message Encryption Pipeline

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

## ⚡ Key Highlights

- **At-Rest AES-128-CTR Cryptography**: Chat messages are encrypted using room-specific cryptographic keys and per-message randomized Initialization Vectors (IVs).
- **6-Digit Alphanumeric Join Codes**: Zero-friction conference participation with instant join link resolution.
- **Role-Based Conference Management**: Full CRUD conference administration for organizers with participant rosters and timing parameters.
- **Live Auto-Scroll Chat UI**: Smooth asynchronous message polling and smart bottom-lock scrolling.
- **SQL Injection Immune**: All queries use PDO prepared statements with native type binding.

---

## 🛠️ Tech Stack

- **Backend**: Core PHP 8.2+ (PDO, OpenSSL Cryptographic Library)
- **Frontend**: Responsive CSS Grid / Flexbox, FontAwesome 6, jQuery AJAX
- **Database**: MySQL 8.0+ / MariaDB (Normalized Relational Tables with Composite Indexes)

---

## 🚀 Installation & Local Development

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

## 📄 License
This project is open-source under the [MIT License](LICENSE).


---

## 🚀 Future Roadmap & Next-Gen Implementation Ideas (Ready for Expansion)

The following extensive architectural and feature expansions have been designed and architected for rapid implementation, transforming this solution into a high-capacity, enterprise-grade platform:

1. **WebRTC Multi-Party Video & Breakout Sessions:** Zero-knowledge encrypted peer-to-peer video rooms and breakout discussion pods.
2. **Dynamic QR Attendee Badges & NFC Gate Check-in:** Rapid tap-and-go venue check-in with instant badge printing integration.
3. **Live Interactive Stage Q&A & Audience Polls:** Real-time upvoting of audience questions and animated presentation polls.
4. **AI-Powered Attendee Matchmaking:** Algorithmic peer recommendations based on attendee industry, objectives, and tech stack.
5. **Virtual Sponsor Booths & Lead Scanner:** Exhibitors scan attendee QR codes to capture contact info and exchange digital brochures.
6. **Multi-Track Agenda Planner with 1-Click Calendar Sync:** Google Calendar, Apple Calendar, and Outlook direct export for all keynotes.
7. **Simultaneous Multi-Language Live AI Captions:** Real-time speech-to-text transcription displayed during stage presentations.
8. **Zero-Knowledge Encrypted Presentation Vault:** Speakers securely upload slide decks with end-to-end encryption access controls.
9. **Automated WhatsApp Event Concierge:** WhatsApp chatbot answering attendee questions on venue directions, timings, and speaker bios.
10. **Post-Event Video Archive & Verifiable Attendance Certificates:** Automated issuance of verified certificates of conference participation.

---

## 💼 Commercial Acquisition & Licensing Agreement

For source code inspection, live technical walkthrough, pricing negotiations, or exclusive enterprise buyout:
- **Lead Architect & Developer:** Ronit Goswami (RG Creators)
- **Primary Contact Email:** [rgcreatorsofficial@gmail.com](mailto:rgcreatorsofficial@gmail.com)
- **Official Portfolio:** [https://rgcreators.netlify.app](https://rgcreators.netlify.app)
- **Location:** Kolkata, West Bengal, India
