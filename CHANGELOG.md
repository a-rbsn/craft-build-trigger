# Release Notes for Build Trigger

## 1.1.0
- Added support for configuring a separate build hook URL per site (multisite).
- Build hook URLs now support environment variables and aliases (e.g. `$NETLIFY_BUILD_HOOK`).
- The Build Trigger CP section now shows a trigger button per configured site.
- Build hook requests now accept any 2xx response (Netlify/Vercel often return `201`) and handle request failures gracefully.
- The trigger endpoint now requires an authenticated control panel request.
- Existing single-URL configurations are automatically migrated to the primary site.

## 1.0.0
- Initial release
