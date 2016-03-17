# 2131083

Installation
------------

1. Clone repository
2. Composer install
3. Configure your preferred http-server, be it nginx or apache.
4. Run the cache-warmer (php bin/console page:cache_warmup) to prepare site and to make sure nothing bad happens.

If you only wish to test the application, you may also start the built in server: php bin/console server:start/run

During the installation you will be requested to enter the default-ttl.
I high-traffic situations we recommend a short-ttl and varnish in front.
Be sure to make use of the new grace-feature available in Varnish 4.

Running tests
-------------

1. Make sure FireFox is installed
2. Fire up the built in php server.
3. Start selenium: vendor/selenium-server-standalone
4. Type: php vendor/bin/behat
5. Lean back, sip your coffee and enjoy.

Fun with caching (Yes... it can be fun)
---------------------------------------

1. Set a high ttl for stash upon composer install.
2. Schedule the cache-warmer to run at your leisure.
3. No more cache-misses on page-load; ever.