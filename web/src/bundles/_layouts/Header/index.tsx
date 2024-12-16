import {ComponentType} from 'react';
import {useHeaderStore} from "./useHeaderStore.tsx";
import Header from './Header';
import {useNavigate, useParams} from "react-router-dom";
import {CartProviderState, useCart} from "react-use-cart";

export interface HeaderProps {
    currentCategory: string;
    categories: string[];
    navigate: (category: string) => void;
    cartStore : CartProviderState;
    toggleCart: () => void;
    isCartOpen: boolean;
}

const HOCWrapper = <P extends object>(Component: ComponentType<P & HeaderProps>) => {
    return (props: P) => {
        const {category} = useParams<{ category: string }>();
        const {categories, toggleCart, isCartOpen} = useHeaderStore();
        const cartStore = useCart();
        const navigate = useNavigate();

        const handleChange = (category: string) => {
            navigate(`/home/${category}`);
        };

        return <Component {...props} currentCategory={category!} categories={categories}
                          navigate={handleChange} toggleCart={toggleCart} isCartOpen={isCartOpen} cartStore={cartStore}/>;
    };
};

const index = HOCWrapper(Header);

export default index