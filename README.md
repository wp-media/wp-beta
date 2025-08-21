# WP Beta
A library to enable a beta plugin update for WordPress plugins on the repository

# Overview

WP Beta provides an automated integration to offer a beta option in WordPress plugins.

How it works is by hijacking the update plugins data, checking if the version defined on the `trunk` of the repository contains `beta`. If it does, it will modify the update data to point to the trunk instead of the stable tag version.

## Installation

### Via Composer

Add the package to your project using Composer:

```bash
composer require wp-media/wp-beta
```

## Configuration

The library is composed of 2 main classes:
- `Optin` handles the status of the opt-in for beta
- `Beta` manages the update plugins data modification, beta messages, and hooking into WordPress

## How to use

The library is built to be fully configured by parameters passed to the classes constructors, and functional with one init method.

Here is an example of how to initialize it:

```php
$optin = new WPMedia\Beta\Optin( $plugin_slug, $capability );
$beta = new WPMedia\Beta\Beta( $optin, $file, $plugin_slug, $version, $update_message );

$beta->init();
```

You should not have to do more to enable the beta system.

### Parameters explaination
`$plugin_slug`: The slug used for the plugin as prefix for option/transient
`$capability`: The capability required to be able to modify the beta option
`$optin`: The Optin class instance
`$file`: The path of the plugin’s primary file relative to the plugins directory (for example `test-plugin/test-plugin.php`)
`$version`: The current stable version of the plugin
`$update_message`: Message to display when beta update is available (will be shown on the updates page and the plugins list page)

## Deploy a beta version to the WordPress repository

A modified version of the 10up action to deploy to the repository is available at https://github.com/wp-media/action-wordpress-plugin-trunk-deploy and can be used in your workflow to only release to trunk without tagging a new version.

You should modify your existing workflow to conditionally use the 10up deploy or this one, based on the release version containing `beta`.