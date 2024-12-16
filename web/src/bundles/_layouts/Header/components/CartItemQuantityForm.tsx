import {Component} from 'react';
import {CartProviderState} from "react-use-cart";

const className = "flex items-center justify-center border bg-white text-primary w-2 h-6 border-black text-sm rounded-none px-3";
type CartItemQuantityFormProps = {
    itemId: string;
    quantity: number;
    updateItemQuantity: CartProviderState['updateItemQuantity'];
};

class CartItemQuantityForm extends Component<CartItemQuantityFormProps> {
    render() {
        const {itemId, quantity, updateItemQuantity} = this.props;

        return (
            <div className="flex flex-col items-center justify-between">
                <button
                    onClick={() => updateItemQuantity(itemId, quantity + 1)}
                    className={className}
                >
                    +
                </button>
                <a className={"text-black font-normal"}>{quantity}</a>
                <button
                    onClick={() => updateItemQuantity(itemId, quantity - 1)}
                    className={className}
                >
                    -
                </button>
            </div>
        );
    }
}

export default CartItemQuantityForm;