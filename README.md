webbtj/cm-cli
===============

Quick links: [Using](#using) | [Installing](#installing) | [Contributing](#contributing)

## Using

### Commands
```
wp cm core config
wp cm create-image-size <width> [--height=<height>] [--scale]
wp cm create-local-config [--db-name=<db-name>] [--db-user=<db-user>] [--db-password=<db-password>] [--db-host=<db-host>] [--db-charset=<db-charset>] [--db-collate=<db-collate>]
wp cm create-menu <slug> <name>
wp cm create-post <slug> [--label=<label>] [--textdomain=<textdomain>] [--dashicon=<dashicon>]
wp cm create-taxonomy <slug> [--label=<label>] [--textdomain=<textdomain>] [--post-types=<post-types>] [--hierarchical] [--hierarchy] [--hierarch] [--hier]
wp cm create-template <slug> [--label=<label>]
wp cm create-theme <directory-name> [--theme-title=<theme-title>] [--theme-uri=<theme-uri>] [--author-name=<author-name>] [--author-uri=<author-uri>] [--theme-description=<theme-description>] [--theme-version=<theme-version>] [--activate]
wp cm optimal-setup [--skip-gitignore] [--skip-htaccess] [--keep-xmlrpc]
```

### Core Config
```
NAME

  wp cm core config

DESCRIPTION

  Setup a WordPress site, create DB and user, create a local config file

SYNOPSIS

  wp cm core config <master_user> <master_password> [--db-name=<db-name>]
  [--db-user=<db-user>] [--db-password=<db-password>] [--db-host=<db-host>]
  [--db-charset=<db-charset>] [--db-collate=<db-collate>]
  [--db-prefix=<db-prefix>]

OPTIONS

  <master_user>
    The master username, this is used to create the user and database

  <master_password>
    The master password, this is used to create the user and database

  [--db-name=<db-name>]
    The database name
    ---
    default: "wordpress"

  [--db-user=<db-user>]
    The database user name
    ---
    default: "root"

  [--db-password=<db-password>]
    The database user password, if left blank, a random one will be generated
    ---
    default: ""

  [--db-host=<db-host>]
    The database host
    ---
    default: "localhost"

  [--db-charset=<db-charset>]
    The database charset
    ---
    default: "utf8"

  [--db-collate=<db-collate>]
    The database collate type
    ---
    default: ""

  [--db-prefix=<db-prefix>]
    The database prefix, if left blank a random one will be generated
    ---
    default: ""

EXAMPLES

    wp cm create-local-config --db-name="wordpress" --db-user="wordpress_user"
  --db-password="wordpress_pass"
```

### Create Image Size
```
NAME

  wp cm create-image-size

DESCRIPTION

  Register a Menu in your C+M Smarty theme

SYNOPSIS

  wp cm create-image-size <width> [--height=<height>] [--scale]

OPTIONS

  <width>
    The width

  [--height=<height>]
    The height
    ---
    default: 0

  [--scale]
    Use this to scale instead of crop, crop is the default

EXAMPLES

    wp cm create-menu main "Main Menu"
```

### Create Local Config
```
NAME

  wp cm create-local-config

DESCRIPTION

  Add a custom page template to your theme

SYNOPSIS

  wp cm create-local-config [--db-name=<db-name>] [--db-user=<db-user>]
  [--db-password=<db-password>] [--db-host=<db-host>] [--db-charset=<db-charset>]
  [--db-collate=<db-collate>]

OPTIONS

  [--db-name=<db-name>]
    The database name
    ---
    default: "wordpress"

  [--db-user=<db-user>]
    The database user name
    ---
    default: "root"

  [--db-password=<db-password>]
    The database user password
    ---
    default: ""

  [--db-host=<db-host>]
    The database host
    ---
    default: "localhost"

  [--db-charset=<db-charset>]
    The database charset
    ---
    default: "utf8"

  [--db-collate=<db-collate>]
    The database collate type
    ---
    default: ""

EXAMPLES

    wp cm create-local-config --db-name="wordpress" --db-user="wordpress_user"
  --db-password="wordpress_pass"
```

### Create Menu
```
NAME

  wp cm create-menu

DESCRIPTION

  Register a Menu in your C+M Smarty theme

SYNOPSIS

  wp cm create-menu <slug> <name>

OPTIONS

  <slug>
    The menu slug

  <name>
    The menu name

EXAMPLES

    wp cm create-menu main "Main Menu"
```

### Create Taxonomy
```
NAME

  wp cm create-taxonomy

DESCRIPTION

  Register a Taxonomy in your C+M Smarty theme

SYNOPSIS

  wp cm create-taxonomy <slug> [--label=<label>] [--textdomain=<textdomain>]
  [--post-types=<post-types>] [--hierarchical] [--hierarchy] [--hierarch]
  [--hier]

OPTIONS

  <slug>
    The taxonomy slug

  [--label=<label>]
    The taxonomy label
    ---
    default: "Tag"

  [--textdomain=<textdomain>]
    The textdomain of the post type
    ---
    default: null

  [--post-types=<post-types>]
    The taxnomy post type(s)
    ---
    default: "post"

  [--hierarchical]
    Whether or not the taxonomy is hierarchical
    ---

  [--hierarchy]
    Alias of hierarchical
    ---

  [--hierarch]
    Alias of hierarchical
    ---

  [--hier]
    Alias of hierarchical
    ---

EXAMPLES

    wp cm create-taxonomy event_tag --label="Tag" --post_types="event"
```

### Create Template
```
NAME

  wp cm create-template

DESCRIPTION

  Add a custom page template to your theme

SYNOPSIS

  wp cm create-template <slug> [--label=<label>]

OPTIONS

  <slug>
    The machine name of the page template

  [--label=<label>]
    The label of the page template
    ---
    default: "Custom Page Template"


EXAMPLES

    wp cm create-template about --label="About Template"
```

### Create Theme
```
NAME

  wp cm create-theme

DESCRIPTION

  Sets up your theme for Smarty for WordPress

SYNOPSIS

  wp cm create-theme <directory-name> [--theme-title=<theme-title>]
  [--theme-uri=<theme-uri>] [--author-name=<author-name>]
  [--author-uri=<author-uri>] [--theme-description=<theme-description>]
  [--theme-version=<theme-version>] [--activate]

OPTIONS

  <directory-name>
    The theme to set up.

  [--theme-title=<theme-title>]
    The title of the theme
    ---
    default: C+M Smarty Scaffold

  [--theme-uri=<theme-uri>]
    The uri of the theme
    ---
    default: http://sitebynorex.com

  [--author-name=<author-name>]
    The name of the Author
    ---
    default: C+M

  [--author-uri=<author-uri>]
    The author URI
    ---
    default: http://sitebynorex.com

  [--theme-description=<theme-description>]
    The theme description
    ---
    default: Smarty Scaffolded Theme by C+M

  [--theme-version=<theme-version>]
    The version of the theme
    ---
    default: 1.0

  [--activate]
    Whether or not to activate the theme
    ---
    default: false

EXAMPLES

    wp cm create-theme my_theme --theme-title="My Theme"
  --theme-uri="http://sitebynorex.com" --author-name="Norex"
  --author-uri="http://sitebynorex.com" --theme-description="A custom theme for a client"
```

### Optimal Setup
```
NAME

  wp cm optimal-setup

DESCRIPTION

  Setup some ideal environment settings, such as gitignore, htaccess, and xmlrpc

SYNOPSIS

  wp cm optimal-setup [--skip-gitignore] [--skip-htaccess] [--keep-xmlrpc]

OPTIONS

  [--skip-gitignore]
    Don't bother with gitignore file

  [--skip-htaccess]
    Don't both with htaccess

  [--keep-xmlrpc]
    Don't disable XMLRPC (XMLRPC gets disabled because it is rarely used and
    often the
    source of security issues)


EXAMPLES

    wp cm optimal-setup
```


## Installing

First off, install WP CLI if you haven't already: http://wp-cli.org/#installing

Once you've done so, you can install this package with `wp package install git@github.com:webbtj/cm-cli.git`.

## Contributing

We appreciate you taking the initiative to contribute to this project.

Feel free to contribute by testing, submitting issues or submitting pull requests. Full documentation on creating your own modules will follow.

### Reporting a bug

Think you’ve found a bug? We’d love for you to help us get it fixed.

Before you create a new issue, you should [search existing issues](https://github.com/webbtj/cm-cli/issues?q=label%3Abug%20) to see if there’s an existing resolution to it, or if it’s already been fixed in a newer version.

Once you’ve done a bit of searching and discovered there isn’t an open or fixed issue for your bug, please [create a new issue](https://github.com/webbtj/cm-cli/issues/new) with the following:

1. What you were doing (e.g. "When I run `wp post list`").
2. What you saw (e.g. "I see a fatal about a class being undefined.").
3. What you expected to see (e.g. "I expected to see the list of posts.")

Include as much detail as you can, and clear steps to reproduce if possible.

### Creating a pull request

Want to contribute a new feature? Please first [open a new issue](https://github.com/webbtj/cm-cli/issues/new) to discuss whether the feature is a good fit for the project.

Once you've decided to commit the time to seeing your pull request through, please follow our guidelines for creating a pull request to make sure it's a pleasant experience:

1. Create a feature branch for each contribution.
2. Submit your pull request early for feedback.
3. Follow the [WordPress Coding Standards](http://make.wordpress.org/core/handbook/coding-standards/).
