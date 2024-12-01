export type Product = {
    id: string;
    name: string;
    price: number;
    inStock: boolean;
    images: Image[];
    category: {
        name: string;
    };
    attributes: {
        name: string;
        values: {
            id: string;
            value: string;
        }[];
    }[];
};

export type Image = {
    id: string;
    url: string;
}