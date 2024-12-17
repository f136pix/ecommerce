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
            <div className='flex flex-col items-center justify-between'>
                <button
                    onClick={() => updateItemQuantity(itemId, quantity + 1)}
                    className={className}
                    data-testid='cart-item-amount-decrease'
                >
                    +
                </button>
                <a className={'text-black font-normal'} data-testid='cart-item-amount'>{quantity}</a>
                <button
                    onClick={() => updateItemQuantity(itemId, quantity - 1)}
                    className={className}
                    data-testid='cart-item-amount-increase'
                >
                    -
                </button>
            </div>
        );
    }
}

export default CartItemQuantityForm;