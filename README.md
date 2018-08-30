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

- Clone the project:
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

- Finally, run the project:
- ```
  php bin/console server:run
  ```
  
### Deployment

I followed [this guide](https://symfony.com/doc/3.4/deployment.html), made by the guys at Symfony, to deploy the project on my server.

### Built with

- [Symfony](https://symfony.com/) - PHP framework for web applications
- [Encore](https://symfony.com/doc/3.4/frontend/encore/installation.html) - Front end tasks
- [VueJS](https://vuejs.org/) - Some client functionalities
- [SCSS](https://sass-lang.com/) - Styling