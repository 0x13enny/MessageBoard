# Network_Security
2019 Spring Practicum of Attacking and Defense of Network Security Project


## Setup
---

### Composer

#### Install Composer
```
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer
```

Add below line to .bashrc ( or .zshrc )
```
PATH=/usr/local/bin:$PATH
```

In the root directory of NS_MessageBoard, run:
```
composer install
```
it will install the dependencies defined in composer.json
