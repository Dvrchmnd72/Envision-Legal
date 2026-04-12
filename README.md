# Envision Legal – WordPress Astra Child Theme

A deployable child theme for the **Astra** parent theme, built for the Envision Legal commercial law firm website. Includes full page templates, custom CSS/JS, and an optional WP-CLI content seeder.

---

## Table of Contents

1. [Theme Overview](#theme-overview)
2. [Prerequisites](#prerequisites)
3. [Installation – Local or Development](#installation--local-or-development)
4. [Deploy to GoDaddy Managed WordPress via SSH](#deploy-to-godaddy-managed-wordpress-via-ssh)
5. [Activate the Theme](#activate-the-theme)
6. [Run Content Seeding](#run-content-seeding)
7. [Configure the Theme](#configure-the-theme)
8. [File Structure](#file-structure)

---

## Theme Overview

| Feature | Detail |
|---|---|
| **Parent theme** | Astra (free version works) |
| **Theme directory** | `wp-content/themes/envision-legal/` |
| **Text domain** | `envision-legal` |
| **Supports** | Post thumbnails, custom logo, title tag, HTML5, wide/full-width blocks |
| **Registered menus** | Primary Navigation, Footer Navigation |

### Pages with dedicated templates

| Slug | Template file |
|---|---|
| `/` (front page) | `front-page.php` |
| `/about` | `page-about.php` |
| `/contact` | `page-contact.php` |
| `/practice-areas` | `page-practiceareas.php` |
| `/terms-of-use` | `page-termsofuse.php` |
| `/privacy-policy` | `page-privacypolicy.php` |
| `/south-west-sydney-lawyers` | `page-south-west-sydney-lawyers.php` |
| Blog single | `single.php` |
| Blog index / archive | `archive.php` |
| 404 | `404.php` |
| Fallback | `index.php` |

---

## Prerequisites

- **WordPress** 6.0 or later
- **Astra** parent theme installed and active (before activating this child theme)
- PHP 7.4+
- `wp-content/themes/` writable

### Install the Astra parent theme

**Via WP Admin:**
1. WP Admin → Appearance → Themes → Add New
2. Search "Astra" → Install → **Do not activate yet**

**Via WP-CLI:**
```bash
wp theme install astra
```

---

## Installation – Local or Development

```bash
# Clone the repo anywhere and copy the theme folder
git clone https://github.com/Dvrchmnd72/Envision-Legal.git
cp -r Envision-Legal/wp-content/themes/envision-legal /path/to/wordpress/wp-content/themes/
```

Or clone directly into the themes directory:

```bash
cd /path/to/wordpress/wp-content/themes
git clone https://github.com/Dvrchmnd72/Envision-Legal.git envision-legal-repo
cp -r envision-legal-repo/wp-content/themes/envision-legal .
```

---

## Deploy to GoDaddy Managed WordPress via SSH

Your GoDaddy Managed WordPress SSH user is:
```
client_ab6bc81e9b_1116071@<server-ip>
```

### Step 1 – SSH into the server

```bash
ssh client_ab6bc81e9b_1116071@<server-ip>
```

### Step 2 – Find your WordPress themes directory

```bash
find ~ -maxdepth 6 -type d -name "themes" 2>/dev/null
# or
find /var/www -maxdepth 6 -type d -name "themes" 2>/dev/null
```

Common paths on GoDaddy Managed WP:
- `~/public_html/wp-content/themes/`
- `/var/www/html/wp-content/themes/`

### Step 3 – Clone the repo and copy the theme

```bash
# Option A – clone into a temp location, then copy theme folder
cd ~
git clone https://github.com/Dvrchmnd72/Envision-Legal.git
cp -r ~/Envision-Legal/wp-content/themes/envision-legal ~/public_html/wp-content/themes/

# Option B – clone directly into themes (creates a subdirectory with the repo name)
cd ~/public_html/wp-content/themes
git clone https://github.com/Dvrchmnd72/Envision-Legal.git envision-legal-repo
cp -r envision-legal-repo/wp-content/themes/envision-legal .
```

### Step 4 – Verify the files are in place

```bash
ls ~/public_html/wp-content/themes/envision-legal/
# Expected: style.css  functions.php  screenshot.png  front-page.php  ...
```

### Future updates – pull latest changes

```bash
cd ~/Envision-Legal
git pull origin main
cp -r wp-content/themes/envision-legal ~/public_html/wp-content/themes/
```

---

## Activate the Theme

### Via WP Admin (recommended)

1. WP Admin → **Appearance → Themes**
2. Ensure **Astra** is installed (you should see it in the list)
3. Click **Activate** on **Envision Legal**

### Via WP-CLI

```bash
wp theme activate envision-legal
```

---

## Run Content Seeding

The seeder at `tools/seed-content.php` creates/updates all pages and blog posts with provided content via WP-CLI.

### If WP-CLI is available (preferred)

```bash
# From your WordPress root directory
wp eval-file wp-content/themes/envision-legal/../../tools/seed-content.php

# Or with full path
wp eval-file /path/to/wordpress/tools/seed-content.php
```

**What the seeder does:**
- Creates/updates pages: `home`, `about`, `contact`, `practice-areas`, `terms-of-use`, `privacy-policy`, `south-west-sydney-lawyers`
- Sets the `home` page as the WordPress front page
- Creates/updates 7 blog posts (business sales, startup legals, trademarks, unfair contract terms, fractional counsel, shareholders agreement, secret stuff)
- Assigns page templates, categories and tags
- Downloads and sideloads featured images (add CDN URLs to `image_url` fields in the seeder)

### If WP-CLI is NOT available

**Option A – Temporary admin plugin (fastest)**

1. Create a file `/wp-content/plugins/el-seed-once.php`:

```php
<?php
/*
 * Plugin Name: EL Seed Once
 * Description: Temporary content seeder – DELETE after use.
 */
add_action('admin_init', function() {
    if (!current_user_can('manage_options') || empty($_GET['el_seed'])) return;
    require_once get_template_directory() . '/../../tools/seed-content.php';
    // Replace WP_CLI calls with wp_die() messages
    wp_die('Seeding complete. Delete this plugin.');
});
```

2. Activate it in WP Admin → Plugins
3. Visit: `https://yoursite.com/wp-admin/?el_seed=1`
4. Deactivate and delete the plugin immediately after

**Option B – Manual content entry**

Use WP Admin → Pages → Add New and WP Admin → Posts → Add New to create each page/post manually, using the content from `tools/seed-content.php` as your source material.

---

## Configure the Theme

After installing and activating, customise these settings:

### 1. Set Navigation Menus

WP Admin → **Appearance → Menus**

- Create a menu with: Home, About, Practice Areas, Blog, Contact
- Assign to **Primary Navigation** location
- Optionally create a footer menu and assign to **Footer Navigation**

### 2. Set Logo and Firm Details

WP Admin → **Appearance → Customize**

- **Site Identity** – Upload your logo (recommended: 240×80px PNG with transparency)
- **Firm Details** – Set phone number, email address and office address

### 3. Install a Contact Form Plugin

The Contact page template is ready for a contact form shortcode. Recommended:
- **Contact Form 7** (free) – paste `[contact-form-7 id="xxx"]` into the Contact page content
- **WPForms Lite** (free) – paste the WPForms shortcode into the page content

### 4. Set Reading Settings

WP Admin → **Settings → Reading**

- "Your homepage displays" → **A static page**
- Front page: **Home**
- Posts page: **Blog** (create a blank page with slug `blog`)

---

## File Structure

```
wp-content/themes/envision-legal/
├── style.css                           # Theme header (Template: astra)
├── functions.php                       # Enqueue, menus, theme support, helpers
├── screenshot.png                      # Theme thumbnail (1200×900)
├── index.php                           # Fallback template
├── front-page.php                      # Home page
├── page-about.php                      # About page
├── page-contact.php                    # Contact page
├── page-practiceareas.php              # Practice Areas page
├── page-termsofuse.php                 # Terms of Use page
├── page-privacypolicy.php              # Privacy Policy page
├── page-south-west-sydney-lawyers.php  # Local SEO landing page
├── single.php                          # Blog post
├── archive.php                         # Blog index / category / tag / search
├── 404.php                             # Not found
└── assets/
    ├── css/
    │   └── theme.css                   # Main stylesheet (brand colours, layout, components)
    └── js/
        └── theme.js                    # Accordion, mobile nav, smooth scroll, back-to-top

tools/
└── seed-content.php                    # WP-CLI content seeder
```

---

## Licence

GNU General Public License v2 or later. See [https://www.gnu.org/licenses/gpl-2.0.html](https://www.gnu.org/licenses/gpl-2.0.html)
