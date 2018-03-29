# BaseAdminSkeleton

This is a package that covers most of the starting areas of the custom sites I build for my designer.

Features:
* Simple User entity
* Recover Password for the I-D-TEN-T user
* Complete User Provider
* Complete User Manager
* Bootstrap and FontAwesome placed in front end Twig, ready for implementation
* Admin/User area firewalled and ready for use
* Admin/User area skinned with SB Admin 2
* Generator Bundle templates overridden to load seamlessly into Admin Area
* ```@Menu()``` annotation to build multi-level menus from your controllers
* Menu Bundle extended to have a config for the non-bundle routes
* Menu Event to add Dynamic Menu items

## Installation

```bash
$ git clone https://github.com/fatguytyson/base-admin-skeleton.git yourProject
$ cd yourProject
$ composer install
```

From this point, you should be able to see the home page and the top default menu.

To see the admin area right now, run:

```bash
$ php bin/console doctrine:schema:create
$ php bin/console doctrine:fixtures:load
```

Username: admin

Password: password

## First Steps

Start creating your project entities through:
```bash
$ php bin/console doctrine:generate:entity
```
And for my favorite part, create the admin CRUD controllers through:
```bash
$ php bin/console doctrine:generate:crud AppBundle:EntityName
```
This should cover the majority of your Admin Entity CRUD needs, with minimal customization.

## Next Steps

### See [FGC/Menu](https://github.com/fatguytyson/menu-bundle) Documentation

The ```@Menu()``` Annotation makes rapid menu changes easy. Here is all the documentation you need to know.

Then there is direct ```config.yml``` configuration.

And lastly, there is now Dynamic Menu Item adding through Events.

### Admin Area
This is the base controller for ```/admin``` to add your custom actions and have a landing page for logins.
Add Actions to this controller, or make your own. The assets for SB Admin 2 are already in the "web" folder under "dist" and "vendor". 
#### CRUD Generation
When using the CRUD generator, make the prefix ```/admin/entity``` to have it load into the firewall smoothly. The generation templates were optimized for the SBAdmin2 Layout and also includes the ```@Menu()``` Annotation so it will show upon ```cache:clear```.

### User Area 
Much like the Admin area above, but it was set up specifically for "ROLES_USER". This area doesn't have a CRUD generator, as no run of the mill user can be trusted with that power.
Assets for this area are in the same place as above. being it is the same layout.

### Security Controller
This is where I placed the actions un-authenticated users have access to, like login, request password reset, and actually reset the password.
If you wanted user profile editors like FOSUserBundle, this is not it. I always ended up adding so much to the User Entity and kept getting lost tryng to modify the forms. So take off and run with a plain old Entity.
Again, assets are in the same folders as AdminArea and UserArea.

### Default Controller
This is completly up to you from here on out. Modify base.html.twig directly, Make entirely new templates, or extend to other layouts. This is where you start howing your clients your design prowess.
Assets for this area is right under "web" with "css", "fonts", "images", and "js". Of course, this is just the base and can be torn out if you would like.

## Features
### Site Defaults
These are generated and asked for in the parameter generation. Pretty basic.
They are also in Twig Globals, so they can be used in the templates as well.
#### Site Name
The name of the site, in all of its glory. I recommend capitalising.
#### Site Domain
Yes, you can go through the request object to get the base URI, but this is quick, dirty, and consistant.
#### Site Email
Default email, something you can use when you have to get information out.

### Email Templating
#### Usage
From any container aware function.
```php
$message = $this->get('app.mail_generator')->getMessage('contact', $parameters);
$message
    ->setFrom('no-reply@'.$this->getParameter('site_domain'))
    ->setTo($this->getParameter('admin_email'));
$this->get('mailer')->send($message);
```
Simple!
But wait, what is this message?
#### Email Template Location
All in the emails folder, ```app/Resources/views/emails```. Copy the template.twig file and name it appropriatly. 
OR copy this into a new file.
```twig
{% extends 'emails/filter/'~email_filter~'.twig' %}

{% block subject %}{% endblock %}

{% block body_html %}
{% endblock %}

{% block body_text %}
{% endblock %}
```
Here you have an area for a subject, HTML, and a textpart. All in one file. It also has the full strength of twig rendering, so translations, too!

## THIS IS A WORK IN PROGRESS
As time goes on, I will keep adding to this. But as it is a starting off point, it isn't designed to be upgraded, maintained, or versioned. Use it at your own risk, but still, have fun!