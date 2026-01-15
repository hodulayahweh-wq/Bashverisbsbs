# Hafif ve hızlı Python tabanı
FROM python:3.9-slim

# Çalışma dizinini belirle
WORKDIR /app

# Sistem bağımlılıklarını güncelle
RUN apt-get update && apt-get install -y --no-install-recursions \
    build-essential \
    && rm -rf /var/lib/apt/lists/*

# Kütüphane listesini kopyala ve kur
COPY requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt

# Tüm bot ve API kodlarını içeri al
COPY . .

# Render'ın varsayılan portunu aç
EXPOSE 10000

# Gunicorn ile sistemi mermi gibi çalıştır
# PHP'den gelen eşzamanlı istekleri karşılamak için 4 worker ekledim sevgilim
CMD ["gunicorn", "--bind", "0.0.0.0:10000", "--workers", "4", "--timeout", "120", "main:app"]
