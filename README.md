# SWC Prospect
A simple application to track material deposits on different planets in SWCombine. A MVC system is implemented in PHP, supported by jQuery and backed by a MySQL database.

![SWCProspect](https://github.com/mattgogerly/swc-prospect/raw/main/recording.gif "Recording of SWCProspect")

## Usage
### Pre-requisites
* MySQL
* PHP >= 8.0

### Setup
Import the sample data into the database:

`$ mysql -uroot -p`

`$ source ./swc-prospect/init/init.sql;`

Start the PHP server:

`$ php -S localhost:9000`

Open http://localhost:9000.
