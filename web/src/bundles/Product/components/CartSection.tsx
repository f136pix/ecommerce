import {Component} from 'react';
import {Product} from "../../../types/product.ts";

type CartSectionProps = {
    product: Product;
    handleAddToCart: (product: Product) => void;
}

class CartSection extends Component<CartSectionProps> {
    render() {
        return (
            <div>
                
            </div>
        );
    }
}

export default CartSection;