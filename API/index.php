<?php
/*
Title: Documentation
Tagline: Commenting can be more rewarding
Tags: create, retrieve, read, update, delete, post, get, put, routing, doc, production, debug
Requires: PHP >= 5.3
Description: How to document and let your users explore your API.
We have modified SwaggerUI to create 
[Restler API Explorer](https://github.com/Luracast/Restler-API-Explorer)
which is used [here](explorer/index.html#!/authors-v1).

[![Restler API Explorer](../resources/explorer1.png)](explorer/index.html#!/authors-v1)

We are progressively improving the Authors class from CRUD example 
to Rate Limiting Example to show Best Practices and Restler 3 Features.

Make sure you compare them to understand.

Even though API Explorer is created with API consumers in mind, it will help the
API developer with routing information and commenting assistance when  our API
class is not fully commented as in this example. This works only on the debug
mode. Try changing rester to run in production mode (`$r = new Restler(true)`)

> **Note:-** production mode writes human readable cache file for the routes in
> the cache directory by default. So make sure cache folder has necessary
> write permission.

Happy Exploring! :)
*/

require_once 'vendor/restler.php';
use Luracast\Restler\Restler;

$r = new Restler();
// comment the line above and uncomment the line below for production mode
// $r = new Restler(true);
$r->addAPIClass('improved\\Authors');
$r->addAPIClass('noob\\sycon\\Authentication');
$r->addAPIClass('noob\\sycon\\Bill');
$r->addAPIClass('noob\\sycon\\Cashier');
$r->addAPIClass('noob\\sycon\\Category');
$r->addAPIClass('noob\\sycon\\Client');
$r->addAPIClass('noob\\sycon\\Command_Product');
$r->addAPIClass('noob\\sycon\\Commands');
$r->addAPIClass('noob\\sycon\\Customer');
$r->addAPIClass('noob\\sycon\\History');
$r->addAPIClass('noob\\sycon\\Lot');
$r->addAPIClass('noob\\sycon\\Measure');
$r->addAPIClass('noob\\sycon\\Operator');
$r->addAPIClass('noob\\sycon\\Payment');
$r->addAPIClass('noob\\sycon\\Payment_Type');
$r->addAPIClass('noob\\sycon\\Product');
$r->addAPIClass('noob\\sycon\\Product_Value');
$r->addAPIClass('noob\\sycon\\Provider');
$r->addAPIClass('noob\\sycon\\Representative');
$r->addAPIClass('noob\\sycon\\Sale');
$r->addAPIClass('generator\\Constructor');
$r->addAPIClass('generator\\Generator');
$r->addAPIClass('Resources');
$r->handle();
