iAuction is an open source(MIT License) web app for creating and runing online auctions. It's intended use is small 
private auctions among friends, charities, or other organizations. The app allows you to create auctions, items, 
assign items to an auction, update auction start/end time, update item name, description, picture, starting bid amount,
allows users to bid on items, displays total amount user is invested per auction, etc.

iAuction is built on the following technologies:
 - MySQL
 - PHP
	- PHP Secure session adapted from: http://www.wikihow.com/Create-a-Secure-Login-Script-in-PHP-and-MySQL
 - Apache
 - Linux (windows, or mac should work fine too.)
 - BootStrap http://getbootstrap.com/
 
Installation:
 *Assuming you have a LAMP (WAMP, or MAMP) stack already set up
 1. Create a database for the application on your MySQL server (preferably name it iAuction)
 2. Run iAuction_install.sql against your MySQL database
 3. Create a database user with UPDATE, INSERT, SELECT, and DELETE privledges on the iAuction database
 4. Place the "auction" folder into the root folder of your web server
 5. Update the database connection information in /includes/psl-config.php
 6. Test loggin into the system with the user: administrator and password: Administrator1
 
 
Road map:
 - Improve CSS for mobile responsiveness
 - Search functionality
 - Maintain-> Users
 - User self service password reset
 - Group based permissions (admin, standard user, etc.)
 - MySQL maintenace routines to clean up expired auctions, items linked to expired auctions, etc.
 - Maintain-> System
 
 