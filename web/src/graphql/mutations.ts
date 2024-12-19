import {gql} from '@apollo/client';

import {CreateOrderInput} from '../types/graphql';

class GraphQLMutations {
    static constructCreateOrderMutation(input: CreateOrderInput) {
        const orderItemsString = input.orderItems.map((item) => {
            return `{ productAttributeValueIds: [${item.productAttributeValueIds}], amount: ${item.amount} }`;
        }).join(',');

        return gql`
        mutation {
            createOrder(input: {
                orderItems: [${orderItemsString}]
            }) {
                id
                status
            }
        }`;
    }
}

export default GraphQLMutations;