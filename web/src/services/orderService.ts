import GraphQLMutations from '../graphql/mutations';
import client from '../lib/appoloClient';
import { CreateOrderInput } from '../types/graphql';

class OrderService {
    static async createOrder(input: CreateOrderInput) {
        const mutation = GraphQLMutations.constructCreateOrderMutation(input);
        const response = await client.mutate({
            mutation
        });

        if (response.errors) {
            throw response;
        }

        return response.data.createOrder;
    }
}

export default OrderService;