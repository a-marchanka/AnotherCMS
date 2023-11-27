RewriteEngine Off

# Security headers
Header always set X-Powered-By "PHP"
Header always set X-Frame-Options "SAMEORIGIN"
Header always set Referrer-Policy "strict-origin"
Header always set X-Content-Type-Options "nosniff"

# php_value max_execution_time 1000
# php_value max_input_time 1000
# php_value memory_limit 128M

#AuthName "Service-Zone"
#AuthType Basic
#AuthUserFile {$site_dir}/cms/.htpasswd
#Require valid-user

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
