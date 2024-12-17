import {create} from "zustand";
import content from "./content.json";
import orderService from "../../../services/orderService.ts";
import {CreateOrderInput} from "../../../types/graphql";

export interface IHeaderStore {
    categories: string[];
    isCartOpen: boolean;
    toggleCart: () => void;
    placeOrder: (input: CreateOrderInput) => Promise<void>;
}

const useHeaderStore = create<IHeaderStore>((set) => ({
    categories: content.categories,
    isCartOpen: false,
    toggleCart: () => set((state) => ({isCartOpen: !state.isCartOpen})),

    placeOrder: async (input: CreateOrderInput) => {
        try {
            const order = await orderService.createOrder(input);
            console.log("Order placed successfully:", order);
        } catch (error) {
            console.error("Failed to place order:", error);
            throw error
        }
    }
    
}));

export {useHeaderStore};