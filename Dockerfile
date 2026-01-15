# PHP ve Apache sunucusunu içeren resmi imaj
FROM php:8.1-apache

# Çalışma dizinini Apache'nin ana klasörü yap
WORKDIR /var/www/html

# GitHub'daki tüm dosyaları (encel.php dahil) içeri kopyala
COPY . .

# Render'ın portu ile Apache'nin portunu (80) eşitlemek için
# Apache'nin portunu 10000 yapıyoruz (Render'ın sevdiği port)
RUN sed -i 's/80/10000/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Apache'yi dış dünyaya aç
EXPOSE 10000

# Apache sunucusunu başlat
CMD ["apache2-foreground"]
