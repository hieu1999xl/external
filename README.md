# 社内管理

社内管理画面のソースリポジトリ

## ユニットテスト

```bash
docker-compose exec web php oil test
```

## ローカル開発環境の立ち上げ

### 動作確認環境

- Docker Desktop
- Docker Compose

### ミドルウェア

- PHP 7.3
- MySQL 8.0
- Redis latest
- MailHog (メール確認用)

### 構築手順

1. 本リポジトリをcloneする
```bash
git clone ${this repository}
```

2. ディレクトリ直下に移動する
```bash
cd external_api
```

3. Docker環境を立ち上げる
```bash
HUMANENV=LOCAL php oil server --docroot=docroot
```
Or
```bash
docker-compose up -d --build
```


### 有効なURL

- http://localhost:8000
  - アプリケーションのトップ画面
- http://localhost:8025
  - MailHog (メール確認用UI)
- http://localhost:3306
  - MySQL接続用
- http://localhost:6379
  - Redis接続用

### データベース接続情報

```
Host: mysql_zues
Database: human_life
Username: user29
Password: user29
Port: 3306
```

### Redis接続情報

```
Host: redis_zues
Port: 6379
Password: sample_123
```

### コンテナ操作コマンド例

```bash
# コンテナ起動
docker-compose up -d --build

# コンテナ停止
docker-compose down

# コンテナログ確認
docker-compose logs -f

# アプリケーションコンテナに入る
docker-compose exec web bash

# MySQLコンテナに入る
docker-compose exec mysql_zues bash
```