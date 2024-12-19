import {create} from "zustand";
import ProductService from "../../services/productService.ts";

interface IHomeStore {
    products: any[];
    isLoading: boolean;
    setLoading: (isLoading: boolean) => void;
    setProducts: (products: any[]) => void;
    fetchProducts: (filter?: string) => void;
}

const useHomeStore = create<IHomeStore>((set) => {
    const products: any[] = [];
    const isLoading = false;
    const setProducts = (products: any[]) => set({products});
    const setLoading = (isLoading: boolean) => set({isLoading});
    const fetchProducts = async (category?: string) => {
        try {
            setLoading(true);
            const response = await ProductService.fetchProducts({
                fields: ['id', 'name', 'inStock', 'category { name }', 'price', 'images { url, position}'],
                filter: {
                    category,
                }
            });
            set({products: response})
        } catch (error: any) {
        } finally {
            set({isLoading: false});
        }
    };

    return {
        products,
        isLoading,
        setProducts,
        setLoading,
        fetchProducts
    };
});

export {useHomeStore};
