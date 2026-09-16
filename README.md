# Laravel Multi-Vendor Store

Laravel 11 marketplace application with customer storefront, multi-store vendor management, checkout, inventory protection, order management, notifications, and private store broadcasting.

## Features

- Customer registration, login, profile, order history, and guest checkout.
- Product and category management through the admin dashboard.
- Vendors are `Admin` records assigned to one `Store`.
- Store-scoped vendor product and order access.
- Super Admin global access; Admin platform operational access.
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

Vendors have `role = Vendor` and an assigned `store_id`. Multiple vendor admins may manage the same store. Authorization is enforced through policies and explicit store-scoped queries.

## Architecture

- `app/Http/Controllers/Store` contains storefront, cart, checkout, and customer order flows.
- `app/Http/Controllers/Dashboard` contains staff product, category, profile, and order management.
- `app/Policies` contains Product, Category, Store, and Order authorization.
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

The feature suite covers authentication, role authorization, product ownership, cart ownership, checkout transactions, stock protection, order isolation, status transitions, notifications, broadcasting authorization, uploads, and security hardening.

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
- The UI still contains some template navigation and placeholder content.
- The migration history should be consolidated or documented if SQLite or another database driver must be supported.
- Browser-level frontend tests and true multi-process concurrency tests are not included.
