import {create} from "zustand";
import content from "./content.json";

export interface IHeaderStore {
    categories: string[];
    isCartOpen: boolean;
    toggleCart: () => void;
}

const useHeaderStore = create<IHeaderStore>((set) => ({
    categories: content.categories,
    isCartOpen: false,
    toggleCart: () => set((state) => ({isCartOpen: !state.isCartOpen})),
}));

export {useHeaderStore};