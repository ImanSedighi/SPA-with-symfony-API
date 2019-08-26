JAM Test
========

Hey there! This is a Sample single page invitation application using symfony 3 APIs.

## Technologies
- PHP > 7.0
- MySQL
- Symfony 3.4
- AngularJS 1.7

## How to deploy:
- Set your database name, username and password in app/config/parameters.yml.
- Install the packages by running composer install command
- Create a database by ./bin/console doctrine:database:create command.
- Inject seed data by running php bin/console doctrine:fixtures:load --fixtures=src/AppBundle/DataFixtures

Note: All imported test users passwords by fixture are 123456.

## What I have done:
- Installed and configured FOSUser Bundle v2.0 to handle Authentication in Symfony3
- Created Controller, Entities, Repositories and Services to handle the API functions
- Created Data Fixtures
- Created the UI and frontend functionalities

## How I could improve it if I suppose to spend more time on it:
- I could add pagination to GET endpoints.
- I wrote a basic integration test but If I had more time I could add a proper factory to add better dummy data and auto truncate the data in each run of tests. 
- I could also add more unit and integration test cases to reach to an acceptable coverage.
- I prefer to replace the current FOS authentication with a stateless authentication with JWT.

## Task Description:

#### Back end section:
Write a REST API based invitation system that allows for the following actions:
- One user aka the Sender can send an invitation to another user aka the Invited.
- The Sender can cancel a sent invitation.
- The Invited can either accept or decline an invitation.
- The Sender can see a list of all invitations they have sent.
- The Invited can see a list of all invitations they have received.
All endpoint responses must be in JSON.
The project must include tests written in the PHPUnit framework to demonstrate how the various API endpoints behave in relation to each other. Complete the project using Symfony3.

#### Client section:
Please use any front end framework to implement functional pages which are connected to the back end APIs you have created.
The front end should show:
- A list of all invitations a user has sent. Each invitation should show a status which is
either “accepted” or “cancelled”
- A list of all invitations a user has received. Each invitation should have the functionality
to either “delete” or “accept”
- A search functionality so that users can search for certain invitations in the front end