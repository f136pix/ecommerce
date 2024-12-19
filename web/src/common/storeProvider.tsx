import { ComponentType } from 'react';
import { useCart } from "react-use-cart";

import { useHeaderStore } from "../bundles/_layouts/Header/useHeaderStore";

// Define a common interface for the additional props
interface StoreProps {
    cartStore: ReturnType<typeof useCart>;
    headerStore: ReturnType<typeof useHeaderStore>;
}

const storeProvider = <P extends StoreProps = StoreProps>(
    Component: ComponentType<P>
) => {
    return (props: Omit<P, keyof StoreProps>) => {
        const headerStore = useHeaderStore();
        const cartStore = useCart();

        return <Component
            {...props as P}
            cartStore={cartStore}
            headerStore={headerStore}
        />;
    };
};

export default storeProvider;