FROM ubuntu:22.04

ARG WWWGROUP
ARG NODE_VERSION=20

ENV DEBIAN_FRONTEND=noninteractive

WORKDIR /var/www/html

# Install core dependencies + add PHP PPA
RUN apt-get update \
    && apt-get install -y software-properties-common curl unzip git ca-certificates gnupg2 lsb-release apt-transport-https zip \
    && add-apt-repository ppa:ondrej/php -y \
    && apt-get update

# Install PHP 8.2 and extensions
RUN apt-get install -y php8.2 php8.2-cli php8.2-pgsql php8.2-sqlite3 php8.2-gd php8.2-curl php8.2-mysql php8.2-mbstring php8.2-xml php8.2-bcmath php8.2-soap php8.2-intl php8.2-zip php8.2-readline php8.2-xdebug php8.2-imap php8.2-common php8.2-opcache php8.2-pdo supervisor nginx cron \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Create sail user
RUN groupadd --force -g ${WWWGROUP:-1000} sail \
    && useradd -ms /bin/bash --no-user-group -g sail -u 1337 sail

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_${NODE_VERSION}.x | bash - \
    && apt-get install -y nodejs

# Permissions
RUN chown -R sail:sail /var/www/html

USER sail

EXPOSE 80 5173

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
