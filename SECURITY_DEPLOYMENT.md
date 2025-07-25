# Laravel セキュリティ強化版デプロイメントガイド

## 📋 本番環境デプロイメント前チェックリスト

### 🔒 必須セキュリティ設定

#### 1. 環境変数設定 (.env)
```bash
# アプリケーション設定
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:【強力なキーを生成】

# HTTPS設定
APP_URL=https://your-domain.com
FORCE_HTTPS=true

# セッションセキュリティ
SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=strict

# データベース
DB_PASSWORD=【強力なパスワード】

# Redis (推奨)
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
REDIS_PASSWORD=【強力なパスワード】
```

#### 2. ファイル権限設定
```bash
# Laravel ディレクトリ権限
chmod -R 755 /path/to/laravel
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data /path/to/laravel
```

#### 3. Webサーバー設定（Nginx例）
```nginx
server {
    listen 443 ssl http2;
    server_name your-domain.com;
    
    # SSL設定
    ssl_certificate /path/to/certificate.crt;
    ssl_certificate_key /path/to/private.key;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers ECDHE+AESGCM:ECDHE+AES256:ECDHE+AES128:!aNULL:!MD5:!DSS;
    
    # セキュリティヘッダー
    add_header X-Frame-Options "DENY" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains; preload" always;
    
    # Laravel設定
    root /path/to/laravel/public;
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    # 設定ファイルへのアクセス拒否
    location ~ /\. {
        deny all;
    }
    
    location ~ ^/(\.env|\.git|storage/logs) {
        deny all;
    }
}

# HTTP to HTTPS リダイレクト
server {
    listen 80;
    server_name your-domain.com;
    return 301 https://$server_name$request_uri;
}
```

### 🚀 デプロイメント手順

#### Phase 1: 事前準備
1. **依存関係の確認**
   ```bash
   composer install --optimize-autoloader --no-dev
   npm run production
   ```

2. **データベース移行**
   ```bash
   php artisan migrate --force
   php artisan db:seed --class=AdminUserSeeder
   ```

3. **キャッシュ最適化**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan optimize
   ```

#### Phase 2: セキュリティ検証
1. **権限確認**
   ```bash
   # 管理者ユーザーのis_admin設定
   php artisan tinker
   User::where('email', 'admin@your-domain.com')->first()->makeAdmin();
   ```

2. **セキュリティテスト**
   ```bash
   # ファイルアップロードテスト
   # 管理者認証テスト
   # CSRF保護テスト
   ```

### ⚠️ セキュリティチェックポイント

#### 必須確認項目
- [ ] APP_DEBUG=false
- [ ] 強力なAPP_KEY設定済み
- [ ] データベースパスワード強化
- [ ] HTTPS強制設定
- [ ] セッション暗号化有効
- [ ] セキュリティヘッダー適用
- [ ] ファイルアップロード制限
- [ ] 管理者認証システム動作確認
- [ ] CSRF保護動作確認
- [ ] レート制限動作確認

#### 推奨設定
- [ ] Redis使用（セッション・キャッシュ）
- [ ] ログ監視システム設定
- [ ] バックアップシステム設定
- [ ] SSL証明書自動更新設定
- [ ] ファイアウォール設定

### 🔧 トラブルシューティング

#### よくある問題と解決策

**1. セッションが動作しない**
```bash
# 権限確認
ls -la storage/framework/sessions
chmod 775 storage/framework/sessions
```

**2. 画像アップロードエラー**
```bash
# ストレージディレクトリ作成
mkdir -p storage/app/public/image
chmod 775 storage/app/public/image
php artisan storage:link
```

**3. 管理者ログインできない**
```bash
# 管理者権限確認
php artisan tinker
User::where('email', 'your-admin@email.com')->first()->makeAdmin();
```

### 📊 監視とメンテナンス

#### 定期的な確認事項
- セキュリティログの確認
- 異常なアクセスパターンの監視
- ファイルアップロードフォルダの容量確認
- データベースパフォーマンス監視
- SSL証明書の有効期限確認

#### 緊急時対応
- セキュリティインシデント発生時の対応手順
- バックアップからの復旧手順
- 緊急メンテナンスモードの設定方法

---

## 📞 サポート情報

このデプロイメントガイドに関する質問や問題が発生した場合は、
技術担当者にお問い合わせください。

**最終更新**: 2025年1月
**バージョン**: Laravel 8 セキュリティ強化版