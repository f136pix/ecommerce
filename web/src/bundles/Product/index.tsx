import {ComponentType, useEffect} from "react";
import {IProductStore, useProductStore} from "./useProductStore.tsx";
import ProductPage from "./ProductPage.tsx";
import {useParams} from "react-router-dom";
import {CartItem, Product} from "../../types/product.ts";
import {concatenateId} from "../../utils";
import {toast} from "react-toastify";
import {useCart} from "react-use-cart";
import {useHeaderStore} from "../_layouts/Header/useHeaderStore.tsx";

export interface ProductPageProps {
    productStore: IProductStore;
    addToCart: (product: Product, productAttributeValueIds: string[]) => void;
}

const HOCWrapper = <P extends object>(Component: ComponentType<P & ProductPageProps>) => {
    return (props: P) => {
        const store = useProductStore();
        const {id} = useParams<{ id: string }>();
        const {addItem, items} = useCart();
        const {toggleCart} = useHeaderStore();

        useEffect(() => {
            if (!id) return;
            if (id) store.fetchProduct(id);
            console.log(store.product)
        }, [id]);

        const handleAddToCart = async (product: Product, productAttributeValueIds: string[]) => {
            try {
                const concatenatedId = concatenateId(productAttributeValueIds);

                const finalProduct: CartItem = {
                    id: concatenatedId,
                    name: product.name,
                    price: product.price,
                    quantity: 1,
                    productAttributeValueIds: productAttributeValueIds,
                    product: product
                };

                addItem(finalProduct, 1);
                toggleCart()
                toast.success("Item added successfully to the cart")
            } catch (error) {
                toast.error("An error occurred while adding the product to the cart")
            } finally {
                console.log(items);
            }
        };


        if (store.isLoading || !store?.product) return <div></div>

        return <Component {...props} productStore={store} addToCart={handleAddToCart}/>;
    };
};

const index = HOCWrapper(ProductPage);

export default index