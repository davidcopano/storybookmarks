# Storybookmarks

This project allows you to save your bookmarks online, among other functions.

## Getting Started

### Prerequisites

To install and run the project locally you must have the following tools installed:

- [Composer](https://getcomposer.org/download/)
- [NodeJS](https://nodejs.org/)
- [NPM](https://www.npmjs.com/get-npm)

### Installing

Once you have installed these tools, run these commands on a terminal:

- Clone this project:
- ```
  git clone https://github.com/davidcopano/storybookmarks.git
  ```
  
- Install the project dependencies:
- ```
  composer install
  ```
  During the installation you will be asked for some parameters (data related to the database, data to send emails...).
  
- Install front end dependencies:
- ```
  npm install
  ```
  
- Build .scss and .js bundles (use ``--watch`` flag for build when this files changes):
- ```
  /node_modules/.bin/encore dev
  ```

- Ejecutar servidor local
    - ``php bin/console server:run``

-  Compilar SCSS y JS: 
    - ``./node_modules/.bin/encore dev --watch``