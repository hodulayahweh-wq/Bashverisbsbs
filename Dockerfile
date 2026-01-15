FROM php:8.1-apache
# Tüm dosyaları ana dizine kopyala
COPY . /var/www/html/
# Apache portunu Render için ayarla
RUN sed -i 's/80/10000/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf
EXPOSE 10000
CMD ["apache2-foreground"]
