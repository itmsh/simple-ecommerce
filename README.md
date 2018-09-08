Installation
============

  1. $ git clone https://github.com/itmsh/simple-ecommerce.git
  2. cd simple-ecommerce
  3. composer install
  4. config your ElasticSearch server in this file: ./config/packages/fos_elastica.yaml
  5. config your Redis server in this file: ./config/packages/framework.yaml
  6. $ php bin/console doctrine:migrations:migrate
  7. $ php bin/console doctrine:fixtures:load

REST API
--------
  1. To get all product

          GET /products/

  2. To Create a new product

          POST /products
          title={title}&description={description}
  
  3. To Edit product

          PUT /products/{productId}
          title={title}&description={description}

  4. To remove product

          DELETE /products/{productId}

  5. To get all product variants

          GET /products/{productId}/variants

  6. To Create a new product variants

          POST /products{productId}
          color={color}&price={price}
  
  7. To Edit product variants

          PUT /products/{productId}/variants/{variantsId}
          color={color}&price={price}

  8. To remove product variants

          DELETE /products/{productId}/variants/{variantsId}

  9. To Create a new user

          POST /users
          username={username}&password={password}&email={email}


What is this?
-------------

Just a very simple ecommerce example using Redis, ElasticSearch and Symfony using following bundls:

- FOSRestBundle / JMSSerializerBundle
- DoctrineBundle
- FOSElasticaBundle
- SecurityBundle
