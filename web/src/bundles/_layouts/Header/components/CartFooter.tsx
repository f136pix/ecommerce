import {Component} from 'react';
import {cn} from "../../../../utils";
import {Item} from "react-use-cart";
import {CartItem} from "../../../../types/product.ts";

type CartFooterProps = {
    placeOrder: (input: CartItem[]) => Promise<void>;
    cartTotal: number;
    items: Item[];
};

class CartFooter extends Component<CartFooterProps> {
    render() {
        const {cartTotal, items} = this.props;
        return (
            <div>
                <div className="mt-6 pt-2 flex justify-between font-semibold text-sm">
                    <span>Total</span>
                    <span data-testid='cart-total'>${cartTotal.toFixed(2)}</span>
                </div>
                <button
                    className={cn("uppercase bg-secondary-bg text-neutral-50 rounded-none text-sm w-full mt-6", items.length == 0 ? "cursor-not-allowed bg-gray-400" : "")}
                    onClick={() => items.length > 0 && this.props.placeOrder(items as CartItem[])}
                >

                    place order
                </button>
            </div>
        );
    }
}

export default CartFooter;