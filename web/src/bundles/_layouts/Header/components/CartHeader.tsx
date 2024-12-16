import {Component} from 'react';

type CartHeaderProps = {
    itemsCount: number;
};

class CartHeader extends Component<CartHeaderProps> {
    render() {
        const {itemsCount} = this.props;
        return (
            <div className="flex items-center mb-2">
                <h2 className="text-base font-semibold">My bag,</h2>
                <h3 className="ml-2 font-medium text-sm">{itemsCount} item{itemsCount == 1 ? "" : "s"}</h3>
            </div>
        );
    }
}

export default CartHeader;