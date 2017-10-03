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
* ```@Menu()``` annotation to build single level menus from your controllers
* Menu Bundle extended to have a config for the non-bundle routes

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

The ```@Menu()``` Annotation makes rapid menu changes easy. Here is all the documentation you need to know.

### Using the Annotation

Add the annotation to the Use statements block.
```php
<?php
namespace AppBundle\Controller;

use AppBundle\Annotation\Menu;
use //...
```

Then add the ```@Menu()``` annotation to any routed controller action.
```php
/**
 * @Menu("Dashboard", route="admin_dashboard", icon="dashboard", order="1", group="admin", role="ROLE_ADMIN")
 * @Menu("Admin Area", route="admin_dashboard", order="3")
 * @Route("/", name="admin_dashboard")
 */
public function dashboardAction()
{//...
```

And lastly, render the menus in your templates.
```twig
{# ... #}
{{ fgc_menu() }}
{# ... #}
```

This renders:

```html
<li>
    <a href="/">
        Home
    </a>
</li>
<li>
    <a href="/user/">
        User Area
    </a>
</li>
<li>
    <a href="/admin/">
        Admin Area
    </a>
</li>
    
```

If you need routes outside of your bundle, you can add them via config.yml, rather than creating a bunch of Annotations.

```yaml
fgc_menu:
    namespace: AppBundle\Controller #This is the default and doesn't have to be included
    directory: AppBundle/Controller #This is the default and doesn't have to be included
    menus:
        admin_user:
            User Area:
                route: user_dashboard
                order: 1
                icon: list
                role: ROLE_USER
            Logout:
                route: logout
                order: 2
                icon: sign-out
        user_user:
            Admin Area:
                route: admin_dashboard
                order: 1
                icon: list
                role: ROLE_ADMIN
            Logout:
                route: logout
                order: 2
                icon: sign-out

```

Need a custom template? **Hold on**, I'm working on the documentation for that. In fact, I would like to break the entire bundle out to a composer include-able. If anyone is willing to take the time to help, I would appreciate it. GitHub and Composer have been tools I have used, because of necessity, but I am still learning the more interesting stuff.


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
### @Menu Documentation
#### Name
This will be the display text of the menu item. If you want different names for different menu groups, feel free to make multiple @Menu annotations per action.
#### Route
This should be the route name.
This seems redundant, and in a way, it is, but I haven't figured how to get the name of the action otherwise.
#### Route Options
This is where that route name seems less redundant, and this increases in power. Send through expected parameters for the route and potentially turn one route into 10 menu items.
#### Icon
This is the FontAwesome icon to display in the rendering. As you can see in the example, it is sans the "fa-".
#### Order
As the Controllers are loaded alphabetically, it is doubtful you want your menu items the same way. So hit each one with a number to order the menu flawlessly.
#### Group
If this is blank, it is loaded into the default group. But go ahead and load as menu menu groups as you want. Each "key" will group all like keyed menus together and order them separately.
#### Role
This makes it easy to filter the menu based on the user. Use whatever Roles you have devised, and enjoy.

#### Children

This references the submenu for this item. Yes, you can self reference, but depth is defaulted to 2, so, it is up to you.


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
Here you have an area for a subject, HTML, and a textpart. All in one file. It also has the foll strength of twig rendering, so translations, too!

## THIS IS A WORK IN PROGRESS
As time goes on, I will keep adding to this. But as it is a starting off point, it isn't designed to be upgraded, maintained, or versioned. Use it at your own risk, but still, have fun!