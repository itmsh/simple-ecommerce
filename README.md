Installation
============

  1. $ git clone https://github.com/itmsh/simple-ecommerce.git
  2. cd simple-ecommerce
  3. composer install
  4. config your ElasticSearch server in this file: ./config/packages/fos_elastica.yaml
  5. config your Redis server in this file: ./config/packages/framework.yaml
  6. $ php bin/console doctrine:migrations:migrate
  7. $ php bin/console doctrine:fixtures:load

What is this?
-------------

Just a very simple ecommerce example using Redis, ElasticSearch and Symfony using following bundls:

- FOSRestBundle / JMSSerializerBundle
- DoctrineBundle
- FOSElasticaBundle
- SecurityBundle
