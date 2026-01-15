# PHP 8.1 ve Apache sunucusu
FROM php:8.1-apache

# Gerekli PHP eklentilerini kur (Veri işlemleri için lazım olabilir)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Çalışma dizini
WORKDIR /var/www/html

# Tüm dosyaları (encel.php dahil) içeri kopyala
COPY . .

# Apache portunu Render'ın 10000 portuna zorla
RUN sed -i 's/80/10000/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Yetkileri ayarla
RUN chown -R www-data:www-data /var/www/html

EXPOSE 10000

CMD ["apache2-foreground"]
