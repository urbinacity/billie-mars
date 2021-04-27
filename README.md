## About
Billie Backend Mission

## How to run

Vagrant and Homestead are recommended. In you have an existing Homestead environment you can just add it site to your mapping otherwise just verify the content in `Homestead.yaml` and then `vagrant up` to get started.

When everything is running, the endpoint is accesible at:

http://localhost:3000 or http://billie.mars:3000

## How to use

This app includes an endpoint at `/mars`, you can pass a UTC date/datetime as parameter sending a GET request including the `utc` attribute (lowercase) containing the specified time.
Default: displays the current time.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
