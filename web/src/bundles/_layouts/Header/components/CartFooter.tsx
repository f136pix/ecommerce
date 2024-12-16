import {Component} from 'react';

type CartFooterProps = {
    cartTotal: number;
};

class CartFooter extends Component<CartFooterProps> {
    render() {
        const {cartTotal} = this.props;
        return (
            <div className="border-t mt-2 pt-2 flex justify-between font-semibold">
                <span>Total:</span>
                <span>${cartTotal.toFixed(2)}</span>
            </div>
        );
    }
}

export default CartFooter;