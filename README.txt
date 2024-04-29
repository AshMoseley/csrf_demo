CSRF Demo Web Application

Overview

This web application demonstrates a Cross-Site Request Forgery (CSRF) vulnerability. 
The project provides both an example of how CSRF can be exploited and how it can be 
mitigated within a controlled environment.

Prerequisites

- A Windows machine
- XAMPP (or any web server stack that includes Apache, MySQL, PHP)
- A modern web browser (e.g., Chrome, Firefox)

Setup Instructions

1. Install XAMPP
Download and install XAMPP from https://www.apachefriends.org/index.html. 
Ensure that Apache and MySQL are selected during the installation process.

2. Project Files
Move the contents of the project zip file into the htdocs directory of your XAMPP
installation. This can be found at C:\xampp.

3. Database Setup
3a. Start the Apache and MySQL services via the XAMPP Control Panel.
3b. Open a web browser and navigate to http://localhost/phpmyadmin.
3c. Create a new database named csrf_demo.
    - Navigate to the sidebar on the left.
    - Click the "New" option at the top of the list of databases.
    - Enter "csrf_demo" in the "Database name" field and click create.
3d. Import the Database Contents:
    - Select the csrf_demo database from the sidebar list in phpMyAdmin.
    - Click on the "Import" tab at the top of the page.
    - Click "Browse...", then choose the csrf_demo.sql file provided in 
      this project folder.
    - Click on "Go" to import the database. This will set up your tables 
      and initial data.

4. Configuration Check
Verify that the database configuration in db.php matches your XAMPP MySQL settings, 
typically username: root and password: ``, unless you have configured it differently.
    - To view your MySQL settings, click "config" under the actions of XAMPP's MySQL module.
    - Select the option "my.ini" to open the configuration file.
If you have set a password for MySQL, set it as the value for the $password variable in db.php.

Running the Application

1. Access the Application:
- Navigate to http://localhost/csrf_demo/index.php in your web browser.
- Log in using the credentials provided (if specific users are included in the csrf_demo.sql, 
  use those credentials).

2. Perform the CSRF Attack:
- Open a new tab and navigate to http://localhost/csrf_demo/malicious.html to simulate a 
  CSRF attack which attempts to change the user's email without their knowledge.
- This runs a script containing a POST request that submits an email of our choosing 
  into the email submission box.
- In a real life example, this malicious link could be sent to unsuspecting users of a system.

3. Verify the Success of the Attack:
- Return to the dashboard tab and refresh the page to see if the email has been changed. 
  If so, the attack was successful.

Applying the Patch

1. Enable CSRF Protection:
- Open the dashboard.php file.
- Change $csrf_protection = false; to $csrf_protection = true;.
- Save the changes.

2. Test the Patch:
- Attempt the CSRF attack again by visiting malicious.html.
- Refresh the dashboard to verify that the email remains unchanged, indicating that the 
  CSRF attack was blocked by the implemented protections.
