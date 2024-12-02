import {ComponentType, useEffect} from "react";
import {IProductStore, useProductStore} from "./useProductStore.tsx";
import ProductPage from "./ProductPage.tsx";
import {useParams} from "react-router-dom";

export interface ProductPageProps {
    productStore: IProductStore;
}

const HOCWrapper = <P extends object>(Component: ComponentType<P & ProductPageProps>) => {
    return (props: P) => {
        const store = useProductStore();
        const {id} = useParams<{ id: string }>();

        useEffect(() => {
            if(id) store.fetchProduct(id);
        }, [id]);

        if (store.isLoading || store?.product || !store) return <div></div>

        return <Component {...props} productStore={store}/>;
    };
};

const index = HOCWrapper(ProductPage);

export default index