https://github.com/Ecodev/graphql-doctrine

# DB Schema

![img_1.png](img_1.png)
> The dotted entities are join tables

On this schema, an OrderItem is the closest to a Product. It has a ManyToOne relationship with ProductAttributeValue,
which is the entity that holds the product's attributes, defining for example the color, size, etc...

## GraphQL Queries

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
  product(id: "5") {
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
        productAttributeValueIds: ["1","3"],
        amount: 2
      },
      {
        productAttributeValueIds: ["1","1"],
        amount: 3
      }
    ]
  }) {
    id
    status
  }
}
```




