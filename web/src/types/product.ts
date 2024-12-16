import {Item} from "react-use-cart";

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
    description: string;
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

export type CartItem = {
    id: string,
    name: string,
    price: number,
    quantity: number,
    productAttributeValueIds: string[],
    product: Product
}

export interface ICartItem extends Item {
    product: Product;
    productAttributeValueIds: string[];
}