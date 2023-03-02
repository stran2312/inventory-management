Inventory Management API
This API is designed to provide a simple and efficient way to manage inventory data. The API includes methods for uploading and updating device data, listing and deleting devices, and viewing device information.

Getting Started
Prerequisites
PHP 7.x or higher
MySQL 5.6 or higher
Installing
Clone the repository to your local machine.
Navigate to the project root directory in your terminal.
Run composer install to install the required dependencies.
Create a new MySQL database and update the .env file with your database information.
Run the following command to set up the database schema:
Copy code
php artisan migrate
Start the server by running:
Copy code
php artisan serve
API Endpoints
Upload File
bash
Copy code
POST /api/devices/upload
Uploads device data from a CSV file.

Update Device
bash
Copy code
PUT /api/devices/{id}
Updates the device information for the specified device ID.

List Devices
bash
Copy code
GET /api/devices
Returns a list of all devices in the inventory.

Delete Device
bash
Copy code
DELETE /api/devices/{id}
Deletes the device information for the specified device ID.

View Device
bash
Copy code
GET /api/devices/{id}
Returns the device information for the specified device ID.

Security
This API uses token-based authentication to secure access to its endpoints. The authentication token should be included in the Authorization header of each request.

Limitations
Due to the free-tier limitations of the server, the API is currently limited to handling inventory data for up to 10,000 devices.

Contributing
Contributions to this project are welcome! Please submit any issues or pull requests on the project's GitHub page.

License
This project is licensed under the MIT License - see the LICENSE.md file for details.

Acknowledgments
This project was inspired by the need for a simple and efficient way to manage inventory data.
Special thanks to the Laravel PHP framework for making the development of this API possible.
