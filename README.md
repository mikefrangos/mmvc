mmvc
====
This project is submitted for examination for BTH's phpmvc course. 

installation
-----------
First, clone this framework from github into your directory:

> git clone git://github.com/mikefrangos/mmvc.git

Then, you have to make the data-directory writable. This is the place where Mmvc needs to be able to write and create files.

> cd mmvc; chmod 777 site/data

If you are installing on to www.student.bth.se, you will need to open the .htaccess file, uncomment the rewritebase rule and add your base URL. 

Finally, there are some modules that need to be initialized. Access the "install" method within the module controller. You can find this from the index page of your installation, or by adding "module/install" after your base url. 

a customizable framework
-----------
The default theme is based on Twitter's Bootstrap with responsivity enabled. Try resizing the window to see this in action.

To create a blog post, access the "create" method within the content controller. Then specify the content type as "post." To create a static page, specify the content type as "page." To view all blog posts, click "my blog" from the menu bar. To view all content, access the content controller. Any content can have the following filters applied: "htmlpurify", "bbcode", "markdown", or "smartypants". 

Logo, header, footer and menu may be edited from config.php. To customize the framework via web interface, login as root (username: root, password: root), and access the "config" method within the acp controller. Here, you can also change the logo, header, and footer. Menus can be similarly created, edited or deleted from the "menu" method within acp.

the administrative interface
----------
All users who belong to the admin group have access to the acp controller and its methods. To access acp from a default installation, login as root (username: root / password: root). Using the acp controller, users may create or edit groups, add and remove users from groups, create and delete users and edit user profiles. 

Users and groups may be created from the acp controller and may be edited from here as well. To add or remove a user from a group, edit that user's profile. To edit a group, first click to view a list of the group's members from the acp controller. From any group's view, you may either edit the group itself, or edit the profiles of any of the group's members. When you edit a user or group, you will also see the option to delete that user or group. (NOTE: users may not add themselves to groups. This is an admin function that can only be performed through the acp controller.)

In order to limit content to members of a certain group, edit that content and choose which groups may be allowed to see it. Any content that does not belong to a group is considered public. NOTE: members of the admin group do not have default access to all content, so if content is assigned to a group to which an admin user does not also belong, then make sure you edit that user's own permissions through the acp controller in order to gain access to all content.

NOTE: the "root" user is not a true superuser but only has admin privileges based on belonging to the admin group. If you remove "root" from the admin group, you will lose access to acp and any content that is limited to members of the admin group.

threaded comments
----------
Threaded comments are handled through an external module, CThreadedComments. Adding and replying to comments on the guestbook will demonstrate this implementation.

test installation
---------
A test installation of Mmvc can be found at http://www.student.bth.se/~mifb12/phpmvc/mmvc/tags/v0.3.0/
