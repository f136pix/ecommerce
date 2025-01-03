import { ComponentType, useEffect } from 'react';
import { useParams } from "react-router-dom";
import { CartProviderState, useCart } from "react-use-cart";

import { CreateOrderInput } from "../../../types/graphql";
import { CartItem } from "../../../types/product";

import Header from './Header';
import { IHeaderStore, useHeaderStore } from "./useHeaderStore";

export interface HeaderProps {
    headerStore: IHeaderStore;
    cartStore: CartProviderState;
    currentCategory: string;
    placeOrder: (input: CartItem[]) => Promise<void>;
}

const HOCWrapper = <P extends HeaderProps>(Component: ComponentType<P>) => {
    return (props: Omit<P, keyof HeaderProps>) => {
        const { category } = useParams<{ category: string }>();
        const headerStore = useHeaderStore();
        const cartStore = useCart();

        useEffect(() => {
            console.log(cartStore.items)

        }, []);

        const handlePlaceOrder = async (input: CartItem[]) => {
            try {
                const payload: CreateOrderInput = {
                    orderItems: input.map((item) => ({
                        productAttributeValueIds: item.productAttributeValueIds.map(Number),
                        amount: item.quantity
                    }))
                };

                await headerStore.placeOrder(payload);
                cartStore.emptyCart();

            } catch (error) {
                console.error("Failed to place order:", error);
            }
        };

        return <Component
            {...props as P}
            currentCategory={category!}
            placeOrder={handlePlaceOrder}
        />;
    };
};

const index = HOCWrapper(Header);

export default index;