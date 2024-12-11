import {Component} from 'react';
import {HomeProps} from "./index.tsx";
import ProductsGrid from "./components/ProductsGrid.tsx";

class HomePage extends Component<HomeProps> {
    render() {
        const {category, products, addToCart, navigate} = this.props;

        return (
            <main className={"w-full mx-auto pb-12"}>
                <h1 className={"mt-16 mb-16 capitalize text-[42px]"}>{category}</h1>
                <ProductsGrid products={products} addToCart={addToCart} navigate={navigate}/>
            </main>
        );
    }
}

export default HomePage;