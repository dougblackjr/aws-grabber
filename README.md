# AWS Grabber
## Grabs feeds from the AWS status board (https://status.aws.amazon.com/)

### Installation
Clone the repo into a directory. Point it toward a database in the database config in `config/settings.php`. Point Apache to the root directory.

### Settings
Settings are placed in the `config/settings.php` file.

There are three variables:
`$dataconnection`: This is the Database connection information

`$dataTable`: Name of the table you would like the app to write to

`$deleteEntriesOlderThan`: This deletes entries older than this number.

### Grabber
The Grabber portion is run on the command line by running from the root directory:
`php script/getdata.php`

You can access feeds in two ways.

First, you can add feeds to `config/feeds.md`. Add one per line.

Second, you can run any number of feeds in the command line by typing:
`php script/getdata.php (URL TO FEED)`

For example, `php script/getdata.php https://status.aws.amazon.com/rss/appstream2-us-east-1.rss https://status.aws.amazon.com/rss/ec2systemsmanager-us-east-1.rss`

The Grabber also deletes entries older than the amount of days set in settings, to keep the database small. You can change this setting in `config/settings.php`.

### Viewer
Set this up in Apache, and point your browser to the root directory. For example, if you are running on localhost, point your browser to:
`localhost`.

By default, this will show all channels (each feed) that you have accessed, up to the last 100 entries.

### API
Point your browser to `localhost/script/viewdata.php` to get the raw JSON