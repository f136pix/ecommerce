export type OrderItem = {
    attributesIds: number[];
    amount: number
}

export type ICreateOrderInput = {
    orderItems: OrderItem[]
} 