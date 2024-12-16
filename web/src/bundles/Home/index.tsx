import {ComponentType, useEffect} from "react";
import HomePage from "./HomePage.tsx";
import {useHomeStore} from "./useHomeStore.tsx";
import {useNavigate, useParams} from "react-router-dom";
import {Attribute, CartItem, Product} from "../../types/product.ts";
import {useHeaderStore} from "../_layouts/Header/useHeaderStore.tsx";
import ProductService from "../../services/productService.ts";
import {useCart} from "react-use-cart";
import {toast, ToastContainer} from "react-toastify";
import {concatenateId} from "../../utils";


export interface HomeProps {
    category: string;
    products: Product[];
    navigate: (url: string) => void;
    addToCart: (product: Product) => void;
}

const HOCWrapper = <P extends object>(Component: ComponentType<P & HomeProps>) => {
    return (props: P) => {
        const {category} = useParams<{ category: string }>();
        const navigate = useNavigate();
        const {addItem, items} = useCart();
        const {categories} = useHeaderStore();
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
                toast.success("Item added successfully to the cart")
            } catch (error) {
                toast.error("An error occurred while adding the product to the cart")
            } finally {
                console.log(items);
            }
        };

        if (isLoading) return <div></div>

        return (
            <>
                <Component {...props} category={category!} products={products} navigate={navigate}
                           addToCart={HandleQuickAdd}/>
                <ToastContainer position={"bottom-center"}/>
            </>
        )
    };
};

const index = HOCWrapper(HomePage);

export default index