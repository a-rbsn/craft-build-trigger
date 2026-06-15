# Release Notes for Build Trigger

## 1.1.0
- Added support for configuring a separate build hook URL per site (multisite).
- Build hook URLs now support environment variables and aliases (e.g. `$BUILD_HOOK_MAIN`).
- The Build Trigger section now lets you pick a site and trigger its build.
- Build hook requests now accept any 2xx response (services such as Netlify and Vercel often return `201`) and handle request failures gracefully.
- Existing single-URL configurations are automatically migrated to the primary site.

> [!IMPORTANT]
> The `buildHookUrl` setting has been replaced by a per-site `buildHookUrls` map. Existing configurations are migrated automatically to the primary site on update.

## 1.0.0
- Initial release
