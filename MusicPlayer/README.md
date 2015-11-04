# README #


# How do I get set up? #

##--Node.js installation##

sudo zypper ar \
  http://download.opensuse.org/repositories/devel:/languages:/nodejs/openSUSE_13.1/ \
  Node.js
  
sudo zypper in nodejs nodejs-devel

##--Mongodb Installation##

zypper addrepo http://download.opensuse.org/repositories/server:database/openSUSE_13.2/server:database.repo

zypper refresh

zypper install mongodb

##--Expess installation##

###Install express generator:###

$ npm install -g express-generator@4

###Install dependencies:###

$ npm install

###Start the server:###

$ npm start

# Contribution guidelines #

##For more information about npm##

https://docs.npmjs.com/
##--CRUD tutorial##

https://www.airpair.com/javascript/complete-expressjs-nodejs-mongodb-crud-skeleton

##--Other interesting links##

https://codeforgeek.com/2014/06/express-nodejs-tutorial/

https://codeforgeek.com/2014/10/express-complete-tutorial-part-1/