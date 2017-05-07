SOCIAL AUTH WECHAT MODULE

CONTENTS OF THIS FILE
---------------------

 * Introduction
 * Requirements
 * Recommended modules
 * Installation
 * Configuration
 * How it works
 * Support requests

INTRODUCTION
------------

Social Auth WeChat Module is a WeChat Authentication integration for Drupal. It
is based on the Social Auth and Social API projects. This module serves as a
guide to create new implementers for Social Auth.

It adds to the site:
* A new url: /user/login/wechat.
* A settings form on /admin/config/social-api/social-auth/wechat page.
* A WeChat Logo in the Social Auth Login block.

REQUIREMENTS
------------

This module requires the following modules:

 * Social Auth (https://drupal.org/project/social_auth)
 * Social API (https://drupal.org/project/social_api)

INSTALLATION
------------

 * Download overtrue/wechat SDK
   (https://github.com/overtrue/wechat). We recommend to use
   Composer module to install the library.
    ````
    composer require "drupal/social_auth_wechat:1.x-dev"

    ````

 * Install the dependencies: Social API and Social Auth.

 * Install as you would normally install a contributed Drupal module. See:
   https://drupal.org/documentation/install/modules-themes/modules-8
   for further information.

CONFIGURATION
-------------

 * Add your WeChat project OAuth information in
   Configuration » User Authentication » WeChat.

 * Place a Social Auth Login block in Structure » Block Layout.

 * If you already have a Social Auth Login block in the site, rebuild the cache.


HOW IT WORKS
------------

Users can click on the WeChat logo on the Social Auth Login block
You can also add a button or link anywhere on the site that points 
to /user/login/wechat, so theming and customizing the button or link
is very flexible.

When the user opens the /user/login/wechat link, it automatically takes
the user to WeChat Accounts for authentication. WeChat then returns the user to
Drupal site. If we have an existing Drupal user with the same email address
provided by WeChat, that user is logged in. Otherwise a new Drupal user is
created.

SUPPORT REQUESTS
----------------

Before posting a support request, carefully read the installation
instructions provided in module documentation page.

Before posting a support request, check Recent log entries at
admin/reports/dblog

Once you have done this, you can post a support request on github:
https://www.drupal.org/project/issues/social_auth_wechat.

When posting a support request, please inform if you were able to see any errors
in Recent log entries.
