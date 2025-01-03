import {gql} from '@apollo/client';

interface QueryParams {
    fields?: string[];
    filter?: { [key: string]: string | number };
}

class GraphQLQueries {
    static constructGetProductsQuery({fields = ["id"], filter}: QueryParams) {
        const filterString = filter
            ? Object.entries(filter)
                .map(([key, value]) => `${key}: "${value}"`)
                .join(', ')
            : '';

        return gql`
        query GetData {
            products${filterString ? `(filter: { ${filterString} })` : ''} {
            ${fields.join('\n')}
            }
        }`;
    }

    static constructGetProductByIdQuery(id: string, fields: string[] = ["id", "images { url }", "name", "inStock", "price", "description", "attributes { name, values { id, displayValue, value } }"]) {
        return gql`
        query GetProductById {
            product(id: "${id}") {
                ${fields.join('\n')}
            }
        }`;
    }
}

export default GraphQLQueries;