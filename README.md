1. In your root Apache directory set up .htaccess file with the following code:

```
<IfModule mod_rewrite.c>
RewriteEngine on
RewriteCond %{ENV:REDIRECT_STATUS} ^$
RewriteRule ^(.*)$ TVS/index.php/$1 [L]
RewriteRule \.css$ TVS/style.css [L]
</IfModule>
```

2. Open project directory and in command line type:

```
   php composer.phar install
   vendor/bin/doctrine orm:schema-tool:update --force --dump-sql
```

3. Open localhost in browser.
