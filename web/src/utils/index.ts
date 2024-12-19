import {type ClassValue,clsx} from "clsx";
import {twMerge} from "tailwind-merge";

import {Product} from "../types/product.ts";

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function concatenateId(productAttributeValueIds: string[]) {
    return productAttributeValueIds.join('-');
}

export function getSelectedValues(product: Product, productAttributeValueIds: string[]) {
    return productAttributeValueIds.reduce((acc: { [key: string]: string }, id) => {
        const attribute = product.attributes.find(attr => attr.values.some(val => val.id === id));
        if (attribute) {
            acc[attribute.name] = id;
        }
        return acc;
    }, {});
}