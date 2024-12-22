https://github.com/Ecodev/graphql-doctrine

# DB Schema

![img_1.png](img_1.png)
> The dotted entities are join tables

# Apache a2 Config

```xml
<!-- /etc/apache2/sites-available/app.conf -->
<VirtualHost *:80>
    ServerName yourdomain.com
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html

    ProxyPreserveHost On
    ProxyPass / http://localhost:3000/
    ProxyPassReverse / http://localhost:3000/

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

## GraphQL Requests

- Get All Products

```graphql
// Query
{
  products(filter: { category: "clothes" }) {
    id,
    name,
     inStock,
    category {
        name
    }
  }
}
```

- Get Product By ID

```graphql
// Query
{
  product(id: 5) {
    id,
    name,
    price,
    inStock,
    category {
      name
    },
    attributes { 
        name,
        values { 
            id,
            value
        }
    }
  }
}
```

- Create Order

```graphql
// Mutation
mutation {
  createOrder(input: {
    orderItems: [
      {
        productAttributeValueIds: [1,43],
        amount: 1
      },
      {
        productAttributeValueIds: [32,74],
        amount: 3
      }
    ]
  }) {
    id
    status
  }
}
```




