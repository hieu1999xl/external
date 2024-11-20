# Sử dụng PHP 7.3 làm base image
FROM php:7.3

# Cài đặt các dependencies cần thiết
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Xóa cache apt-get để giảm kích thước image
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Cài đặt các PHP extensions cần thiết
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd

# Cài đặt Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Thiết lập thư mục làm việc
WORKDIR /app

# Copy toàn bộ code vào container
COPY . .

EXPOSE 8000

CMD ["sh", "-c", "HUMANENV=LOCAL php oil server --host=0.0.0.0 --port=8000 --docroot=docroot"]