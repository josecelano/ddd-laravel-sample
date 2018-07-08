# Laravel DDD sample application

By [Jose Celano](http://josecelano.com/)

A Laravel DDD sample application.

The purpose: build a simple DDD Laravel application to be compared with the CRUD approach.

You can find the CRUD approach here: https://github.com/josecelano/my-favourite-appliances.

I have read a lot of posts saying that DDD is ony valid for complex domains. But sometimes I also have read some of them 
saying DDD can also be applied for simple problems. I think I would use a CRUD approach for prototypes and refactor
later to DDD as soon as the project becomes a long term project. But on the other hand I do not think that the DDD approach
can be much more expensive than the CRUD one. With this sample I want to test both solutions for the same simple problem,
in order to compare them.

In this example I have used CQRS. Domain entities are stored in a serialized object in the database. The idea was to do something
as what Vaughn Vernon describes here:

The Ideal Domain-Driven Design Aggregate Store?
https://vaughnvernon.co/?p=942 

On the other hand Read Models are created using Eloquent models.

* Write model -> Table with to columns: id, data (serialized object)
* Read model -> Eloquent models

Please, see "Problems" section if you want to know what kind of drawbacks I had for this architecture.

## Specifications

Create a website where users will be able to see a variety of home appliances, creating a wishlist of their favourite ones 
which can be shared with friends.

The application will use another site as a primary data source: https://www.appliancesdelivered.ie .
The new site should contain products from both the small appliances and dishwashers categories:

* https://www.appliancesdelivered.ie/search/small-appliances
* https://www.appliancesdelivered.ie/dishwashers

Users will be able to see the data for these products presented in a clean and attractive format, regardless of the 
device they're using to view the site. 

* Users can order the data by title or price.
* When on the site, a user can create an account to save their favourite appliances to their wishlist.
* Their wishlist can then be shared with other friends.
* Their friends may not like the appliances the user has selected, so the user may also need to quickly remove items 
from their wishlist!

We'll want our new site to have good data, so need the ability to regularly sync new data from
AppliancesDelivered.ie to our great new site. But keep in mind that if our new site gets very popular, we don't want
to kill the source site with increased requests and server load, so we need to think carefully about how we handle this 
syncing process (how often it's run, when it's triggered, what we do with the resulting data etc).

We also need to allow for the case that AppliancesDelivered.ie may be down for maintenance, but we want our site 
to stay alive, so keep that in mind also when thinking about your approach here. The more confidence we can have in 
the continued operation of the site, the better! At some point in the future, if this site is successful the data source 
may be migrated from this crawler approach to a more formal API-based approach, so keep that path in mind when 
structuring your code.

The above are the main points of the application, but if you feel the application can be improved or any interesting 
other features implemented, then feel free to go wild!

## Installation

```bash
mysqladmin -u homestead -psecret create dddlaravelsample
git clone git@github.com:josecelano/ddd-laravel-sample.git
cd dddlaravelsample
php -r "file_exists('.env') || copy('.env.example', '.env');"
composer install
php artisan storage:link
php artisan migrate
php artisan db:seed
php artisan serve
```

## Run crawler

```bash
php artisan import:dishwashers
php artisan import:small-appliances
```

Scheduler is set to execute import hourly:

```bash
php artisan schedule:run
```

## Reset all application data

```
php artisan migrate:refresh --seed
php artisan import:dishwashers
php artisan import:small-appliances
```

## Live demo

* Url: http://my-favourite-appliances.hyve.software
* Demo accounts: https://github.com/josecelano/ddd-laravel-sample/blob/master/database/seeds/Access/UserTableSeeder.php

Open localhost:8000 in the browser.

## TODO

* Dispatch events with static service when they are produced instead of storing them in the entity and distpactching them
  in the command handler.
* Use JSON instead of serialized object in database.
* Remove appliances not updated in the last 24 hours.
* Enable more social authentication providers.
* Order list by title and price.
* Dislike button on each wishlist item (ReactJS component). Show different icon if user has already clicked.
* Dislikes counter (ReactJS component).
* Add username to user profile and change permalink for users' wishlist (http://localhost:8000/1/wishlist to http://localhost:8000/username/wishlist)
* Store events.
* REST API for events.
* Add tests.

## Problems

* Since we only query from read model tables, even when we want to get a domain entity we could not find domain entities 
even if they exist, if the read model does not exist. For example: if there is an error after creating a domain entity,
 and the app can not create the read model, then the entity can not be found. The only way to fix this problem is using 
 a database which supports queries using filtering by JSON attributes in JSON column types.

* Since we store entities serialized with all attributes instead of JSON format, we also store events if we do not
release the events before persisting the entity, in other words we have to call `save` method always after releasing events:

```
$this->emitter->emitGeneratedEvents($appliance);
$this->applianceRepository->save($appliance);
```

If we do not do that events will be trigger again every time we load the entity from database. This could be solve by 
storing entities in JSON without the events. We could also dispatch events before saving in the repository, or finally
we could use a static method to dispatch events where there are produced without storing them in the entity. 

More info about different approaches here:
https://youtu.be/dXcHRcvgcUc?list=PLfgj7DYkKH3Cd8bdu5SIHGYXh_bPV2idP&t=338 (Spanish)

## Acknowledgment

I have used this boilerplate: https://github.com/rappasoft/laravel-5-boilerplate

## Links

* http://codebetter.com/gregyoung/2010/02/15/cqrs-is-more-work-because-of-the-read-model/ (by https://github.com/gregoryyoung?)
