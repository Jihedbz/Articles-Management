# Articles Management

This project is for testing and learning purposes 
## Installation

After cloning the project make sure that your Xaamp or Wamp is up and running, you first need to go to your .env file and add your database
```bash
DATABASE_URL="mysql://root@localhost/Hatlone"
```
then execute these commands to create your database and entities

```bash
symfony console doctrine:database:create
symfony console make:migration
symfony console doctrine:migrations:migrate
```

## Usage
In order to run this project you need to run

```bash
Symfony server:start
```
after that check your listening port it should be 
```bash
http://127.0.0.1:8000/
```
start by creating your account following this route 
```bash
http://127.0.0.1:8000/register
```
## License

[MIT](https://choosealicense.com/licenses/mit/)
