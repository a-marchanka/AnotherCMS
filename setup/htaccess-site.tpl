RewriteEngine On

# Security headers
Header always set X-Powered-By "PHP"
Header always set X-Frame-Options "SAMEORIGIN"
Header always set Referrer-Policy "strict-origin"
Header always set X-Content-Type-Options "nosniff"

# php_value max_execution_time 1000
# php_value max_input_time 1000
# php_value memory_limit 128M

# Basis-URL /xyz
RewriteBase /{$site_subdir}

#Reffer for robot.txt files...
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)\.php$ index.php
RewriteRule ^sitemap.xml$ sitemap.php
RewriteRule ^robots.txt$ robots.php
RewriteRule ^humans.txt$ humans.php

#Setting redirection rules for typical cms-mode 
RewriteCond %{REQUEST_URI} !content
RewriteCond %{REQUEST_URI} !cms
RewriteCond %{REQUEST_URI} !webstat
RewriteCond %{REQUEST_URI} !setup
RewriteCond %{REQUEST_URI} !\.well-known
RewriteRule ^([^\.]*)$ index.php?m=$1&%{QUERY_STRING} [L]

# compress text, html, javascript, css, xml:
AddOutputFilterByType DEFLATE text/plain
AddOutputFilterByType DEFLATE text/html
AddOutputFilterByType DEFLATE text/xml
AddOutputFilterByType DEFLATE text/css
AddOutputFilterByType DEFLATE application/xml
AddOutputFilterByType DEFLATE application/xhtml+xml
AddOutputFilterByType DEFLATE application/rss+xml
AddOutputFilterByType DEFLATE application/javascript
AddOutputFilterByType DEFLATE application/x-javascript
