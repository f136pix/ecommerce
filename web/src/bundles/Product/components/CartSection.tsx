import {Component} from 'react';
import {htmlToText} from "html-to-text";

import {Product} from "../../../types/product.ts";

import AttributesForm from "./AttributesForm.tsx";

type CartSectionProps = {
    product: Product;
    addToCart: (product: Product, productAttributeValueIds: string[]) => void;
}

class CartSection extends Component<CartSectionProps> {
    render() {
        const {product, addToCart} = this.props;
        return (
            <div className={"flex flex-col w-5/12 h-auto text-3xl space-x-24 text-primary"}>
                <h2 className={"font-semibold mb-12 ml-24"}>{product.name}</h2>
                <AttributesForm product={product} addToCart={addToCart}/>
                <div className={"text-sm text-primary font-normal"} data-testid='product-description'>
                    {htmlToText(product.description, {
                        wordwrap: false,
                        preserveNewlines: true
                    })}
                </div>
            </div>
        );
    }
}

export default CartSection;