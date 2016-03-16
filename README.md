# 2131083

Installation
------------

1. Clone repository
2. Composer install
3. Configure your preferred http-server, be it nginx or apache.

If you only wish to test the application, you may also start the built in server: php bin/console server:start/run

During the installation you will be requested to enter the default-ttl.
I high-traffic situations we recommend a short-ttl and varnish in front.
Be sure to make use of the new grace-feature available in Varnish 4.

