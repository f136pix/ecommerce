import GraphQLQueries from "../graphql/queries.ts";
import client from "../lib/appoloClient.ts";

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

    static async fetchProductById(id: string) {
        const query = GraphQLQueries.constructGetProductByIdQuery(id);
        const response = await client.query({query});

        if (response.errors) {
            throw response;
        }

        return response.data.product;
    }
}

export default ProductService;
