#Spartan Theme
A custom Bootstrap sub-theme for the GCFSI Knowledge Platform.

## How do I use this theme?
1. Install the latest (as of June 2015) dev version of the Bootstrap theme.
2. Enable this theme
3. You may need to manually configure some settings: navbar is fixed-top, CDN is turned off, secondary menu and site name are turned off

## What is included in this theme?
1. The usual Drupal theming-related knavery.  Template files, theme function overrides, etc.  Yawn.
2. A gulp build system!  To use, clone this repo, navigate to its root directory, and run `npm install` followed by `gulp`.  This will allow you to work only in the /src folder, and it will automatically complile LESS files, move images around, and do other helpful things. 

## This theme is nearly useless without Spartan Layout!
Spartan Layout is a helper module that contains all sorts of Panels layouts, HTML widgets, and other helpful stuff.  Make sure you enable it with this theme.
