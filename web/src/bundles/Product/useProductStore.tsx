import {create} from "zustand";
import ProductService from "../../services/productService.ts";
import {Image, Product} from "../../types/product.ts";

export interface IProductStore {
    product: Product | null;
    isLoading: boolean;
    currentImage: Image | null;
    setLoading: (isLoading: boolean) => void;
    setProduct: (product: Product) => void;
    setCurrentImage: (currentImage: Image) => void;
    fetchProduct: (id: string) => void;
    // addProductToCart: (product: Product) => void;
}

const useProductStore = create<IProductStore>((set) => ({
    product: null,
    isLoading: false,
    currentImage: null,
    setLoading: (isLoading: boolean) => set({isLoading}),
    setProduct: (product: Product) => set({product}),
    setCurrentImage: (currentImage: Image) => set({currentImage}),

    fetchProduct: async (id: string) => {
        try {
            set({isLoading: true});
            console.log(id)
            const response = await ProductService.fetchProductById(id);
            set({product: response});
            set({currentImage: response?.images[0]});
        } catch (error: any) {
            console.error(error.toString());
        } finally {
            set({isLoading: false});
        }
    }
}));

export {useProductStore};