#*Inventory Management API*

This API is designed to provide a simple and efficient way to manage inventory data. The API includes methods for uploading and updating device data, listing and deleting devices, and viewing device information.
Project URL: https://ec2-3-137-205-7.us-east-2.compute.amazonaws.com/


#*Getting Started*
Prerequisites
PHP 7.x or higher
MySQL 5.6 or higher

#*Installing*
1. Clone the repository to your local machine.
2. Navigate to the project root directory in your terminal.
3. Run composer install to install the required dependencies.
4. Create a new MySQL database and update the .env file with your database information.
5. Run the following command to set up the database schema:
php artisan migrate
6.Start the server by running:
php artisan serve

*#API Endpoints*
Upload File
POST /api/Upload.php
Uploads device data from a CSV file.

Update Device
PUT /api/UpdateDevice.php
Updates the device information for the specified device ID.

List Devices
GET /api/ListDevices.php
Returns a list of all devices in the inventory.

Delete Device
DELETE /api/Delete.php/{id}
Deletes the device information for the specified device ID.

View Device
GET /api/ViewDevice.php/{id}
Returns the device information for the specified device ID.

Security
This API redirect all requests to https/ port 443 and Fast_CGI/ PHP_FPM, and NGINX web server.

Limitations
Due to the free-tier limitations of the free-tier AWS account and 5 million records, the API will take 5-6 seconds to load the first time.

Contributing
Contributions to this project are welcome! Please submit any issues or pull requests on the project's GitHub page.

Acknowledgments
This project was inspired by the need for a simple and efficient way to manage inventory data.
Special thanks to the Laravel PHP framework for making the development of this API possible.
