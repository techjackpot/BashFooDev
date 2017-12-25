# Starter Asset Package
SASS Distro w/ Twitter Bootstrap 4 (alpha2.0)
[Wiki](http://git.usdigitalpartners.net/internal/starter-assets-sass/wikis/home)

## To use:
* Clone the repository
* From the terminal, run `npm install`
* From the terminal, run `npm start`

## Sasster
SCSS visibility tool for use in mobile styling. Use the structure command to print out all less files as barebone hierarchies with attributes ommitted. (i.e. `.myclass { attribute: style; }` prints to `.myclass {}` ). Use the mobilize method to printout all stylesheets @1024 and @768.
* Print stucture files - `npm run-script structure`
* Destroy structure files - `npm run-script destructure`
* Print @media stylesheets - `npm run-script mobilize`