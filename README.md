ChaoticCard
===========

ChaoticCard is a personal site application that were base on the ChaoticSoul theme for Wordpress. You can now add you own themes.
It's built using the micro-framework Silex, Doctrine, Twig as template engine, and uses a SQLite database. 

Example: http://samy.dindane.com/

Notes
-----
* The installation form has no validation, and it isn't up to date. Feel free to contribute. 

Installation steps
------------------
* Clone this repo (`git clone git@github.com:Dinduks/ChaoticCard.git`)
* Install required submodules (`git submodule update --init --recursive`)
* Add this to your vhost file (if you have any)
  <Directory "/path/to/the/app">
      AllowOverride All
  </Directory>

Features to come
----------------
* An admin page to edit the vCard 
* Language selector 
* Enhanced SEO 
* Contact form

How to add a theme
------------------
* Create a folder called `MyTheme` in `web/themes/` and one called `views/` inside of it 
* Put the homepage content in a `homepage.html.twig` file inside the `views` dir
* Same thing for the installation page (`install.html.twig`)
* Don't forget to copy `translations.html.twig` from `src/views/` to your theme's `views` folder
You can take the existing themes as examples.