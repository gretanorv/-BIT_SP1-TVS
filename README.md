1. In your root Apache directory set up .htaccess file with the following code:

```
<IfModule mod_rewrite.c>
RewriteEngine on
RewriteCond %{ENV:REDIRECT_STATUS} ^$
RewriteRule ^(.*)$ BIT_SP1-TVS/index.php/$1 [L]
RewriteRule \.css$ BIT_SP1-TVS/style.css [L]
</IfModule>
```

2. Open project directory and in command line type:

```
   php composer.phar install
```

3. Create database named 'tvs_db' and in your project's directory run this code:

```
   vendor/bin/doctrine orm:schema-tool:update --force --dump-sql
```

3. Open localhost in browser.
