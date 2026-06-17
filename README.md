# Build Trigger

A simple plugin to allow manual triggering of a webhook url, used for Netlify, Vercel etc.

In a multisite install you can configure a separate build hook per site, so each headless front-end can be rebuilt independently.

## Requirements

This plugin requires Craft CMS 5.5.0 or later, and PHP 8.2 or later.

## Configuration

Go to **Settings → Plugins → Build Trigger** and enter a build hook URL for each site. Leave a site blank to disable its build trigger.

Any service that exposes a build/deploy webhook works (Netlify, Vercel, GitHub Actions, GitLab, Cloudflare Pages, …) — the plugin simply sends a `POST` to the configured URL.

Environment variables and aliases are supported, so you can keep the actual URLs out of project config:

```
# .env
BUILD_HOOK_MAIN="https://api.netlify.com/build_hooks/xxxxxxxx"
BUILD_HOOK_SHOP="https://api.vercel.com/v1/integrations/deploy/prj_xxxxxxxx/yyyyyyyy"
```

Then enter `$BUILD_HOOK_MAIN` (etc.) as the hook URL for the corresponding site.

## Triggering a build

Open the **Build Trigger** section in the control panel, pick a site from the dropdown and press **Trigger build**. Only sites with a configured hook are listed.

## Installation

You can install this plugin from the Plugin Store or with Composer.

#### From the Plugin Store

Go to the Plugin Store in your project’s Control Panel and search for “Build Trigger”. Then press “Install”.

#### With Composer

Open your terminal and run the following commands:

```bash
# go to the project directory
cd /path/to/my-project.test

# tell Composer to load the plugin
composer require a-rbsn/craft-build-trigger

# tell Craft to install the plugin
./craft plugin/install build-trigger
```
