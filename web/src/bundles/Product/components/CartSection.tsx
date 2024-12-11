import {Component} from 'react';
import {Product} from "../../../types/product.ts";
import AttributesForm from "./AttributesForm.tsx";

type CartSectionProps = {
    product: Product;
    // handleAddToCart: (product: Product) => void;
}

class CartSection extends Component<CartSectionProps> {
    render() {
        const {product} = this.props;
        return (
            <div className={"flex flex-col w-5/12 h-auto text-3xl"}>
                <h2 className={"text-primary font-semibold mb-12"}>{product.name}</h2>
                <AttributesForm  product={product}/>
            </div>
        );
    }
}

export default CartSection;