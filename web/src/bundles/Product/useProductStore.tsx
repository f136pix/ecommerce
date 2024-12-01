import {create} from "zustand";
import ProductService from "../../services/productService.ts";
import {Product} from "../../types/product.ts";

export interface IProductStore {
    product: Product | null;
    isLoading: boolean;
    currentImage: string | null;
    setLoading: (isLoading: boolean) => void;
    setProduct: (product: Product) => void;
    setCurrentImage: (currentImage: string) => void;
    fetchProduct: (id: string) => void;
    addProductToCart: (product: Product) => void;
}

const useProductStore = create<IProductStore>((set) => ({
    product: null,
    isLoading: false,
    currentImage: null,
    setLoading: (isLoading: boolean) => set({isLoading}),
    setProduct: (product: Product) => set({product}),
    setCurrentImage: (currentImage: string) => set({currentImage}),

    fetchProduct: async (id: string) => {
        try {
            set({isLoading: true});
            const response = await ProductService.fetchProductById(id);
            set({product: response});
        } catch (error: any) {
            console.error(error.toString());
        } finally {
            set({isLoading: false});
        }
    }
}));

export {useProductStore};