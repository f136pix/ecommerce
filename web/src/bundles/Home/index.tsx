import {ComponentType, lazy, Suspense, useEffect} from "react";
import {useNavigate, useParams} from "react-router-dom";
import {toast, ToastContainer} from "react-toastify";
import {useCart} from "react-use-cart";

import ProductService from "../../services/productService.ts";
import {Attribute, CartItem, Product} from "../../types/product.ts";
import {concatenateId} from "../../utils";
import {useHeaderStore} from "../_layouts/Header/useHeaderStore.tsx";
import {useProductStore} from "../Product/useProductStore.tsx";

import {useHomeStore} from "./useHomeStore.tsx";

const HomePage = lazy(() => import("./HomePage.tsx"));

export interface HomeProps {
    category: string;
    products: Product[];
    navigate: (url: string) => void;
    addToCart: (product: Product) => void;
    isCartOpen: boolean;
}

const HOCWrapper = <P extends object>(Component: ComponentType<P & HomeProps>) => {
    return (props: P) => {
        const {category} = useParams<{ category: string }>();
        const navigate = useNavigate();
        const {addItem} = useCart();
        const {categories, toggleCart, isCartOpen} = useHeaderStore();
        const {products, fetchProducts, isLoading} = useHomeStore();
        const {resetProduct} = useProductStore();

        useEffect(() => {
            if (!category) navigate("/home/all");

            if (!categories.includes(category!.toLowerCase())) {
                navigate("/home/all");
                return;
            }

            navigate(`/home/${category}`);
        }, [category]);

        useEffect(() => {
                category == "all" ? fetchProducts() : fetchProducts(category);
            }, [category]
        );

        // Avoids image of previous product appearing on screen when switching products
        useEffect(() => {
            resetProduct();
        }, []);

        const HandleQuickAdd = async (product: Product) => {
            try {
                const fetchedProduct = await ProductService.fetchProductById(product.id, ["id", "name", "images { url } ", "attributes { name  values { id, displayValue, value } }"]);

                const productAttributeValueIds = fetchedProduct.attributes.map((attribute: Attribute) => {
                    return attribute.values[0].id;
                });

                const concatenatedId = concatenateId(productAttributeValueIds);

                const finalProduct: CartItem = {
                    id: concatenatedId,
                    name: product.name,
                    price: product.price,
                    quantity: 1,
                    productAttributeValueIds: productAttributeValueIds,
                    product: fetchedProduct
                };

                addItem(finalProduct, 1);
                toggleCart();
            } catch (error) {
                toast.error("An error occurred while adding the product to the cart");
            } finally {
                // console.log(items);
            }
        };

        if (isLoading) return <div></div>;

        return (
            <Suspense fallback={<div></div>}>
                <Component {...props} category={category!} products={products} navigate={navigate}
                           addToCart={HandleQuickAdd} isCartOpen={isCartOpen}/>
                <ToastContainer position={"bottom-center"}/>
            </Suspense>
        );
    };
};

const index = HOCWrapper(HomePage);

export default index;