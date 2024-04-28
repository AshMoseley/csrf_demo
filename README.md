# CSRF_demo Web Application
## Overview
This web application demonstrates a Cross-Site Request Forgery (CSRF) vulnerability. The project provides both an example of how CSRF can be exploited and how it can be mitigated within a controlled environment.

## Prerequisites
- XAMPP (or any web server stack that includes Apache, MySQL, PHP)
- A modern web browser (e.g., Chrome, Firefox)

# Setup Instructions
### 1. Install XAMPP
Download and install XAMPP from https://www.apachefriends.org/index.html. Ensure that Apache and MySQL are selected during the installation process.

## 2. Project Files
Extract the contents of the provided zip file into the htdocs directory of your XAMPP installation.

## 3. Database Setup
1. Start the Apache and MySQL services via the XAMPP Control Panel.
2. Open a web browser and navigate to http://localhost/phpmyadmin.
3. Create a new database named csrf_demo.
4. Import the Database:
- Select the csrf_demo database in phpMyAdmin.
- Click on the "Import" tab at the top.
- Choose the csrf_demo.sql file provided in your project folder.
- Click on "Go" to import the database. This will set up your tables and initial data.
## 4. Configuration Check
Verify that the database configuration in db.php matches your XAMPP MySQL settings, typically username: root and password: ``, unless you have configured it differently.

# Running the Application
### 1. Access the Application:
- Navigate to http://localhost/csrf_demo/index.php in your web browser.
- Log in using the credentials provided (if specific users are included in the csrf_demo.sql, use those credentials).
### 2. Perform the CSRF Attack:
- Open a new tab and navigate to http://localhost/csrf_demo/malicious.html to simulate the CSRF attack which attempts to change the user's email without their knowledge.
### 3. Verify the Attack:
- Return to the dashboard tab and refresh the page to see if the email has been changed, indicating a successful CSRF attack.

# Applying the Patch
### 1. Enable CSRF Protection:
- Open the dashboard.php file.
- Change $csrf_protection = false; to $csrf_protection = true;.
- Save the changes.
### 2. Test the Patch:
- Attempt the CSRF attack again by visiting malicious.html.
- Refresh the dashboard to verify that the email remains unchanged, indicating that the CSRF attack was blocked by the implemented protections.
