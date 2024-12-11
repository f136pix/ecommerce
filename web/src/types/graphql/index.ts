export type OrderItemInput = {
    productAttributeValueIds: number[];
    amount: number;
}

export type CreateOrderInput = {
    orderItems: OrderItemInput[];
}

