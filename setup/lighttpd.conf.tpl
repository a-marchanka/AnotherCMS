server.modules = (
        "mod_setenv",
        "mod_fastcgi",
        "mod_rewrite",
        "mod_access",
        "mod_accesslog",
        "mod_alias",
        "mod_redirect" )

server.document-root        = "{$site_dir}"
server.upload-dirs          = ( "/var/cache/lighttpd/uploads" )
server.errorlog             = "/var/log/lighttpd/error.log"
accesslog.filename          = "/var/log/lighttpd/access.log"
server.pid-file             = "/var/run/lighttpd.pid"
server.username             = "www-data"
server.groupname            = "www-data"
server.port                 = 80

server.http-parseopts = (
        "header-strict"            => "enable",
        "host-strict"              => "enable",
        "host-normalize"           => "enable",
        "url-normalize"            => "enable",
        "url-normalize-unreserved" => "enable",
        "url-normalize-required"   => "enable",
        "url-ctrls-reject"         => "enable",
        "url-path-2f-decode"       => "enable",
        "url-path-dotseg-remove"   => "enable",
        "url-query-20-plus"        => "enable" )

index-file.names            = ( "index.php", "index.html", "index.lighttpd.html" )
url.access-deny             = ( "~", ".inc" )
static-file.exclude-extensions = ( ".php", ".pl", ".fcgi" )

compress.cache-dir          = "/var/cache/lighttpd/compress/"
compress.filetype           = ( "application/javascript", "text/css", "text/html", "text/plain" )

# default listening port for IPv6 falls back to the IPv4 port
include_shell "/usr/share/lighttpd/use-ipv6.pl " + server.port
include_shell "/usr/share/lighttpd/create-mime.assign.pl"
include_shell "/usr/share/lighttpd/include-conf-enabled.pl"

# direct access is denied for bibliothek and images
$HTTP["url"] =~ "^/(cms/auth|cms/data|cms/modules|cms/templates_c|content/images/originals)/" {
   url.access-deny = ( ".sh", ".sqlite", ".php", ".jpg", ".gif", ".png" )
   server.error-handler-404 = "403"
}
# rewrite urls
url.rewrite-if-not-file = (
   "^/.well-known/(.*)$" => "/$0",
   "^/robots.txt" => "/robots.php",
   "^/humans.txt" => "/humans.php",
   "^/sitemap.xml" => "/sitemap.php",
   "^/content/(.*)$" => "$0", # no restrictions for static content
   "^/([^.?]*)$" => "/index.php?m=$1", # default controller
   "^/([^.?]*)\?(.*)?$" => "/index.php?m=$1&$2", # other requests
   "^/$" => "/index.php" # default page
)
server.modules += (
        "mod_compress",
        "mod_dirlisting",
        "mod_staticfile" )

