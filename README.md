Example project to reproduce https://github.com/symfony/symfony/issues/44443
---------------

Start a webserver on port 8008, e.g `symfony serve --port 8008`

Afterwars run `bin/console app:upload-test`. When the output is `OK`, it's working, with `No file has been uploaded` it failed.
