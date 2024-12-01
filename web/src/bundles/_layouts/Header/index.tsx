import {ComponentType} from 'react';
import {useHeaderStore} from "./useHeaderStore.tsx";
import Header from './Header';
import { useNavigate, useParams} from "react-router-dom";

export interface HeaderProps {
    currentCategory: string;
    categories: string[];
    navigate: (category: string) => void;
}

const HOCWrapper = <P extends object>(Component: ComponentType<P & HeaderProps>) => {
    return (props: P) => {
        const {category} = useParams<{ category: string }>();
        const {categories} = useHeaderStore();
        const navigate = useNavigate();

        const handleChange = (category: string) => {
            navigate(`/home/${category}`);
        };

        return <Component {...props} currentCategory={category!} categories={categories}
                          navigate={handleChange}/>;
    };
};

const index = HOCWrapper(Header);

export default index