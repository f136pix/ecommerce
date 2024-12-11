import GraphQLQueries from "../graphql/queries.ts";
import client from "../lib/appoloClient.ts";
import {CreateOrderInput} from "../types/graphql";
import {Product} from "../types/product.ts";

export type FilterKeys = "category" | "price" | "brand";
type IFetchProductsParams = {
    fields?: string[],
    filter?: Partial<{ [key in FilterKeys]: string | number }>
}

class ProductService {
    constructor() {
    }

    static async fetchProducts({fields, filter}: IFetchProductsParams) {
        if (filter?.category == undefined || filter?.category == "") {
            delete filter?.category
        }

        const query = GraphQLQueries.constructGetProductsQuery({fields, filter});
        const response = await client.query({query});

        if (response.errors) {
            throw response;
        }

        return response.data.products;
    }

    static async fetchProductById(id: string, fields ?: string[]) : Promise<Product>{
        const query = GraphQLQueries.constructGetProductByIdQuery(id, fields);
        const response = await client.query({query});

        if (response.errors) {
            console.log(response.errors)
            throw response;
        }

        return response.data.product;
    }

    static async createOrder(input: CreateOrderInput) {
        const mutation = GraphQLQueries.constructCreateOrderMutation();
        const response = await client.mutate({
            mutation,
            variables: {input}
        });

        if (response.errors) {
            throw response;
        }

        return response.data.createOrder;
    }
}

export default ProductService;
