import {Component} from 'react';
import {CartProviderState} from "react-use-cart";
import CartHeader from './CartHeader';
import CartItemComponent from './CartItem';
import CartFooter from './CartFooter';

type CartComponentProps = {
    cartStore: CartProviderState;
};

class CartSection extends Component<CartComponentProps> {
    render() {
        const {cartStore} = this.props;
        const {items, cartTotal} = cartStore;

        return (
            <div className="absolute right-0 top-full w-72 bg-white shadow-lg p-4 z-50">
                <CartHeader itemsCount={items.length} />
                {items.length === 0 ? (
                    <h2 className="text-base font-semibold">Your cart is empty</h2>
                ) : (
                    <ul>
                        {items.map((item, index) => (
                            <CartItemComponent key={index} item={item as any} cartStore={cartStore} />
                        ))}
                    </ul>
                )}
                <CartFooter cartTotal={cartTotal} />
            </div>
        );
    }
}

export default CartSection;