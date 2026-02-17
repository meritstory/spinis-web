FROM php:8.5-fpm

RUN apt-get update && \
    apt-get install -y --no-install-recommends libssl-dev zlib1g-dev curl gnupg unzip git \
          libfreetype6-dev \
          libjpeg62-turbo-dev \
          libxml2-dev \
          libpng-dev \
          libicu-dev \
          netcat-traditional libxml2-dev libpq-dev libzip-dev wget \
          nginx \
          openssh-server \
          supervisor

RUN pecl install apcu

RUN docker-php-ext-configure gd \
          --with-freetype \
          --with-jpeg && \
    docker-php-ext-configure pcntl --enable-pcntl && \
    docker-php-ext-configure pgsql && \
    docker-php-ext-configure intl && \
    docker-php-ext-install -j$(nproc) zip intl pdo_pgsql pgsql soap pcntl gd && \
    docker-php-ext-enable apcu pdo_pgsql sodium gd pcntl

# Install yarn, Node.js
RUN curl -fsSL https://dl.yarnpkg.com/debian/pubkey.gpg | gpg --dearmor -o /usr/share/keyrings/yarn-archive-keyring.gpg
RUN echo "deb [signed-by=/usr/share/keyrings/yarn-archive-keyring.gpg] https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
RUN apt-get update && apt-get install -y --no-install-recommends \
    yarn \
    nodejs

# Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Set workdir
WORKDIR /var/www/symfony

# Set timezone
ARG TIMEZONE="Europe/Vilnius"
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
    && printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
    && "date"

# Copy configuration files
COPY docker/app/custom.ini /usr/local/etc/php/conf.d/custom.ini
COPY docker/app/php-fpm.conf /usr/local/etc/php-fpm.d/www.custom.conf
COPY docker/app/nginx.conf /etc/nginx/nginx.conf
COPY docker/app/site.conf /etc/nginx/conf.d/site.conf
COPY docker/app/supervisord.conf /etc/supervisor/conf.d/app.conf

# Setup SSH
COPY docker/app/sshd_config /etc/ssh/sshd_config
RUN mkdir -p /root/.ssh/
COPY docker/app/authorized_keys /root/.ssh/authorized_keys
RUN chown -R root:root /root/.ssh && chmod -R 600 /root/.ssh
RUN mkdir -p /var/run/sshd

# Everything is done by default, unless forced otherwise (docker-compose forces to skip these steps for local dev)
ARG ENABLE_PHP_PRELOAD="1"
ARG COPY_SOURCE="."
ARG INSTALL_PACKAGES="1"
RUN if [ "$ENABLE_PHP_PRELOAD" = "1" ] ; then printf '\nopcache.preload=/var/www/symfony/config/preload.php\nopcache.validate_timestamps=0\n' >> /usr/local/etc/php/conf.d/custom.ini ; fi
COPY $COPY_SOURCE /var/www/symfony/
COPY docker/app/install-packages.sh /tmp/install-packages.sh
RUN chmod u+x /tmp/install-packages.sh && /tmp/install-packages.sh $INSTALL_PACKAGES

# Cleanup
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN usermod --uid=1000 www-data && \
    groupmod --gid=1000 www-data && \
    chown -R www-data:www-data /var/www/

CMD ["supervisord", "-n"]
