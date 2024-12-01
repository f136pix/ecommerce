import {ComponentType, useEffect} from "react";
import HomePage from "./HomePage.tsx";
import {useHomeStore} from "./useHomeStore.tsx";
import {useNavigate, useParams} from "react-router-dom";
import {Product} from "../../types/product.ts";
import {useHeaderStore} from "../_layouts/Header/useHeaderStore.tsx";

export interface HomeProps {
    category: string;
    products: Product[]
}

const HOCWrapper = <P extends object>(Component: ComponentType<P & HomeProps>) => {
    return (props: P) => {
        const {category} = useParams<{ category: string }>();
        const {categories} = useHeaderStore();
        const navigate = useNavigate();

        const {products, fetchProducts, isLoading} = useHomeStore();

        useEffect(() => {
            if (!category) navigate("/home/all");

            if (!categories.includes(category!.toLowerCase())) {
                navigate("/home/all")
                return
            }

            navigate(`/home/${category}`);
        }, [category]);

        useEffect(() => {
                category == "all" ? fetchProducts() : fetchProducts(category)
            }, [category]
        );

        if (isLoading) return <div></div>

        return <Component {...props} category={category!} products={products}/>;
    };
};

const index = HOCWrapper(HomePage);

export default index