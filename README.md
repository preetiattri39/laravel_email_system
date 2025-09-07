<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

---



# Project Flow Overview

## High-Level Flow Diagram

```
Incoming Email
		 |
		 v
[IMAP Fetch] --(Laravel Job: ProcessEmailJob)--> [Keyword & Domain Analysis]
		 |
		 v
[Routing Decision]
	|        |         |
	v        v         v
Ticket   Forward   Store Only
Created  Email     (No Action)
	|        |         |
	v        v         v
[Zoho Desk API]   [Sales/IT Team]   [Database]
```

## Main Components

- **Jobs**: `ProcessEmailJob` handles the logic for processing each email, including keyword analysis, routing, ticket creation, and forwarding.
- **Models**: Represent database tables for Emails, Leads, Tickets, Timelines, and Notes. Relationships are used to link emails to leads and tickets.
- **Controllers**: Handle web requests for CRUD operations and Zoho OAuth flows.
- **Services**: `ZohoDeskService` manages all communication with the Zoho Desk API.
- **Config**: `config/email_rules.php` contains all keyword and routing rules for flexible customization.

### Step-by-Step Example: New Email Arrives

1. **Email Fetch**: The scheduler or a manual command triggers email fetching.
2. **Job Dispatch**: Each new email is dispatched to `ProcessEmailJob`.
3. **Duplicate Check**: The job checks if the email already exists in the database.
4. **Lead Association**: The sender is matched to a Lead (created if new).
5. **Keyword Analysis**: The subject/body are checked for issue/sales keywords.
6. **Routing Decision**:
		- If internal domain: ignored.
		- If issue: Ticket is created in the database and in Zoho Desk.
		- If sales: Email is forwarded to the sales team.
		- If both: Email is forwarded to IT.
		- If no match: Email is just stored.
7. **Timeline Update**: Lead timelines are updated for sales/IT forwards.
8. **All actions and data are stored for audit and reporting.**


## 1. Zoho OAuth Setup
- Visit `/zoho/oauth` to authorize the app with Zoho.
- Copy the refresh token and add it to your `.env` as `ZOHO_REFRESH_TOKEN`.
- Run `php artisan zoho:fetch-info` to fetch and set your Zoho Desk Org/Department IDs.

## 2. Email Processing & Ticket Creation
- The system fetches emails from your mailbox using IMAP.
- Each email is analyzed for keywords and sender domain.
- Based on rules in `config/email_rules.php`:
	- Emails are routed to the correct department or user.
	- Tickets are created in Zoho Desk via API for issues.
	- Sales or IT-related emails are forwarded to the right team.
	- All emails, tickets, and related data are stored in the database.


## 3. Web Dashboard (CRUD)
- Use the web dashboard to manage Leads, Tickets, Emails, Timelines, and Notes.
- All CRUD operations are available via the web UI.

### Dashboard Features
- Sidebar navigation for all resources
- View, create, edit, and delete records
- See relationships (e.g., which emails belong to which leads)


## 4. Automation & Scheduling
- Email processing can be run manually or scheduled with Laravel’s scheduler (`php artisan schedule:run`).
- New tickets are created automatically in Zoho Desk when new emails are processed.

### Scheduling Example
- The scheduler runs every minute (see `app/Console/Kernel.php`).
- You can adjust the frequency as needed.


## 5. Configuration
- All sensitive credentials are stored in `.env`.
- Email routing and keyword rules are in `config/email_rules.php`.

### Customization
- Add or change keywords and routing logic in `config/email_rules.php`.
- Update environment variables in `.env` for different mailboxes or Zoho accounts.

## 6. Code Structure & Key Files

For more details, see the code in `app/Jobs/ProcessEmailJob.php`, `app/Services/ZohoDeskService.php`, and the controllers in `app/Http/Controllers/`.
	

