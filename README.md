LastFM API Client 
========================
Simple LastFM consumer application, to display statistics for a user based on
their listening habits. Very few options available at this stage, but will be 
looking to add more features as I go.

Installation
========================
This is a symfony app, so make sure you've copied your lastfm apikey before you
install its dependencies:
```bash
composer install -o
```
Then just start the inbuilt server with:
```bash
app/console server:start
```

Endpoints
========================
Few consumer endpoints currently available:
* [user.getinfo](http://www.last.fm/api/show/user.getInfo) - Maps to /{user}/info
* [user.gettoptracks](http://www.last.fm/api/show/user.getTopTracks) - Maps to /{user}/toptracks

Usage
========================
Access the endpoints via http://127.0.0.1:8000/username/endpoint (or a hostname of your choice)

The AppBundle contains all the controller logic for the endpoints, as it's contextually relevant
to the application. 

The logic to connect to lastfm's API is contained within its bundle, i.e
Craftwb\LastFMApiBundle, so at some point, I'd like to provide that bundle as a symfony bundle
that we'd be able to use in any project.