# flea-market

## 概要
- Laravelを使用して開発した簡易的なフリマアプリです。
会員登録、ログイン、商品出品、商品一覧表示、商品詳細、コメント、購入機能などを実装しています。

## 使用技術

- 開発環境：PHP 7.4.9 / Laravel 8.83.29 / MySQL 15.1
- フロントエンド：HTML / CSS / JavaScript（学習中）
- 機能：認証（Fortify）、画像アップロード（Storage）
- ツール：GitHub, Composer, VS Code

## 主な機能
- ユーザー登録・ログイン（Laravel Fortify）
- 商品のCRUD（登録・一覧・詳細・編集）
- 画像アップロード（Storage）
- 商品へのコメント機能
- 商品の購入機能
- いいね機能（多対多リレーション）

### 環境構築
## インストール手順（ローカル環境）
- Mac の M1・M2 チップの PC の場合、no matching manifest for linux/arm64/v8 in the manifest list entriesのメッセージが表示されビルドができないことがあります。 エラーが発生する場合は、docker-compose.yml ファイルの「mysql」内に「platform」の項目を追加で記載してください。
各imageの下に「platform: linux/amd64」

- メール認証機能
  mailhog:
    image: mailhog/mailhog
    platform: linux/amd64
    ports:
      - "8025:8025"

- ```bash
- git clone https://github.com/matsue1157/flea-market-app.git
- cd flea-market-app
- composer install
- cp .env.example .env

## .env

APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:hLIRIF5hb/8lKQwRzRctGJVFJQJkZdrEk/P8q20stfA=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DRIVER=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_DOMAIN=localhost
SESSION_SECURE_COOKIE=false

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=host.docker.internal
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

## テーブル

- php artisan make:migration create_products_table
- php artisan make:migration create_likes_table
- php artisan make:migration create_comments_table
- php artisan make:migration create_payment_methods_table
- php artisan make:migration create_shipping_addresses_table
- php artisan make:migration create_categories_table
- php artisan make:migration create_category_product_table
- php artisan make:migration create_purchases_table

## マイグレーション
- php artisan migrate

## seed
- php artisan make:seeder AdminUserSeeder
- php artisan make:seeder CategorySeeder
- php artisan make:seeder ProductSeeder
# シーディング
- php artisan db:seed

# シンボリック
- php artisan storage:link

## 🗂 テーブル一覧（マイグレーションファイル）

- users：ユーザー情報（Fortify認証）
- password_resets：パスワードリセット用
- two_factor：2段階認証用
- failed_jobs：失敗したジョブ（キュー管理）
- personal_access_tokens：APIトークン用（Sanctum）

- products：商品情報
- likes：いいね機能（user-productの中間テーブル）
- comments：コメント機能（user-productの多対多風）
- purchases：購入履歴（product-userの購入記録）

- categories：商品カテゴリ（多対多）
- category_product：中間テーブル（product-category）

- payment_methods：支払い方法（user紐付け想定）
- shipping_addresses：配送先住所（user紐付け）# flea-market-test
