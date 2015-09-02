WoE ranking source mod and FluxCP addon
=======

Works with eAmod-A and other.

What can
Sort by any column
Search by any column / nick / guild / class
Caches data and guild emblem (cache: 1 update every 1 hour)
Installation

Unpack woe.zip to any folder

Open rating.php and configure mysql connection
```PHP
//MySQL host
$ro['db']['host'] = "localhost";
//MySQL User
$ro['db']['user'] = "root";
//MySQL Password
$ro['db']['password'] = "";
//MySQL DB
$ro['db']['database'] = "ragnarok";
//MySQL Encoding
$ro['db']['sql_encode'] = "utf8";
$ro['db']['encode'] = "UTF-8";
```