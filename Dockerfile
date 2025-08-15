## Use the official PHP 8.2 image with Apache
#FROM php:8.2-apache
#
## Install necessary extensions and dependencies
#RUN apt-get update && apt-get install -y \
#    libzip-dev \
#    libpng-dev \
#    libjpeg-dev \
#    libfreetype6-dev \
#    pkg-config \
#    unzip \
#    && docker-php-ext-configure gd --with-freetype --with-jpeg \
#    && docker-php-ext-install zip pdo_mysql gd
#
## Enable Apache mod_rewrite for Laravel
#RUN a2enmod rewrite
#
## Set the working directory in the container
#WORKDIR /var/www/html
#
## Copy Laravel project files to the container
#COPY . .
#
## Install Composer globally
#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
#
## Install Laravel dependencies
#RUN composer install --no-dev --optimize-autoloader
#
## Set permissions for Laravel storage and cache
#RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
#
#RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
#
#
## Expose port 80
#EXPOSE 80
#
## Start Apache
#CMD ["apache2-foreground"]


# Use a Windows-based PHP image with Apache
FROM mcr.microsoft.com/windows:1809

# Install PHP and Apache
RUN powershell -Command \
    Invoke-WebRequest -Uri "https://windows.php.net/downloads/releases/php-8.2.10-Win32-vs16-x64.zip" -OutFile "php.zip" ; \
    Expand-Archive -Path "php.zip" -DestinationPath "C:\\php" ; \
    Remove-Item -Force "php.zip" ; \
    [System.Environment]::SetEnvironmentVariable("PATH", $env:PATH + ";C:\\php", [System.EnvironmentVariableTarget]::Machine)

# Configure Apache (using XAMPP or similar for simplicity)
RUN powershell -Command \
    Invoke-WebRequest -Uri "https://www.apachelounge.com/download/VS16/binaries/httpd-2.4.57-win64-VS16.zip" -OutFile "apache.zip" ; \
    Expand-Archive -Path "apache.zip" -DestinationPath "C:\\Apache24" ; \
    Remove-Item -Force "apache.zip" ; \
    [System.Environment]::SetEnvironmentVariable("PATH", $env:PATH + ";C:\\Apache24\\bin", [System.EnvironmentVariableTarget]::Machine)

# Enable mod_rewrite for Laravel
RUN powershell -Command \
    Set-Content -Path "C:\\Apache24\\conf\\httpd.conf" -Value \
    (Get-Content "C:\\Apache24\\conf\\httpd.conf" | ForEach-Object { if ($_ -match '^#LoadModule rewrite_module modules/mod_rewrite.so$') { $_ -replace '^#', '' } else { $_ } })

# Set up working directory
WORKDIR C:/inetpub/wwwroot

# Copy Laravel project files to the container
COPY . .

# Install Composer
RUN powershell -Command \
    Invoke-WebRequest -Uri "https://getcomposer.org/installer" -OutFile "composer-setup.php" ; \
    C:\\php\\php.exe composer-setup.php ; \
    Move-Item -Path "composer.phar" -Destination "C:\\php\\composer.phar" ; \
    [System.Environment]::SetEnvironmentVariable("PATH", $env:PATH + ";C:\\php", [System.EnvironmentVariableTarget]::Machine)

# Install Laravel dependencies
RUN powershell -Command \
    C:\\php\\php.exe C:\\php\\composer.phar install --no-dev --optimize-autoloader

# Set permissions for Laravel storage and cache
RUN powershell -Command \
    icacls C:\\inetpub\\wwwroot\\storage /grant Users:F /T ; \
    icacls C:\\inetpub\\wwwroot\\bootstrap\\cache /grant Users:F /T

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["C:\\Apache24\\bin\\httpd.exe", "-w", "-f", "C:\\Apache24\\conf\\httpd.conf"]
