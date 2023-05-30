# moka VPOS Test Project

This is just a test project to experience Moka VPOS features and TXN types.

## To install and use on your locale

Before starting you might need to install valet tool to run project on your locale with a SSL Certificate.
To do so, please [refer its docs](https://laravel.com/docs/9.x/valet#installation).

Clone the repository and cd in:
```
git clone https://github.com/farouttravel/moka-vpos
cd moka-vpos
```

Link as valet web app and secure:
```shell
valet link moka-vpos
valet secure moka-vpos
valet isolate php@8.1
```

Create a `.env` file from blueprint:
```shell
cp .env.example .env
```

Install dependencies:
```shell
valet composer install
```
Then please edit your `.env` file and set the necessary credentials. 
Now if everything went well and, your app is up and running, you can visit [https://moka-vpos.test](https://moka-vpos.test)
and start testing. To further read you can visit [moka's docs.](https://developer.moka.com/en/)

## Disclaimer
This script is only for testing and exploring the API of the services provided by the bank, only use it for
this purpose, never use via any production credentials, even for testing use it at your own risk.
