import {Component} from 'react';
import {CartProviderState} from "react-use-cart";

import {CartItem} from "../../../../types/product.ts";

import CartFooter from './CartFooter';
import CartHeader from './CartHeader';
import CartItemComponent from './CartItem';

type CartComponentProps = {
    cartStore: CartProviderState;
    placeOrder: (input: CartItem[]) => Promise<void>;
};

class CartSection extends Component<CartComponentProps> {
    render() {
        const {cartStore, placeOrder} = this.props;
        const {items, cartTotal} = cartStore;

        return (
            <div className="absolute right-0 top-full w-72 bg-white shadow-lg p-4 z-50">
                <CartHeader itemsCount={items.length}/>
                {items.length === 0 ? (
                    <h2 className="text-base font-semibold">Your cart is empty</h2>
                ) : (
                    <ul>
                        {items.map((item, index) => (
                            <CartItemComponent key={index} item={item as any} cartStore={cartStore}/>
                        ))}
                    </ul>
                )}
                <CartFooter cartTotal={cartTotal} items={items} placeOrder={placeOrder}/>
            </div>
        );
    }
}

export default CartSection;