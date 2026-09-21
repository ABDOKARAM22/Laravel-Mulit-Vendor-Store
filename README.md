# Laravel Multi-Vendor Store

Laravel 11 marketplace application with a customer storefront, multi-store vendor management, vendor onboarding and approval, checkout, inventory protection, order management, notifications, and private store broadcasting.

## Features

- Customer registration, login, profile, order history, and guest checkout.
- Product and category management through the admin dashboard.
- Store management through the dashboard, including store search, status filtering, details, editing, and status updates.
- Public vendor registration with vendor and store creation held in a pending state until administrator review.
- Vendor approval and rejection workflow that updates the vendor and its store together.
- Vendors are `Admin` records with `role = Vendor`, linked to their assigned `Store` through `admins.store_id`.
- Store-scoped vendor product and order access.
- Super Admin global access; Admin platform operational access and vendor management; Vendor assigned-store operations; Customer storefront and order access.
- Pending, rejected, and suspended admin accounts cannot authenticate; only active admin accounts can access the dashboard.
- Server-side prices, totals, stock checks, and one order per store.
- Transactional checkout with row locking and order-number sequences.
- Immutable order and order-item checkout snapshots.
- COD checkout only.
- Private store order channels and database/mail notifications.
- Validated JPEG, PNG, and GIF uploads stored on the uploads disk.

## Roles and guards

| Guard | Model | Purpose |
| --- | --- | --- |
| `web` | `App\Models\User` | Customers |
| `admin` | `App\Models\Admin` | Super Admin, Admin, and Vendor staff |

The application uses four operational roles:

- **Super Admin**: global dashboard access, including vendor and store management.
- **Admin**: platform operational access, including vendor review, approval, rejection, and editing.
- **Vendor**: an `Admin` record with `role = Vendor`, one assigned store, and store-scoped product and order access.
- **Customer**: a `web`-guard `User` who uses the storefront, cart, checkout, profile, and customer order history.

Vendor and store records are connected through `admins.store_id`. Authorization is enforced through policies, dashboard role middleware, protected request validation, and explicit store-scoped queries. Vendors cannot access vendor-management routes, change their role or store assignment, or change their own authorization status.

## Store and vendor lifecycle

Vendors can apply through the public `/vendor/register` workflow with their name, email, password, store name, and store description. The application generates the store slug server-side and creates the vendor and store in one database transaction:

- Vendor status: `Pending`
- Store status: `Pending`

Administrators review vendor applications from the dashboard. Approval changes both records to `Active`; rejection changes both records to `Rejected`. Store management also supports `Pending`, `Active`, `Inactive`, and `Rejected` store statuses. Admin status values include `Pending`, `Active`, `Rejected`, and `Suspended`.

Pending, rejected, and suspended admin accounts are rejected by the admin login flow. A vendor cannot approve, reject, activate, suspend, or otherwise change their own status or another vendor's status.

## Architecture

- `app/Http/Controllers/Store` contains storefront, cart, checkout, and customer order flows.
- `app/Http/Controllers/Dashboard` contains dashboard product, category, store, vendor, profile, and order management.
- `app/Http/Controllers/VendorRegistrationController.php` handles public vendor applications.
- `app/Policies` contains Admin, Product, Category, Store, and Order authorization.
- `app/Http/Requests` contains request validation and status-transition authorization.
- `app/Repositories/Cart` provides cookie-scoped cart access.
- `app/Services/MediaUploader.php` centralizes upload and deletion behavior.
- `app/Events`, `app/Listeners`, and `app/Notifications` implement order-created notifications and broadcasting.

## Cart and checkout

Guest carts are identified by the `cart_id` cookie. After customer authentication, cart rows require both the cookie and the authenticated customer ID. A guest cart using the current cookie is claimed on login and released back to guest ownership on logout without deleting its contents.

Checkout accepts COD. Product prices, store ownership, totals, and stock are always loaded from the database. Product and cart rows are locked inside a transaction. A multi-store cart creates one Order per actual product store. Failed checkout rolls back stock, orders, addresses, and cart clearing.

## Orders

Orders store product name, price, quantity, item subtotal, subtotal, shipping, tax, discount, and total snapshots. Customer history is restricted to the authenticated customer. Vendors see orders for their assigned store. Super Admins have global order visibility.

Application status transitions are:

- `pending` -> `processing` or `cancelled`
- `processing` -> `delivering` or `cancelled`
- `delivering` -> `completed`

Completed and cancelled orders are terminal in the current application.

## Notifications and broadcasting

Each store order dispatches `OrderCreated`. Vendor recipients are resolved from Admin records assigned to the order's store. Broadcasts use private channels named `private-stores.{store_id}.orders`; channel authorization is handled in `routes/channels.php`. Payloads contain only order ID, number, store ID, and status.

The current listener and broadcast path is synchronous. A production deployment that requires failure isolation should configure and monitor a queue before changing listener delivery behavior.

## Installation

Requirements:

- PHP 8.2+
- Composer
- MySQL (the migration history currently uses MySQL-specific operations)
- A web server configured for Laravel's `public` directory

```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
php artisan serve
```

Set database, mail, queue, cache, filesystem, and broadcasting values in `.env`. Never commit `.env` or real credentials. Production must use `APP_ENV=production` and `APP_DEBUG=false`.

Uploaded product, category, and profile media use the `uploads` disk rooted at `public/uploads`. Ensure the web process can write to that directory and that its executable-file protections remain deployed.

## Database and seeding

Run migrations with:

```bash
php artisan migrate
```

The seeders are development/demo helpers and must not be treated as production account provisioning. Review generated credentials and data before running them outside local development.

## Testing and quality checks

```bash
php artisan test
php artisan route:list
composer audit --no-interaction
php artisan config:clear
php artisan config:cache
```

The feature suite covers authentication, role authorization, vendor registration and approval/rejection, vendor and store ownership protection, product ownership, cart ownership, checkout transactions, stock protection, order isolation, status transitions, notifications, broadcasting authorization, uploads, and security hardening. The dedicated vendor-management feature tests cover pending creation, duplicate validation, protected fields, direct route authorization, status synchronization, and blocked inactive-account login.

## Production notes

Configure:

- MySQL database and migration permissions.
- Database sessions, cache, and queue tables.
- SMTP mail delivery.
- Pusher credentials if real-time broadcasting is enabled.
- Writable `storage` and `public/uploads` paths.
- A process to run `php artisan queue:work` if queued work is introduced.
- Log rotation, monitoring, backups, HTTPS, and secret rotation.

Do not expose debug pages, use development credentials, or deploy the repository's local `.env`.

## Known limitations and future improvements

- COD is the only implemented payment method.
- Shipping, tax, discounts, refunds, and coupons are currently zero/unimplemented business rules.
- Storefront filtering and search controls are limited.
- Vendor registration and approval are administrative workflows; no automatic vendor activation or login is performed after registration.
- The migration history should be consolidated or documented if SQLite or another database driver must be supported.
- Browser-level frontend tests and true multi-process concurrency tests are not included.
