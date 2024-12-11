export type Product = {
    id: string;
    name: string;
    price: number;
    inStock: boolean;
    images: Image[];
    category: {
        name: string;
    };
    attributes: Attribute[]
};

export type Image = {
    id: string;
    url: string;
}

export type Attribute = {
    name: "Capacity | Size" | "Color" | string;
    values: {
        id: string;
        value: string;
    }[];
}; 
 