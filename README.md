1. In your root Apachr directory set up .htaccess file with the following code:

<IfModule mod_rewrite.c>
RewriteEngine on
RewriteCond %{ENV:REDIRECT_STATUS} ^$
RewriteRule ^(.*)$ TVS/index.php/$1 [L]
RewriteRule \.css$ TVS/style.css [L]
</IfModule>
