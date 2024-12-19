import {Component} from 'react';

import {cn} from "../../utils";

import ProductsGrid from "./components/ProductsGrid.tsx";
import {HomeProps} from "./index.tsx";

class HomePage extends Component<HomeProps> {
    render() {
        const {category, products, addToCart, navigate, isCartOpen} = this.props;

        return (
            <main className={cn("w-full mx-auto pb-12 px-28", isCartOpen ? "pointer-events-none" : "")}>
                <h1 className={"mt-16 mb-16 capitalize text-[42px]"}>{category}</h1>
                <ProductsGrid products={products} addToCart={addToCart} navigate={navigate}/>
            </main>
        );
    }
}

export default HomePage;