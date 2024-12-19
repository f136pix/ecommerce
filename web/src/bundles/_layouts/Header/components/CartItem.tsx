import {Component} from 'react';
import {ICartItem} from "../../../../types/product.ts";
import {CartProviderState} from "react-use-cart";
import CartItemAttributesForm from "./CartItemAttributesForm.tsx";
import CartItemQuantityForm from "./CartItemQuantityForm.tsx";
import {getSelectedValues} from "../../../../utils";

type CartItemProps = {
    item: ICartItem;
    cartStore: CartProviderState;
};

class CartItemComponent extends Component<CartItemProps> {
    constructor(props: CartItemProps) {
        super(props);
    }

    render() {
        const {item, cartStore} = this.props;
        const {updateItemQuantity} = cartStore;

        return (
            <li 
                className="flex space-x-2 justify-between text-sm mb-2 mt-6 h-auto" >
                <div className="flex flex-col space-y-2">
                    <h3 className={"font-light text-lg text-secondary"}>{item.product.name}</h3>
                    <h3 className={"font-medium"}>${item.price}</h3>
                    <CartItemAttributesForm
                        product={item.product}
                        selectedValues={getSelectedValues(item.product, item.productAttributeValueIds)}
                        cartStore={cartStore}
                        itemId={item.id}
                    />
                </div>
                <CartItemQuantityForm
                    itemId={item.id}
                    quantity={item.quantity!}
                    updateItemQuantity={updateItemQuantity}
                />
                <img src={item.product.images[0].url} alt={item.product.name} className="w-24 h-28 my-auto object-cover object-top" />
            </li>
        );
    }
}

export default CartItemComponent;;