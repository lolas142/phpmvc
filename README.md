All about burgers 
=========
## Om projektet
All about burgers är ett projekt som är skapat i kursen phpmvc på Blekinges Tekniska Högskola. Temat för sajten är vegetariska burgare men kan enkelt bytas ut mot något annat. Grunden är ett forum för frågor, svar och kommentarer som är skyddat bakom inloggning. Icke-inloggande användare kan endast läsa medan registrerade, inloggade användare kan posta nya frågor, svar och kommentarer.

## Installation

Klona ner projektet till din www-mapp.

`git clone https://github.com/aa222di/phpmvc-bth.git`

Ställ dig sedan i projektmappen och installera dependencies

`composer update no --dev`

Därefter måste du modifiera .htaccess filen så den stämmer för din webroot. Du hittar filen i phpmvc-bth/webroot/.htaccess

Navigera sedan till phpmvh-bth/webroot/setup för att köra setup-scriptet för databastabellerna. Se till att du har rätt inställningar i config-filerna för databasen (phpmvc-bth/app/config/config_mysql.php) och även config_with_app.php.

Nu är applikationen installerad och redo att användas. Navigera genom sidan via menyn.



```
