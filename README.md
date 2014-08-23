# Import file information to database

This script will traverse a directory tree and import file information to a MySQL database for later processing.

Currently it saves the following data:
  - Parent directory absolute path
  - File name (including extension)
  - Normalized file extension (everything after the last dot in lower case)
  - File size in bytes

Tested on PHP 5.6.0RC4 and MySQL 5.6.17.

## Warning

This is beta software, backup your data and use at your own risk.

## Usage

Import the `myfiles.sql` file into MySQL to create the database.

Edit the database connection info at the `config.php` file. If there's a `PHP_ENV` environment variable defined as 'test', 'development' or 'production', the script will use that value. Otherwise it defaults to 'development'.

Run from the command line:

```
php import.php [-s] /path/to/import
```

The `-s` options runs it in (almost) silent mode.

## Tests

You can run the tests with:

```
phpunit --bootstrap test/bootstrap.php test/
```

## License

The MIT License (MIT)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
