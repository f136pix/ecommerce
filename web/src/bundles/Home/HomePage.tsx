import {Component} from 'react';
import {HomeProps} from "./index.tsx";
import ProductsGrid from "./components/ProductsGrid.tsx";
import {cn} from "../../utils";

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